<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Xmen\StarterKit\StarterKitFacade;

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
    public function definition()
    {

        $rand = rand(1,2);
        $title = ($rand == 1?'موبایل':'تبلت').' ' . $this->faker->unique()->realText(50);
        return [
            //
            'name' => $title,
            'slug' => StarterKitFacade::slug($title),
            'excerpt' => $this->faker->realText(150),
            'user_id' => 1,
            'cat_id' => $rand,
            'description' => $this->faker->realText(600),
        ];
    }
}
