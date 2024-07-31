<?php

namespace App\Http\Controllers;

use App\Services\CRUD\CategoryService;
use App\Services\ShopService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{

    // protected $categoryService;
    // protected $shopService;

    public function __construct(protected CategoryService $categoryService, protected ShopService $shopService)
    {
        // $this->categoryService = $categoryService;
        // $this->shopService = $shopService;
    }

    public function index(): View
    {
        $categories = $this->categoryService->getAllCategory();
        $products = $this->shopService->getAllProducts();

        return view('welcome', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function search(Request $request): View
    {
        $categories = $this->categoryService->getAllCategory();
        $query = $request->query;
        $name = $query->all();
        $name = implode($name);

        $products = $this->shopService->searchProduct($name);

        return view('welcome', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
