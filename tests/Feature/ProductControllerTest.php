<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_screen_can_be_rendered(): void
    {
        $admin = User::factory()->create([
            'role' => 'Admin'
        ]);

        $response = $this->actingAs($admin)->get(route('products.index'));
        $response->assertStatus(200);
        $response->assertViewIs('crud.products.index');

        $products = Product::all();
        foreach ($products as $product) {
            $response->assertSee($product->name);
            $response->assertSee($product->price);
            $response->assertSee($product->amount);
            $response->assertSee($product->category->name);
        }
    }

    public function test_create(): void
    {
        $admin = User::factory()->create([
            'role' => 'Admin'
        ]);

        $response = $this->actingAs($admin)->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertViewIs('crud.products.create');
    }

    public function test_store(): void
    {
        $admin = User::factory()->create([
            'role' => 'Admin'
        ]);

        $category = Category::factory()->create();
        $data = [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10.99,
            'amount' => 100,
            // 'image_path_main' => 'route',
            'category_id' => $category->id
        ];

        Log::info('Before post request', $data);
        $response = $this->actingAs($admin)->withSession(['_token' => csrf_token()])->post(route('products.store'), $data);
        Log::info('After post request', ['response' => $response->getContent()]);


        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(302);
        $response->assertRedirectToRoute('products.index');
    }

    public function test_show_screen_can_be_rendered(): void
    {
        $admin = User::factory()->create([
            'role' => 'Admin'
        ]);
        $products = Product::factory()->count(8)->create();
        foreach ($products as $product) {
            $response = $this->actingAs($admin)->get(route('products.show', $product->id));

            $response->assertStatus(200);
            $response->assertViewIs('crud.products.show');

            $response->assertSee($product->name);
            $response->assertSee($product->description);
            $response->assertSee($product->price);
            $response->assertSee($product->amount);
        }
    }

    public function test_edit(): void
    {
        $admin = User::factory()->create([
            'role' => 'Admin'
        ]);
        $products = Product::factory()->count(8)->create();
        foreach ($products as $product) {
            $response = $this->actingAs($admin)->get(route('products.edit', $product->id));

            $response->assertStatus(200);
            $response->assertViewIs('crud.products.edit');

            $response->assertSee($product->name);
            $response->assertSee($product->description);
            $response->assertSee($product->price);
            $response->assertSee($product->amount);
        }
    }

    public function test_can_update_product_on_database(): void
    {
        $admin = User::factory()->create([
            'role' => 'Admin'
        ]);
        Category::factory()->count(3)->create();
        Product::factory()->count(1)->create();
        $category = Category::first();
        $product = Product::first();
        $update = [
            'name' => 'Name update',
            'description' => 'Description update',
            // 'image_path_main' => 'PathUpdate',
            'price' => 2,
            'amount' => 1000,
            'category_id' => $category->id,
        ];

        $response = $this->actingAs($admin)->post(route('products.update', $product->id), $update);

        $this->assertDatabaseHas('products', $update);

        $response->assertStatus(302);
        $response->assertRedirectToRoute('products.index');
    }

    public function test_destroy_can_destroy_objects(): void
    {
        $admin = User::factory()->create([
            'role' => 'Admin'
        ]);
        Product::factory()->count(20)->create();
        $products = Product::all();
        $response = $this->actingAs($admin)->get(route('products.index'));
        foreach ($products as $product) {
            $response = $this->actingAs($admin)->delete(route('products.delete', $product->id));
        }
        $this->assertDatabaseEmpty('products');
        $response->assertStatus(302);
        $response->assertRedirectToRoute('products.index');
    }
}
