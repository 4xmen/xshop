<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Group;
use App\Models\Post;
use App\Models\Product;
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
                        $item->name = ucfirst(str_replace('-', ' ', $tempName[0])) . ' model ' . $item->id;
                    }
                    $item->addMedia($images[0]->getRealPath())
                        ->preservingOriginal() //middle method
                        ->toMediaCollection(); //finishing method
                    $item->save();
                }
                break;
            case 'Category':
                foreach (Category::all() as $item) {
                    $this->info('Category: ' . $item->name . ' adding image...');
                    shuffle($images);
                    if (!\File::exists(storage_path().'/app/public/categories/')){
                        mkdir(storage_path().'/app/public/categories/', 0755, true);
                    }
                    \File::copy($images[0]->getRealPath(),storage_path().'/app/public/categories/' . $images[0]->getFilename());
                    $item->image = $images[0]->getFilename();
                    $i = Image::load($images[0]->getRealPath())
                        ->optimize()
                        ->format('webp');
                    $i->save(storage_path() . '/app/public/categories/optimized-'. $item->image);
                    shuffle($images);
                    \File::copy($images[0]->getRealPath(),storage_path().'/app/public/categories/' . $images[0]->getFilename());
                    $item->bg = $images[0]->getFilename();
                    $i = Image::load($images[0]->getRealPath())
                        ->optimize()
                        ->format('webp');
                    $i->save(storage_path() . '/app/public/categories/optimized-'. $item->bg);
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
                    $i = Image::load($images[0]->getRealPath())
                        ->optimize()
                        ->format('webp');
                    $i->save(storage_path() . '/app/public/groups/optimized-'. $item->image);
                    shuffle($images);
                    \File::copy($images[0]->getRealPath(),storage_path().'/app/public/groups/' . $images[0]->getFilename());
                    $item->bg = $images[0]->getFilename();
                    $i = Image::load($images[0]->getRealPath())
                        ->optimize()
                        ->format('webp');
                    $i->save(storage_path() . '/app/public/groups/optimized-'. $item->bg);
                    $item->save();
                }
                break;
            case 'Post':
                foreach (Post::all() as $item) {
                    $this->info('post: ' . $item->id . ' adding image...');
                    shuffle($images);
                    $name = $images[0]->getFilename();
                    $item->addMedia($images[0]->getRealPath())
                        ->preservingOriginal() //middle method
                        ->toMediaCollection(); //finishing method
                    $item->save();
                }
                break;
            default:
                $this->error('Model not valid');
        }
    }
}
