<?php

namespace Database\Factories;
use Xmen\StarterKit\StarterKitFacade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'name' => $this->faker->word,
            'slug' => StarterKitFacade::slug($this->faker->unique()->word),
            'parent_id' => null,
            'sort' => 0,
            'description' => $this->faker->realText(350),
        ];
    }
}
