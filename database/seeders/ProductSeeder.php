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

        Product::factory()->count(15)->create();
        $products = Product::all();
        foreach ($products as $product) {
            $cats = Cat::inRandomOrder()->limit(3)->pluck('id');
            $product->categories()->sync($cats);
            $num = rand(1, 7);
            $product->addMedia(__DIR__ . "/img/ps$num.jpg")->preservingOriginal()->toMediaCollection();
            $num = rand(1, 7);
            $product->addMedia(__DIR__ . "/img/ps$num.jpg")->preservingOriginal()->toMediaCollection();
            $product->cat_id = rand(1, 2);
        }
    }
}
