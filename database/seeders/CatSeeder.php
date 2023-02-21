<?php

namespace Database\Seeders;

use App\Models\Cat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Cat::factory()->create(['name' => 'موبایل','slug' => 'موبایل']);
        Cat::factory()->create(['name' => 'تبلت','slug' => 'تبلت']);
        Cat::factory()->create(['name' => 'برندها','slug' => 'برندها']);
        Cat::factory()->create(['name' => 'اپل','slug' => 'اپل', 'parent_id' => 3]);
        Cat::factory()->create(['name' => 'سامسونگ','slug' => 'سامسونگ', 'parent_id' => 3]);
        Cat::factory()->create(['name' => 'PC','slug' => 'PC']);
        Cat::factory()->create(['name' => 'آی‌مک','slug' => 'iMac', 'parent_id' => 6]);
        Cat::factory()->create(['name' => 'آیفون','slug' => 'iphone', 'parent_id' => 1]);
        Cat::factory()->create(['name' => 'آی‌پد','slug' => 'iPad', 'parent_id' => 2]);
    }
}
