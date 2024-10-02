<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Product::factory()->count(31)->create();

        foreach (Product::all() as $product) {
            $product->categories()->sync(Category::inRandomOrder()->limit(3)->pluck('id')->toArray());
            $product->save();
        }
    }
}
