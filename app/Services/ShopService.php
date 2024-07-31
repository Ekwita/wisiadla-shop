<?php

namespace App\Services;

use App\Repositories\CRUD\ProductRepository;
use App\Repositories\ShopRepository;
use Illuminate\Database\Eloquent\Collection;

class ShopService
{
    protected $productRepository;
    protected $shopRepository;

    public function __construct(ProductRepository $productRepository, ShopRepository $shopRepository)
    {
        $this->productRepository = $productRepository;
        $this->shopRepository = $shopRepository;
    }

    public function getAllProducts(): Collection
    {
        return $this->productRepository->getAll();
    }

    public function searchProduct($name)
    {
        return $this->shopRepository->search($name);
    }
}
