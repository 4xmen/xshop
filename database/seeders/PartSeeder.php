<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Part;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $part = new Part();
        $part->segment = 'preloader';
        $part->part = 'PreloaderCircle';
        $part->area_id = Area::where('name', 'preloader')->first()->id;
        $part->save();

        // -------------------------------------------------------------

        $part = new Part();
        $part->segment = 'menu';
        $part->part = 'RecetMenu';
        $part->area_id = Area::where('name', 'index')->first()->id;
        $part->sort = 0;
        $part->save();

        $part = new Part();
        $part->segment = 'slider';
        $part->part = 'SliderSimple';
        $part->area_id = Area::where('name', 'index')->first()->id;
        $part->sort = 1;
        $part->save();

        $part = new Part();
        $part->segment = 'posts';
        $part->part = 'PostsIconSimple';
        $part->area_id = Area::where('name', 'index')->first()->id;
        $part->sort = 2;
        $part->save();

        $part = new Part();
        $part->segment = 'index';
        $part->part = 'CounterGrid';
        $part->area_id = Area::where('name', 'index')->first()->id;
        $part->sort = 3;
        $part->save();

        $part = new Part();
        $part->segment = 'categories';
        $part->part = 'CategoriesFavImageLinks';
        $part->area_id = Area::where('name', 'index')->first()->id;
        $part->sort = 4;
        $part->save();

        $part = new Part();
        $part->segment = 'posts';
        $part->part = 'PostIndexImage';
        $part->area_id = Area::where('name', 'index')->first()->id;
        $part->sort = 5;
        $part->save();


        $part = new Part();
        $part->segment = 'footer';
        $part->part = 'WaveFooter';
        $part->area_id = Area::where('name', 'index')->first()->id;
        $part->sort = 6;
        $part->save();


        // -------------------------------------------------------------

        $part = new Part();
        $part->segment = 'header';
        $part->part = 'SimpleHeader';
        $part->area_id = Area::where('name', 'card')->first()->id;
        $part->sort = 0;
        $part->save();

        $part = new Part();
        $part->segment = 'card';
        $part->part = 'NsCard';
        $part->area_id = Area::where('name', 'card')->first()->id;
        $part->sort = 1;
        $part->save();

        $part = new Part();
        $part->segment = 'footer';
        $part->part = 'WaveFooter';
        $part->area_id = Area::where('name', 'card')->first()->id;
        $part->sort = 2;
        $part->save();

        // -------------------------------------------------------------

        $part = new Part();
        $part->segment = 'header';
        $part->part = 'SimpleHeader';
        $part->area_id = Area::where('name', 'products-list')->first()->id;
        $part->sort = 0;
        $part->save();

        $part = new Part();
        $part->segment = 'products_page';
        $part->part = 'ProductGridSidebar';
        $part->area_id = Area::where('name', 'products-list')->first()->id;
        $part->sort = 1;
        $part->save();

        $part = new Part();
        $part->segment = 'footer';
        $part->part = 'WaveFooter';
        $part->area_id = Area::where('name', 'products-list')->first()->id;
        $part->sort = 2;
        $part->save();


        // -------------------------------------------------------------


        $part = new Part();
        $part->segment = 'header';
        $part->part = 'SimpleHeader';
        $part->area_id = Area::where('name', 'product')->first()->id;
        $part->sort = 0;
        $part->save();

        $part = new Part();
        $part->segment = 'product';
        $part->part = 'ProductKaren';
        $part->area_id = Area::where('name', 'product')->first()->id;
        $part->sort = 1;
        $part->save();

        $part = new Part();
        $part->segment = 'footer';
        $part->part = 'WaveFooter';
        $part->area_id = Area::where('name', 'product')->first()->id;
        $part->sort = 2;
        $part->save();


        // -------------------------------------------------------------


        $part = new Part();
        $part->segment = 'header';
        $part->part = 'SimpleHeader';
        $part->area_id = Area::where('name', 'posts-list')->first()->id;
        $part->sort = 0;
        $part->save();

        $part = new Part();
        $part->segment = 'posts_page';
        $part->part = 'GridPostListSidebar';
        $part->area_id = Area::where('name', 'posts-list')->first()->id;
        $part->sort = 1;
        $part->save();

        $part = new Part();
        $part->segment = 'footer';
        $part->part = 'WaveFooter';
        $part->area_id = Area::where('name', 'posts-list')->first()->id;
        $part->sort = 2;
        $part->save();

        // -------------------------------------------------------------


        $part = new Part();
        $part->segment = 'header';
        $part->part = 'SimpleHeader';
        $part->area_id = Area::where('name', 'post')->first()->id;
        $part->sort = 0;
        $part->save();

        $part = new Part();
        $part->segment = 'post';
        $part->part = 'PostSidebar';
        $part->area_id = Area::where('name', 'post')->first()->id;
        $part->sort = 1;
        $part->save();

        $part = new Part();
        $part->segment = 'footer';
        $part->part = 'WaveFooter';
        $part->area_id = Area::where('name', 'post')->first()->id;
        $part->sort = 2;
        $part->save();


    }
}
