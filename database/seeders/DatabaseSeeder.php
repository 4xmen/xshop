<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Post;
use App\Models\State;
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
                UserSeeder::class,
                GroupSeeder::class,
                PostSeeder::class,
                StateSeeder::class,
                CustomerSeeder::class,
            ]
        );
    }
}
