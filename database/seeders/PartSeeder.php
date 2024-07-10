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
        $part->area_id = Area::where('name','preloader')->first()->id;
        $part->save();

    }
}
