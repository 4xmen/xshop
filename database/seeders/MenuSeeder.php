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
               'title' => "Home",
               'meta' => '/',
               'user_id' => 1,
               'kind'=>'direct',
           ],
           [
               'title' => "News",
               'menuable_id' => 1,
               'menuable_type' => Group::class,
               'user_id' => 1,
           ],
           [
               'title' => "Contact",
               'meta' => '/contact-us',
               'user_id' => 1,
               'kind'=>'direct',
           ],
           [
               'title' => "About",
               'meta' => '/about-us',
               'user_id' => 1,
               'kind'=>'direct',
           ],
        ]);
    }
}
