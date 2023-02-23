<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Xmen\StarterKit\Models\Menu;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Storage::deleteDirectory('public');
        Storage::makeDirectory('public');
        //seo settings


        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            CatSeeder::class,
            PostSeeder::class,
            MenuSeeder::class,
            PropSeeder::class,
            ProductSeeder::class,
//            InvoiceSeeder::class,
//            SliderSeeder::class,
            SettingSeeder::class,
            MenuSeeder::class,
        ]);
    }
}
