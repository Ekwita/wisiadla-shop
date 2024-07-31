<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CRUD\AdminOrderController;
use App\Http\Controllers\CRUD\CategoryController;
use App\Http\Controllers\CRUD\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CRUD\UserController;
use App\Http\Controllers\ShopCartController;
use App\Http\Controllers\UserOrderController;
use Illuminate\Support\Facades\Route;

/**
 * Routing for all
 */

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/search', [ShopController::class, 'search'])->name('shop.search');

Route::get('/contact', function () {
    return view('addons.contact');
})->name('shop.contact');

Route::get('/terms', function () {
    return view('addons.terms');
})->name('shop.terms');

/**
 * Routing for users
 */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/order_confirmed', function () {
    return view('orders.confirm');
})->middleware(['auth', 'verified'])->name('orders.confirm');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/address', [AddressController::class, 'checkAddressExists'])->name('profile.address');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * Cart services
 */
Route::middleware('auth')->group(function () {
    Route::get('/cart', [ShopCartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [ShopCartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{cart}', [ShopCartController::class, 'delete'])->name('cart.delete');
});

/**
 * User orders services
 */
Route::middleware('auth')->group(function () {
    Route::get('/your-orders', [UserOrderController::class, 'index'])->name('user.orders.index');
    Route::get('/cart/confirm', [UserOrderController::class, 'orderConfirmation'])->name('order.confirm');
    Route::post('/cart/order', [UserOrderController::class, 'createOrder'])->name('order.create');
    Route::get('cart/order/{order}', [UserOrderController::class, 'show'])->name('order.show');
});

/**
 * Routing for admin
 */
Route::middleware(['auth', 'can:isAdmin'])->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index')->name('products.index');
        Route::get('/products/create', 'create')->name('products.create');
        Route::post('/products', 'store')->name('products.store');
        Route::get('/products/{product}', 'show')->name('products.show');
        Route::delete('/products/{product}', 'destroy')->name('products.delete');
        Route::get('/products/{product}/edit', 'edit')->name('products.edit');
        Route::patch('/products/{product}', 'update')->name('products.update');
    });
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index');
        Route::patch('/users/{user}/update', 'update')->name('users.update');
    });
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'index')->name('categories.index');
        Route::get('/categories/create', 'create')->name('categories.create');
        Route::post('/categories/create', 'store')->name('categories.store');
        Route::delete('/categories/{category}/delete', 'destroy')->name('categories.delete');
        Route::get('/categories/{category}/edit', 'edit')->name('categories.edit');
        Route::patch('/categories/{category}/edit', 'update')->name('categories.update');
    });
    Route::controller(AdminOrderController::class)->group(function () {
        Route::get('/orders', 'index')->name('orders.index');
        Route::patch('/orders/{order}/update', 'update')->name('orders.status.update');
    });
});

/**
 * Another functions
 */

Route::fallback(function () {
    return redirect()->route('shop.index');
});

require __DIR__ . '/auth.php';
