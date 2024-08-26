<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{

    public function check(){
        if (Customer::count() == 0){
            Customer::factory(1)->create();
        }
    }
    /**
     * A basic feature test example.
     */
    public function test_customer_profile(): void
    {

        $this->check();
        $response = $this->actingAs(Customer::inRandomOrder()->first(),'customer')->get(route('client.profile'));

        $response->assertStatus(200);
    }
}
