<?php

namespace App\Repositories\CRUD;

use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class ProductRepository
{
    /**
     * Get all products form database
     */
    public function getAll(): Collection
    {
        return Product::all();
    }

    /**
     * Get all products from database and paginate
     */
    public function getAllPaginate(): LengthAwarePaginator
    {
        return Product::paginate(20);
    }

    /**
     * Add new product do database
     */
    public function store(array $validatedData, string $imagePath): void
    {
        $product = new Product($validatedData);
        $product->image_path_main = $imagePath;
        $this->save($product);
    }

    /**
     * Update product in database
     */
    public function update(array $validatedData, string $imagePathUpdate, string $oldImagePath, Product $product): void
    {
        $product->update($validatedData);

        $this->updateImage($imagePathUpdate, $oldImagePath, $product);

        $this->save($product);
    }

    /**
     * Remove product from database
     */
    public function destroy($product): void
    {
        $product->carts()->delete();
        if ($product->image_path_main) {
            if (Storage::exists($product->image_path_main)) {
                Storage::delete($product->image_path_main);
            }
        }
        $product->delete();
    }

    /**
     * Increase the quantity of the product in the database
     */
    public function amountIncrease($order): void
    {
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        foreach ($orderItems as $item) {
            Product::where('id', $item->product_id)->increment('amount', $item->quantity);
        }
    }

    private function updateImage(string $imagePathUpdate, string $oldImagePath, $product): void
    {
        if ($imagePathUpdate !== null && $oldImagePath !== null) {
            if (Storage::exists($oldImagePath)) {
                Storage::delete($oldImagePath);
            }
            $product->image_path_main = $imagePathUpdate;
        }
    }
    /**
     * Save the data
     */
    private function save(Product $product): void
    {
        $product->save();
    }
}
