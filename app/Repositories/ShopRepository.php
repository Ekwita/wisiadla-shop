<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ShopRepository
{
    public function search(string $name): Collection
    {
        $products = Product::where('name', 'like', '%' . $name . '%')
        ->orWhere('description', 'like', '%' . $name . '%')
        ->get();

        return $products;
    }
}