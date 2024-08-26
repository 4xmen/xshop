<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SiteMapTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_sitemap(): void
    {
        $response = $this->get(route('sitemap'));

        $response->assertStatus(200);
    }
}
