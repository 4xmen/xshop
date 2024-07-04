<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $areas = [
            [
                'name' => 'preloader',
                'valid_segments' => json_encode(
                    ['preloader']
                ),
                'max' => 1,
                'icon' => 'ri-loader-2-line',
            ],
            [
                'name' => 'top',
                'valid_segments' => json_encode(
                    ['top']
                ),
                'max' => 1,
                'icon' => 'ri-layout-top-2-line',
            ],
        ];
        foreach ($areas as $area){
            $a = new Area();
            $a->name = $area['name'];
            $a->max = $area['max'];
            $a->valid_segments = $area['valid_segments'];
            $a->icon = $area['icon'];
            $a->save();
        }
    }
}
