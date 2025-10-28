<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\XController;
use App\Models\Category;
use App\Models\Creator;
use App\Models\Group;
use App\Models\Post;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Console\Command;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Enums\Unit;
use Spatie\Image\Image;

class SeedingImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seeding:image {model} {directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeding image model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!\File::exists(__DIR__ . '/../../../database/seeders/images/' . $this->argument('directory'))) {
            $this->error('Directory not found');
            exit();
        }

        $images = \File::files(__DIR__ . '/../../../database/seeders/images/' . $this->argument('directory'));
        switch ($this->argument('model')) {
            case 'Product':
                foreach (Product::all() as $item) {
                    $this->info('Product: ' . $item->id . ' adding image...');
                    shuffle($images);
                    if ($item->media()->count() == 0){
                        $name = $images[0]->getFilename();
                        $tempName = explode('.', $name);
                        $item->name = readable($tempName[0]) . ' model ' . $item->id;
                        $item->slug = sluger($item->name);
                    }
                    $item->status = 1;
                    $item->addMedia($images[0]->getRealPath())
                        ->preservingOriginal() //middle method
                        ->toMediaCollection(); //finishing method
                    $item->save();
                }
                break;
            case 'Category':
                $svgs = \File::files(__DIR__ . '/../../../database/seeders/images/svg');

                foreach (Category::all() as $item) {
                    $this->info('Category: ' . $item->name . ' adding image...');
                    shuffle($images);
                    if (!\File::exists(storage_path().'/app/public/categories/')){
                        mkdir(storage_path().'/app/public/categories/', 0755, true);
                    }
                    \File::copy($images[0]->getRealPath(),storage_path().'/app/public/categories/' . $images[0]->getFilename());
                    $item->image = $images[0]->getFilename();
                    XController::saveOptimizedImage($item,'image','categories',$images[0]->getRealPath());
                    shuffle($images);
                    \File::copy($images[0]->getRealPath(),storage_path().'/app/public/categories/' . $images[0]->getFilename());
                    $item->bg = $images[0]->getFilename();

                    XController::saveOptimizedImage($item,'bg','categories',$images[0]->getRealPath());
                    shuffle($svgs);
                    \File::copy($svgs[0]->getRealPath(),storage_path().'/app/public/categories/' . $svgs[0]->getFilename());
                    $item->svg = $svgs[0]->getFilename();
                    $item->save();
                }
                break;
            case 'Group':
                foreach (Group::all() as $item) {
                    $this->info('Group: ' . $item->name . ' adding image...');
                    shuffle($images);
                    if (!\File::exists(storage_path().'/app/public/groups/')){
                        mkdir(storage_path().'/app/public/groups/', 0755, true);
                    }
                    \File::copy($images[0]->getRealPath(),storage_path().'/app/public/groups/' . $images[0]->getFilename());
                    $item->image = $images[0]->getFilename();
                    XController::saveOptimizedImage($item,'image','groups',$images[0]->getRealPath());
                    shuffle($images);
                    \File::copy($images[0]->getRealPath(),storage_path().'/app/public/groups/' . $images[0]->getFilename());
                    $item->bg = $images[0]->getFilename();
                    XController::saveOptimizedImage($item,'bg','groups',$images[0]->getRealPath());
                    $item->save();
                }
                break;
            case 'Creator':
                foreach (Creator::all() as $item) {
                    $this->info('Creator: ' . $item->name . ' adding image...');
                    shuffle($images);
                    if (!\File::exists(storage_path().'/app/public/creator/')){
                        mkdir(storage_path().'/app/public/creator/', 0755, true);
                    }
                    \File::copy($images[0]->getRealPath(),storage_path().'/app/public/creator/' . $images[0]->getFilename());
                    $item->image = $images[0]->getFilename();
                    XController::saveOptimizedImage($item,'image','creator',$images[0]->getRealPath());
                    $item->save();
                }
                break;
            case 'Slider':
                foreach (Slider::all() as $item) {
                    $this->info('Slider: ' . $item->name . ' adding image...');
                    shuffle($images);
                    if (!\File::exists(storage_path().'/app/public/sliders/')){
                        mkdir(storage_path().'/app/public/sliders/', 0755, true);
                    }
                    \File::copy($images[0]->getRealPath(),storage_path().'/app/public/sliders/' . $images[0]->getFilename());
                    $item->image = $images[0]->getFilename();
                    XController::saveOptimizedImage($item,'image','sliders',$images[0]->getRealPath());
                    $item->status = 1;
                    $item->save();
                }
                break;
            case 'Post':
                foreach (Post::all() as $item) {
                    $this->info('post: ' . $item->id . ' adding image...');
                    shuffle($images);
                    $item->addMedia($images[0]->getRealPath())
                        ->preservingOriginal() //middle method
                        ->toMediaCollection(); //finishing method
                    $item->save();
                    $item->status = 1;
                }
                break;
            default:
                $this->error('Model not valid');
        }
    }
}
