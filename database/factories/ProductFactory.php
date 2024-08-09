<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rand = rand(1,2);
        $title = ($rand == 1?'mobile':'Tablet').' ' . $this->faker->unique()->firstNameFemale;
        return [
            //
            'name' => $title,
            'slug' => sluger($title),
            'excerpt' => $this->faker->realText(150),
            'user_id' => 1,
            'category_id' => $rand,
            'description' => $this->faker->realText(600),
            'stock_quantity' => rand(1,7),
            'price' => rand(1,100),
            'sku' => $this->faker->unique()->ean8(),
        ];
    }
}
