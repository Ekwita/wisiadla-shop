<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ShopCart;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShopCartRepository
{
    /**
     * Adding product to the cart
     */
    public function store(Request $request, User $user, array $validateData): RedirectResponse
    {
        $product = Product::where('id', $request->product)->first();
        $shopCart = ShopCart::where([
            ['user_id', $user->id],
            ['product_id', $request->product]
        ])->first();

        /**
         * Exists of shop cart validation
         * Creating a shopping cart if it does not exist.
         * Adding product to the shop cart if shopping cart exist.
         */
        if ($shopCart == null) {
            $cart = new ShopCart($validateData);
            $cart->save();

            return $this->redirectWithStatus();
        } else {
            if ($shopCart->quantity + $request->quantity <= $product->amount) {
                $shopCart->increment('quantity', $request->quantity);

                return $this->redirectWithStatus();
            } else {
                return redirect()->route('shop.index')->with('status', 'quantity_error');
            }
        }
    }

    private function redirectWithStatus(): RedirectResponse
    {
        return redirect()->route('shop.index')->with('status', 'added');
    }
}
