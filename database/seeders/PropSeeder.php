<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Prop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Prop::factory()->create([
            'label' => __('Color'),
            'name'=>'color',
            'type'=>'color',
            'options' => '[{"title":"black","value":"#000000"},{"title":"white","value":"#ffffff"},{"title":"rose gold","value":"#be9289"},{"title":"silver","value":"#c0c0c0"},{"title":"gold","value":"#d4af37"}]',
            'searchable'=> 0,
            'priceable' => 1,
            'icon' => 'ri-palette-line',
        ]);
        Prop::factory()->create([
            'label' => __('Warranty'),
            'name'=>'warranty',
            'type'=>'select',
            'options' => '[{"title":"no warranty","value":"-1"},{"title":"Rayan","value":"1"},{"title":"Arian","value":"3"},{"title":"Avajang","value":"4"},{"title":"Sazgar Aragham","value":"5"}]',
            'searchable'=> 0,
            'priceable' => 1,
            'icon' => 'ri-shield-check-line',
        ]);
        Prop::factory()->create([
            'label' =>  __('Network'),
            'name'=>'net',
            'type'=>'multi',
            'options' => '[{"title":"2G","value":"2g"},{"title":"3G","value":"3g"},{"title":"4G","value":"4g"},{"title":"5G","value":"5g"}]',
            'searchable'=> 1,
            'priceable' => 0,
            'icon' => 'ri-signal-tower-line',
        ]);
        Prop::factory()->create([
            'label' =>  __('Internal storage'),
            'name'=>'hdd',
            'type'=>'select',
            'options' => '[{"title":"16 Gig","value":"16"},{"title":"32 Gig","value":"32"},{"title":"64 gig","value":"64"},{"title":"128 Gig","value":"128"},{"title":"256 Gig","value":"256"}]',
            'searchable'=> 1,
            'priceable' => 1,
            'icon' => 'ri-hard-drive-3-line',
        ]);
        Prop::factory()->create([
            'label' =>  __('Front camera'),
            'name'=>'fcamera',
            'type'=>'text',
            'options' => '[]',
            'searchable'=> 0,
            'priceable' => 0,
            'icon' => 'ri-camera-3-line',
        ]);
        Prop::factory()->create([
            'label' =>  __('Display technology'),
            'name'=>'lcd',
            'type'=>'text',
            'options' =>'[]',
            'searchable'=> 0,
            'priceable' => 0,
            'icon' => 'ri-smartphone-line',
        ]);
        Prop::factory()->create([
            'label' =>  __('Sim card count'),
            'name'=>'sim',
            'type'=>'number',
            'options' =>'[]',
            'searchable'=> 1,
            'priceable' => 0,
            'icon' => 'ri-sim-card-2-line',
        ]);
        Prop::factory()->create([
            'label' =>  __('Support SD card'),
            'name'=>'sdcard',
            'type'=>'checkbox',
            'options' =>'[]',
            'searchable'=> 1,
            'priceable' => 0,
            'icon' => 'ri-sd-card-line',
        ]);

        Category::where('id',1)->first()->props()->sync(Prop::pluck('id')->toArray());
        Category::where('id',2)->first()->props()->sync(Prop::pluck('id')->toArray());

    }
}
