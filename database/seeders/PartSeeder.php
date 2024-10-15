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
        $part->segment = 'products';
        $part->part = 'LatestProducts';
        $part->area_id = Area::where('name', 'index')->first()->id;
        $part->sort = 2;
        $part->save();

        $part = new Part();
        $part->segment = 'posts';
        $part->part = 'PostsIconSimple';
        $part->area_id = Area::where('name', 'index')->first()->id;
        $part->sort = 3;
        $part->save();

        $part = new Part();
        $part->segment = 'index';
        $part->part = 'CounterGrid';
        $part->area_id = Area::where('name', 'index')->first()->id;
        $part->sort = 4;
        $part->save();

        $part = new Part();
        $part->segment = 'categories';
        $part->part = 'CategoriesFavImageLinks';
        $part->area_id = Area::where('name', 'index')->first()->id;
        $part->sort = 5;
        $part->save();

        $part = new Part();
        $part->segment = 'posts';
        $part->part = 'PostIndexImage';
        $part->area_id = Area::where('name', 'index')->first()->id;
        $part->sort = 6;
        $part->save();


        $part = new Part();
        $part->segment = 'footer';
        $part->part = 'WaveFooter';
        $part->area_id = Area::where('name', 'index')->first()->id;
        $part->sort = 7;
        $part->save();


        // -------------------------------------------------------------
        // default header and footer
        $part = new Part();
        $part->segment = 'menu';
        $part->part = 'AplMenu';
        $part->area_id = Area::where('name', 'defaultHeader')->first()->id;
        $part->sort = 0;
        $part->save();


        $part = new Part();
        $part->segment = 'header';
        $part->part = 'SimpleHeader';
        $part->area_id = Area::where('name', 'defaultHeader')->first()->id;
        $part->sort = 0;
        $part->save();

        $part = new Part();
        $part->segment = 'footer';
        $part->part = 'WaveFooter';
        $part->area_id = Area::where('name', 'defaultFooter')->first()->id;
        $part->sort = 2;
        $part->save();

        // -------------------------------------------------------------

        $part = new Part();
        $part->segment = 'card';
        $part->part = 'NsCard';
        $part->area_id = Area::where('name', 'card')->first()->id;
        $part->sort = 1;
        $part->save();

        // -------------------------------------------------------------




        $part = new Part();
        $part->segment = 'products_page';
        $part->part = 'ProductGridSidebar';
        $part->area_id = Area::where('name', 'products-list')->first()->id;
        $part->sort = 1;
        $part->save();




        // -------------------------------------------------------------



        $part = new Part();
        $part->segment = 'product';
        $part->part = 'ProductKaren';
        $part->area_id = Area::where('name', 'product')->first()->id;
        $part->sort = 1;
        $part->save();

        // -------------------------------------------------------------



        $part = new Part();
        $part->segment = 'products_page';
        $part->part = 'ProductGridSidebar';
        $part->area_id = Area::where('name', 'category')->first()->id;
        $part->sort = 1;
        $part->save();



        // -------------------------------------------------------------



        $part = new Part();
        $part->segment = 'posts_page';
        $part->part = 'GridPostListSidebar';
        $part->area_id = Area::where('name', 'posts-list')->first()->id;
        $part->sort = 1;
        $part->save();



        // -------------------------------------------------------------




        $part = new Part();
        $part->segment = 'post';
        $part->part = 'PostSidebar';
        $part->area_id = Area::where('name', 'post')->first()->id;
        $part->sort = 1;
        $part->save();



        // -------------------------------------------------------------


        $part = new Part();
        $part->segment = 'clips_page';
        $part->part = 'ClipListGrid';
        $part->area_id = Area::where('name', 'clips-list')->first()->id;
        $part->sort = 1;
        $part->save();
        // -------------------------------------------------------------


        $part = new Part();
        $part->segment = 'posts_page';
        $part->part = 'GridPostListSidebar';
        $part->area_id = Area::where('name', 'group')->first()->id;
        $part->sort = 1;
        $part->save();


        // -------------------------------------------------------------


        $part = new Part();
        $part->segment = 'invoice';
        $part->part = 'LianaInvoice';
        $part->area_id = Area::where('name', 'invoice')->first()->id;
        $part->sort = 1;
        $part->save();

        // -------------------------------------------------------------

        $part = new Part();
        $part->segment = 'clip';
        $part->part = 'DorClip';
        $part->area_id = Area::where('name', 'clip')->first()->id;
        $part->sort = 1;
        $part->save();

        // -------------------------------------------------------------

        $part = new Part();
        $part->segment = 'galleries_page';
        $part->part = 'GalleriesList';
        $part->area_id = Area::where('name', 'galleries-list')->first()->id;
        $part->sort = 1;
        $part->save();



        // -------------------------------------------------------------

        $part = new Part();
        $part->segment = 'gallery';
        $part->part = 'GallaryGrid';
        $part->area_id = Area::where('name', 'gallery')->first()->id;
        $part->sort = 1;
        $part->save();



        // -------------------------------------------------------------

        $part = new Part();
        $part->segment = 'compare';
        $part->part = 'CompareProducts';
        $part->area_id = Area::where('name', 'compare')->first()->id;
        $part->sort = 1;
        $part->save();


        // -------------------------------------------------------------

        $part = new Part();
        $part->segment = 'login';
        $part->part = 'LoginPatternBg';
        $part->area_id = Area::where('name', 'login')->first()->id;
        $part->sort = 1;
        $part->save();

        // -------------------------------------------------------------

        $part = new Part();
        $part->segment = 'register';
        $part->part = 'SimpleRegister';
        $part->area_id = Area::where('name', 'register')->first()->id;
        $part->sort = 1;
        $part->save();

        // -------------------------------------------------------------

        $part = new Part();
        $part->segment = 'customer';
        $part->part = 'AvisaCustomer';
        $part->area_id = Area::where('name', 'customer')->first()->id;
        $part->sort = 1;
        $part->save();

        // -------------------------------------------------------------

        $part = new Part();
        $part->segment = 'attachments_page';
        $part->part = 'DenaAttachList';
        $part->area_id = Area::where('name', 'attachments-list')->first()->id;
        $part->sort = 1;
        $part->save();

        // -------------------------------------------------------------

        $part = new Part();
        $part->segment = 'attachment';
        $part->part = 'AttachmentWithPreview';
        $part->area_id = Area::where('name', 'attachment')->first()->id;
        $part->sort = 1;
        $part->save();

        // -------------------------------------------------------------

        $part = new Part();
        $part->segment = 'contact';
        $part->part = 'MeloContact';
        $part->area_id = Area::where('name', 'contact-us')->first()->id;
        $part->sort = 1;
        $part->save();

        // -------------------------------------------------------------

        $part = new Part();
        $part->segment = 'product_grid';
        $part->part = 'DefaultProductGrid';
        $part->area_id = Area::where('name', 'product-grid')->first()->id;
        $part->sort = 1;
        $part->save();


    }
}
