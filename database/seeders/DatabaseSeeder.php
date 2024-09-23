<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Storage::deleteDirectory('public');
        Storage::makeDirectory('public');
        file_put_contents(storage_path('app/public/.gitignore'),'*
!.gitignore
');

        $this->call([
                XLangSeeder::class,
                UserSeeder::class,
                GroupSeeder::class,
                PostSeeder::class,
                StateSeeder::class,
                CustomerSeeder::class,
                CategorySeeder::class,
                PropSeeder::class,
                ProductSeeder::class,
                CommentSeeder::class,
                SettingSeeder::class,
                GfxSeeder::class,
                AreaSeeder::class,
                InvoiceSeeder::class,
                VisitorSeeder::class,
                TransportSeeder::class,
                MenuSeeder::class,
                SliderSeeder::class,
                PartSeeder::class,
                EvaluationSeeder::class,
            ]
        );
    }
}
