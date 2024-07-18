<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date =  $this->faker->dateTimeBetween('-1 months', 'now');
        $c = Customer::inRandomOrder()->first();
        return [
            'customer_id' => $c->id,
            'status' => Invoice::$invoiceStatus[rand(0,count(Invoice::$invoiceStatus)-1)],
            'desc' => $this->faker->realText(),
            'address_id' => $c->addresses()->inRandomOrder()->first()->id,
            'transport_id' => null,
            'transport_price' => 0,
            'created_at' => $date,
            'updated_at' => $date,
            'total_price' => 0,
        ];
    }
}
