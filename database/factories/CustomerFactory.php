<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $state = rand(1,31);

        $k = array_keys(Address::$cities[$state]);
        shuffle($k);
        return [
            //
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'mobile' => '0912'.rand(1111111,9999999),
            'email' => $this->faker->unique()->email,
            'state' => $state,
            'city' => $k[0],
            'password' => bcrypt('password'),
            'credit' => 0,
        ];
    }
}
