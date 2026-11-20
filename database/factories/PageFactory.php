<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $icons = PostFactory::$icons;
        shuffle($icons);
        return [
            'title' => $this->faker->sentence(),
            'subtitle' => $this->faker->text(40),
            'slug' => $this->faker->unique()->slug(),
            'body' => $this->faker->paragraph(),
            'icon' => $icons[0],
            'parent_id' => null,
        ];
    }
}
