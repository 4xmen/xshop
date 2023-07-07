<?php

namespace Database\Seeders;

use App\Models\Cat;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $plans = [
            1 => [
                'dir' => __DIR__ . "/img/1/",  // fake images
                'main' => 8, // main cat
                'cats' => [1, 8, 4], // all cats
                'max' => 12, // max images for seed
            ],
            2 => [
                'dir' => __DIR__ . "/img/2/",  // fake images
                'main' => 9, // main cat
                'cats' => [1, 9, 4], // all cats
                'max' => 12, // max images for seed
            ],
            3 => [
                'dir' => __DIR__ . "/img/3/",  // fake images
                'main' => 9, // main cat
                'cats' => [1, 9, 4], // all cats
                'max' => 10, // max images for seed
            ],
            4 => [
                'dir' => __DIR__ . "/img/4/",  // fake images
                'main' => 1, // main cat
                'cats' => [1, 5], // all cats
                'max' => 10, // max images for seed
            ],
            5 => [
                'dir' => __DIR__ . "/img/4/",  // fake images
                'main' => 2, // main cat
                'cats' => [2, 5], // all cats
                'max' => 10, // max images for seed
            ],
            6 => [
                'dir' => __DIR__ . "/img/4/",  // fake images
                'main' => 6, // main cat
                'cats' => [6, 5], // all cats
                'max' => 10, // max images for seed
            ],
        ];
        Product::factory()->count(31)->create();
        $products = Product::all();
        foreach ($products as $product) {
//            $cats = Cat::inRandomOrder()->limit(3)->pluck('id');
//            $product->categories()->sync($cats);
            if ($product->id < 6) {
                $plan = 1;
            } else if ($product->id < 11) {
                $plan = 2;
            } else if ($product->id < 16) {
                $plan = 3;
            } else if ($product->id < 21) {
                $plan = 4;
            } else if ($product->id < 26) {
                $plan = 5;
            } else {
                $plan = 6;
            }
            $product->categories()->sync($plans[$plan]['cats']);
            if (env('PIC_SEED') !== '0'){
                $num = rand(1, $plans[$plan]['max']);
                $product->addMedia($plans[$plan]['dir'] . "$num.jpg")->preservingOriginal()->toMediaCollection();
                $num = rand(1, $plans[$plan]['max']);
                $product->addMedia($plans[$plan]['dir'] . "$num.jpg")->preservingOriginal()->toMediaCollection();
            }
            $product->cat_id = $plans[$plan]['main'];
            $product->save();
        }
    }
}
