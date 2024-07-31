<?php

namespace App\Services\CRUD;

use App\Repositories\CRUD\ProductRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ProductService
{

    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function getAllProducts(): LengthAwarePaginator
    {
        return $this->productRepository->getAllPaginate();
    }

    public function storeProduct($request): void
    {
        $validatedData = $this->validateData($request);
        $imagePath = $this->imagePath($request);
        $this->productRepository->store($validatedData, $imagePath);
    }

    public function updateProduct($request, $product): void
    {
        $validatedData = $this->validateData($request);

        $imagePathUpdate = $this->imagePath($request);
        $oldImagePath = $product->image_path_main;
        $this->productRepository->update($validatedData, $imagePathUpdate, $oldImagePath, $product);
    }

    public function destroyProduct($product): void
    {
        $this->productRepository->destroy($product);
    }

    public function increaseProductQuantity($order): void
    {
        $this->productRepository->amountIncrease($order);
    }

    private function validateData($request): array
    {
        $rules = [
            'name' => 'required|max:100',
            'description' => 'required|max:300',
            'amount' => 'required|min:0',
            'price' => 'required|min:0',
            'category_id' => 'nullable|integer|min:0'
        ];

        $validatedData = $request->validate($rules);
        return $validatedData;
    }

    private function imagePath($request): string|null
    {
        if ($request->hasFile('image_main')) {
            $image_path = $request->file('image_main')->store();
            return $image_path;
        }
        return null;
    }
}
