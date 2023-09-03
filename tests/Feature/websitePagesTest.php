<?php

namespace Tests\Feature;

use App\Models\Cat;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Xmen\StarterKit\Models\Post;

class websitePagesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_products()
    {
        $response = $this->get(route('products'));

        $response->assertStatus(200);
    }
    public function test_posts()
    {
        $response = $this->get(route('posts'));

        $response->assertStatus(200);
    }
    public function test_single_post()
    {
        $response = $this->get(route('post',Post::inRandomOrder()->first()->slug));

        $response->assertStatus(200);
    }
    public function test_single_product()
    {
        $response = $this->get(route('product',Product::inRandomOrder()->first()->slug));

        $response->assertStatus(200);
    }

    public function test_single_product_category()
    {
        $response = $this->get(route('cat',Cat::inRandomOrder()->first()->slug));
        $response->assertStatus(200);
    }

    public function test_card_empty(){
        $this->get(route('reset'));
        $response = $this->get(route('card.show'));
        $response->assertStatus(200);
    }
    public function test_card_with_products(){
        $this->get(route('card.add',Product::inRandomOrder()->first()->slug));
        $this->get(route('card.add',Product::inRandomOrder()->first()->slug));
        $response = $this->get(route('card.show'));
        $response->assertStatus(200);
    }
}
