<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visitor>
 */
class VisitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $displays = ['1920x1080','1366x768','1920x1080','1366x768','1280x1024',null, null];
        $date = $this->faker->dateTimeBetween('-31 days', 'now');
        return [
            //
            'ip' => $this->faker->ipv4(),
            'visit' => rand(1,rand(2,12)),
            'browser' => rand(0,5),
            'os' => rand(0,14),
            'version' => rand(100,132),
            'display' => $displays[count($displays)-1],
            'updated_at' => $date,
            'created_at' => $date,
        ];
    }
}
