<?php

namespace Database\Seeders;

use App\Models\Gfx;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GfxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $array = [
            [
                'key'=>'background',
                'label'=>'background color',
                'system'=>'1',
                'value'=> '#eeeeee'
            ],
            [
                'key'=>'primary',
                'label'=>'Primary color',
                'system'=>'1',
                'value'=> '#03b2b5'
            ],
            [
                'key'=>'secondary',
                'label'=>'Secondary color',
                'system'=>'1',
                'value'=> '#0064c2'
            ],
            [
                'key'=>'text',
                'label'=>'Text color',
                'system'=>'1',
                'value'=> '#111111'
            ],
            [
                'key'=>'dark',
                'label'=>'Theme mode',
                'system'=>'1',
                'value'=> '0'
            ],
            [
                'key'=>'border-radius',
                'label'=>'Border radius',
                'system'=>'1',
                'value'=> '7px'
            ],
            [
                'key'=>'shadow',
                'label'=>'Shadow',
                'system'=>'1',
                'value'=> '2px 2px 4px #777777'
            ],
            [
                'key'=>'container',
                'label'=>'Container',
                'system'=>'1',
                'value'=> 'container'
            ],
            [
                'key'=>'font',
                'label'=>'font',
                'system'=>'1',
                'value'=> 'Vazir'
            ],

        ];


        foreach ($array as $item) {
            $item['created_at'] = date('Y-m-d H:i:s');
            Gfx::insert($item);
        }
    }
}
