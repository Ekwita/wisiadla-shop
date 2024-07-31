<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ShopCart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopCartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_without_logged_user(): void
    {
        $response = $this->get(route('cart.index'));

        $response->assertStatus(302);
        $response->assertRedirectToRoute('login');
    }
    public function test_index_with_empty_cart(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('cart.index'));
        $response->assertStatus(200);
        $response->assertViewIs('carts.index');

        $response->assertViewHas('carts', function ($carts) {
            return $carts->isEmpty();
        });
    }

    public function test_index_with_carts(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $cart = ShopCart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        $response = $this->actingAs($user)->get(route('cart.index'));

        $response->assertStatus(200);
        $response->assertViewIs('carts.index');
        $response->assertViewHas('carts', function ($carts) use ($cart) {
            return $carts->contains($cart);
        });
    }

    public function test_is_store_method_working(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $response = $this->actingAs($user)->post(route('cart.store', ['product' => $product]));
        
        $response->assertStatus(302);
    }
}
