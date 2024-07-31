<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_shop_view_is_render(): void
    {
        Product::factory()->count(25)->create();

        $response = $this->get(route('shop.index'));
        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

    public function test_product_is_searched(): void
    {
        Product::factory()->count(5)->create();
        $product = Product::first();

        $response = $this->get(route('shop.search', ['name' => $product->name]));
        $response->assertStatus(200);
        $response->assertViewIs('welcome');
        $response->assertSeeText($product->name);
    }
    public function test_product_is_not_found(): void
    {
        Product::factory()->count(5)->create();

        $response = $this->get(route('shop.search', ['name' => 'NonExistentProductName']));
        $response->assertStatus(200);
        $response->assertViewIs('welcome');
        $response->assertDontSeeText('NonExistentProductName');
    }
}
