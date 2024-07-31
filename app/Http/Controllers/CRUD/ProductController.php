<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Services\CRUD\ProductService;
use App\Models\Product;
use App\Services\CRUD\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Log::info('Listing all products');
        $products = $this->productService->getAllProducts();

        return view('crud.products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Log::info('Showing form to create a new product');
        $categories = $this->categoryService->getAllCategory();

        return view('crud.products.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info('Storing a new product');
        $this->productService->storeProduct($request);

        Log::info('Product stored successfully');
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        Log::info('Showing product details');
        return view('crud.products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        Log::info('Showing form to edit product');
        $categories = $this->categoryService->getAllCategory();

        return view('crud.products.edit', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        Log::info('Updating product');
        $this->productService->updateProduct($request, $product);

        Log::info('Product updated successfully');
        return redirect()->route('products.index')->with('status', 'product-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        Log::info('Deleting product');
        $this->productService->destroyProduct($product);

        Log::info('Product deleted successfully');
        return redirect()->back();
    }
}
