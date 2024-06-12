<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->realText(75);
        return [
            //
            'title' => $title,
            'slug' => sluger($title),
            'subtitle' => $this->faker->realText(),
            'body' => $this->faker->realText(500),
            'group_id' => Group::inRandomOrder()->first()->id,
            'hash' => str_pad(dechex(crc32($title)), 8, '0', STR_PAD_LEFT),
            'status' => rand(0,1),
            'view' => rand(0,999),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
