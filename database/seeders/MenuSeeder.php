<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Xmen\StarterKit\Models\Menu;
use Xmen\StarterKit\StarterKitFacade;


class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //
        $m = new Menu();
        $m->name = 'menu';
        $m->user_id = 1;
        $m->save();
//        $cat = New \Xmen\StarterKit\Models\Category();
//        $cat->name = 'درباره‌ما';
//        $cat->slug = StarterKit::slug('درباره‌ما');
//        $cat->save();
//        $cat = New \Xmen\StarterKit\Models\Category();
//        $cat->name = 'تماس با ما';
//        $cat->slug = StarterKit::slug('تماس با ما');
//        $cat->save();
//        $cat = New \Xmen\StarterKit\Models\Category();
//        $cat->name = 'پشتیبانی';
//        $cat->slug = StarterKit::slug('پشتیبانی');
//        $cat->save();
//        $m->menuItems()->create(
//            [
//                'title' => 'صفحه اصلی',
//                'menuable_id' => null,
//                'menuable_type' => null,
//                'kind' => 'link',
//                'meta' => '/',
//                'parent' => null,
//                'sort' => 0,
//                'user_id' => 1,
//            ]
//        );
        $m->menuItems()->create(
            [
                'title' => 'درباره ما',
                'menuable_id' => 1,
                'menuable_type' => 'App\Category',
                'kind' => 'cat',
                'meta' => '',
                'parent' => null,
                'sort' => 1,
                'user_id' => 1,
            ]
        );
        $m->menuItems()->create(
            [
                'title' => 'تماس با ما',
                'menuable_id' => 2,
                'menuable_type' => 'App\Models\Category',
                'kind' => 'cat',
                'meta' => '',
                'parent' => null,
                'sort' => 1,
                'user_id' => 1,
            ]
        );
    }
}
