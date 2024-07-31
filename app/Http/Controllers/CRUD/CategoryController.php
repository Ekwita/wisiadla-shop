<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::all();
        return view('crud.categories.index', [
            'categories' => $categories
        ]);
    }

    public function create(): View
    {
        return view('crud.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->validateData($request);
        $category = new Category($validatedData);
        $category->save();

        return redirect()->route('categories.index');
    }

    public function edit(Category $category): View
    {
        return view('crud.categories.edit', ['category' => $category]);
    }
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validatedData = $this->validateData($request);
        $category->update($validatedData);
        $category->save();

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $products = Product::where('category_id', $category->id)->get();

        foreach ($products as $product) {
            $product->category_id = null;
            $product->save();
        }

        $category->delete();

        return redirect()->route('categories.index');
    }

    private function validateData($request): array
    {
        $rules = [
            'name' => 'required'
        ];

        $validatedData = $request->validate($rules);
        return $validatedData;
    }
}
