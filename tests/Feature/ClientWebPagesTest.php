<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Group;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientWebPagesTest extends TestCase
{

    public function test_web_client_index(): void
    {
        $response = $this->get(route('client.welcome'));

        $response->assertStatus(200);
    }

    public function test_web_client_posts(): void
    {
        $response = $this->get(route('client.posts'));

        $response->assertStatus(200);
    }

    public function test_web_client_products(): void
    {
        $response = $this->get(route('client.products'));

        $response->assertStatus(200);
    }

    public function test_web_client_product(): void
    {

        if (Product::count() == 0) {
            Product::factory(1)->create();
        }
        $response = $this->get(Product::first()->webUrl());
        $response->assertStatus(200);
    }

    public function test_web_client_post(): void
    {

        if (Post::count() == 0) {
            Post::factory(1)->create();
        }
        $response = $this->get(Post::first()->webUrl());
        $response->assertStatus(200);
    }

    public function test_web_client_group(): void
    {

        if (Group::count() == 0) {
            Group::factory(1)->create();
        }
        $response = $this->get(Group::first()->webUrl());
        $response->assertStatus(200);
    }
    public function test_web_client_category(): void
    {

        if (Category::count() == 0) {
            Category::factory(1)->create();
        }
        $response = $this->get(Category::first()->webUrl());
        $response->assertStatus(200);
    }
}
