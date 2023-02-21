<?php

namespace Database\Seeders;

use App\Models\Cat;
use App\Models\Prop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        Prop::factory()->count(60)->create();
        Prop::factory()->create([
            'label' => 'رنگ',
            'name'=>'color',
            'type'=>'color',
            'options' => '[{"title":"black","value":"#000000"},{"title":"white","value":"#ffffff"},{"title":"rose gold","value":"#be9289"},{"title":"silver","value":"#c0c0c0"},{"title":"gold","value":"#d4af37"}]',
            'searchable'=> 0,
            'priceable' => 1
        ]);
        Prop::factory()->create([
            'label' => 'گارانتی',
            'name'=>'warranty',
            'type'=>'select',
            'options' => '[{"title":"no warranty","value":"-1"},{"title":"Rayan","value":"1"},{"title":"Arian","value":"3"},{"title":"Avajang","value":"4"},{"title":"Sazgar Aragham","value":"5"}]',
            'searchable'=> 0,
            'priceable' => 1
        ]);
        Prop::factory()->create([
            'label' => 'شبکه ارتباطی',
            'name'=>'net',
            'type'=>'multi',
            'options' => '[{"title":"2G","value":"2g"},{"title":"3G","value":"3g"},{"title":"4G","value":"4g"},{"title":"5G","value":"5g"}]',
            'searchable'=> 1,
            'priceable' => 0
        ]);
        Prop::factory()->create([
            'label' => 'حافظه داخلی',
            'name'=>'hdd',
            'type'=>'select',
            'options' => '[{"title":"16 Gig","value":"16"},{"title":"32 Gig","value":"32"},{"title":"64 gig","value":"64"},{"title":"128 Gig","value":"128"},{"title":"256 G","value":"256"}]',
            'searchable'=> 1,
            'priceable' => 1
        ]);
        Prop::factory()->create([
            'label' => 'دوربین جلو',
            'name'=>'fcamera',
            'type'=>'text',
            'options' => '[]',
            'searchable'=> 0,
            'priceable' => 0
        ]);
        Prop::factory()->create([
            'label' => 'فناوری صفحه‌نمایش',
            'name'=>'lcd',
            'type'=>'text',
            'options' =>'[]',
            'searchable'=> 0,
            'priceable' => 0
        ]);
        Prop::factory()->create([
            'label' => 'تعداد سیم کارت',
            'name'=>'sim',
            'type'=>'number',
            'options' =>'[]',
            'searchable'=> 1,
            'priceable' => 0
        ]);
        Prop::factory()->create([
            'label' => 'پشتیبانی از کارت حافظه',
            'name'=>'sdcard',
            'type'=>'checkbox',
            'options' =>'[]',
            'searchable'=> 1,
            'priceable' => 0
        ]);

        Cat::where('id',1)->first()->props()->sync(Prop::pluck('id')->toArray());
        Cat::where('id',2)->first()->props()->sync(Prop::pluck('id')->toArray());

    }
}
