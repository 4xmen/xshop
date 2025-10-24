<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Menu::factory(['name' => 'main-menu'])->create();

        Menu::first()->items()->createMany([
           [
               'title' => __("Home"),
               'meta' => '/',
               'user_id' => 1,
               'kind'=>'direct',
               'icon'=>'ri-home-2-line',
           ],
           [
               'title' => __("News"),
               'menuable_id' => 1,
               'menuable_type' => Group::class,
               'kind'=>'module',
               'user_id' => 1,
               'icon'=>'ri-news-line',
           ],
           [
               'title' => __("Products"),
               'meta' => '/products',
               'user_id' => 1,
               'kind'=>'direct',
               'icon'=>'ri-barcode-line',
           ],
           [
               'title' => __("Contact us"),
               'meta' => '/contact-us',
               'user_id' => 1,
               'kind'=>'direct',
               'icon'=>'ri-phone-line',
           ],
        ]);
    }
}
