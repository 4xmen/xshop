<?php

namespace App\Console\Commands;

use App\Http\Controllers\XController;
use App\Models\Category;
use App\Models\Creator;
use App\Models\Group;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Redirect;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class xShift extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xshift {action} {url?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'xshift migrate from wordpress';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //

        $action = $this->argument('action');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        switch ($action) {

            case 'clear':
                if (app()->environment('production')) {
                    $this->error('this command clear not available in production mode');
                    return 1;
                }
                if (!$this->confirm('Are you sure you want to clear all data?')) {
                    $this->info('This command canceled');
                    return 0;
                }
                DB::query("TRUNCATE `category_product`;");
                DB::query("TRUNCATE `group_post`;");
                Category::truncate();
                Group::truncate();
                Post::truncate();
                Post::truncate();
                Creator::truncate();
                Invoice::truncate();
                Order::truncate();
                Product::truncate();
                break;
            case 'category':
                if (Category::count() > 0) {
                    $this->error("The table must be empty to migrate");
                    return 2;
                }
                Category::truncate();
                \Storage::deleteDirectory('public/categories');
                \Storage::makeDirectory('public/categories');
                \Storage::deleteDirectory('public/optimized/categories');
                $data = $this->fetchData('/product-categories');
                foreach ($data as $category) {
                    $c = new Category();
                    $c->id = $category->id;
                    $c->name = $category->title;
                    $c->description = $category->description;
                    $c->slug = urldecode($category->slug);
                    $c->parent_id = $category->parent_id == 0 ? null : $category->parent_id;
                    $c->save();
                    $this->checkRedirect($category->link, $c->webUrl());
                    if ($category->thumbnail != null) {
                        $path = parse_url($category->thumbnail, PHP_URL_PATH);
                        $info = pathinfo($path);
                        $temp = tempnam(sys_get_temp_dir(), 'TMP_');
                        if ($this->downloadToTemp($category->thumbnail, $temp)) {
                            \File::copy($temp, storage_path() . '/app/public/categories/' . $info['basename']);
                            $c->image = $info['basename'];
                            $c->save();
                            XController::saveOptimizedImage($c, 'image', 'categories', storage_path() . '/app/public/categories/' . $info['basename']);
                        } else {
                            $this->info('Error image download:', $category->thumbnail);
                        }
                    }
                }
                break;
            case 'group':
                if (Group::count() > 0) {
                    $this->error("The table must be empty to migrate");
                    return 2;
                }
                Group::truncate();
                \Storage::deleteDirectory('public/groups');
                \Storage::makeDirectory('public/groups');
                \Storage::deleteDirectory('public/optimized/groups');
                $data = $this->fetchData('/categories');
                foreach ($data as $group) {
                    $g = new Group();
                    $g->id = $group->id;
                    $g->name = $group->title;
                    $g->description = $group->description;
                    $g->slug = urldecode($group->slug);
                    $g->parent_id = $group->parent_id == 0 ? null : $group->parent_id;
                    $g->save();
                    $this->checkRedirect($group->link, $g->webUrl());
                }
                break;
            case 'post':
                if (Post::count() > 0) {
                    $this->error("The table must be empty to migrate");
                    return 2;
                }
                Post::truncate();
                $data = $this->fetchData('/posts');
                foreach ($data as $post) {
                    $p = new Post();
                    $p->id = $post->id;
                    $p->title = $post->title;
                    $p->slug = urldecode($post->slug);
                    $p->body = $post->content;
                    $p->subtitle = $post->excerpt;
                    $p->group_id = $post->categories[0];
                    $p->user_id = User::first()->id;
                    $p->status = 1;
                    $p->hash = date('Ym') . str_pad(dechex(crc32($post->slug)), 8, '0', STR_PAD_LEFT);

                    if ($post->featured_image != false) {
                        $temp = tempnam(sys_get_temp_dir(), 'TMP_');
                        if ($this->downloadToTemp($post->featured_image, $temp)) {
                            $p->addMedia($temp)
                                ->preservingOriginal() //middle method
                                ->toMediaCollection();
                        }
                    }
                    $p->syncTags($post->tags);
                    $p->groups()->attach($post->categories);
                    $p->created_at = $post->date;
                    $p->save();
                    $this->checkRedirect($post->link, $p->webUrl());


                }
                break;
            case 'product':
                if (Product::count() > 0) {
                    $this->error("The table must be empty to migrate");
                    return 2;
                }
                Product::truncate();
                $data = $this->fetchData('/products');
                foreach ($data as $product) {
                    $p = new Product();
                    $p->id = $product->id;
                    $p->name = $product->name;
                    $p->slug = urldecode($product->slug);
                    $p->description = $product->description;
                    $p->excerpt = $product->short_description;
                    $p->category_id = $product->product_category_ids[0];
                    $p->user_id = User::first()->id;
                    $p->status = 1;
                    if ($product->sku != null) {
                        $p->sku = $product->sku;
                    }
                    if ($product->count != null) {
                        $p->stock_quantity = $product->count;
                    }

                    if ($product->price != null) {
                        $p->price = $product->price;
                    }


                    switch ($product->stock) {
                        case 'instock':
                            $p->stock_status = 'IN_STOCK';
                            break;
                        case 'onbackorder':
                            $p->stock_status = 'BACK_ORDER';
                            break;
                        case 'outofstock':
                            $p->stock_status = 'OUT_STOCK';
                            break;
                    }

                    foreach ($product->images as $image) {
                        $temp = tempnam(sys_get_temp_dir(), 'TMP_');
                        if ($this->downloadToTemp($image, $temp)) {
                            $p->addMedia($temp)
                                ->preservingOriginal() //middle method
                                ->toMediaCollection();
                        }
                    }
                    $p->categories()->attach($product->product_category_ids);
                    $p->created_at = $product->date;
                    $p->save();
                    $this->checkRedirect($product->link, $p->webUrl());
                    // WIP: additional_informations

                }
                break;
            default:
                $this->error("unknown action");

        }


    }

    /**
     * get json data
     * @param string $url
     * @return false|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchData(string $url)
    {
        if ($this->argument('url') == null) {
            $this->error('url is necessary to migrate');
            return false;
        }
        $req = trim($this->argument('url'), '/') . '/wp-json/xshift/v1' . $url;
        $x = new Client();
        $response = $x->request('GET', $req);

        $body = $response->getBody()->getContents();

        $data = json_decode($body, false);

        return $data;
    }


    /**
     * download a file from a given url and save it to the specified path.
     *
     * @param string $url full url of the file (e.g. https://example.com/image.jpg)
     * @param string $fullPath absolute path where the file should be stored
     * @return bool            true on success, false on failure
     */
    function downloadToTemp(string $url, string $fullPath): bool
    {
        try {
            // create a guzzle client with timeout and streaming enabled
            $client = new Client([
                'timeout' => 30,
                'stream' => true,
            ]);

            // send a GET request; do not throw exceptions for 4xx/5xx responses
            $response = $client->request('GET', $url, [
                'http_errors' => false,
            ]);

            // if the response is not 200, treat it as a failure
            if ($response->getStatusCode() !== 200) {
                return false;
            }

            // ensure the directory for the target file exists
            $dir = dirname($fullPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            // write the response stream to the file in chunks
            $bodyStream = $response->getBody();
            $handle = fopen($fullPath, 'wb');
            if ($handle === false) {
                return false;
            }

            while (!$bodyStream->eof()) {
                fwrite($handle, $bodyStream->read(8192));
            }

            fclose($handle);
            $bodyStream->close();

            return true;
        } catch (\Throwable $e) {
            // optional: log the error
            // logger()->error($e);
            return false;
        }
    }

    /**
     * Returns only the path component of a URL.
     *
     * @param string $url The full URL (e.g. "http://wp.test/category/uncategorized/")
     * @return string     The path (e.g. "/category/uncategorized/")
     */
    function getUrlPath(string $url): string
    {
        // Parse the URL and get the path component
        $path = parse_url($url, PHP_URL_PATH);

        // Ensure the path starts with a slash
        if ($path === null) {
            return '/';
        }
        return '/' . ltrim($path, '/');
    }

    public function checkRedirect($old, $new)
    {

        $old = $this->getUrlPath($old);
        $new = $this->getUrlPath($new);
        if (trim($old,'/') !== trim($new,'/')) {
            $r = new Redirect();
            $r->source = rtrim($old,'/');
            $r->destination = $new;
            $r->status = 1;
            $r->expire = date('y-m-d', strtotime('+180 days'));
            $r->save();
        }
    }

}
