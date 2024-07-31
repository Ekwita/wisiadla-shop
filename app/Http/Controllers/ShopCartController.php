<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\ShopCart;
use App\Services\OrderService;
use App\Services\ShopCartService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopCartController extends Controller
{
    const MAX_QUANTITY_CHANGE = 1;
    const PRODUCT_UNAVAILABLE = 2;

    public function __construct(protected ShopCartService $shopCartService, protected OrderService $orderService)
    {}

    /**
     * Viewing your shopping cart
     */
    public function index(Request $request): View
    {
        $carts = $this->getProductsForCart($request);

        if ($this->maxQuantityValidation($carts) == self::MAX_QUANTITY_CHANGE) {
            session()->flash('status', 'maxQuantityChange');
        } else if ($this->maxQuantityValidation($carts) == self::PRODUCT_UNAVAILABLE) {
            session()->flash('status', 'productUnavailable');
        }
        return view('carts.index', ['carts' => $carts]);
    }

    /**
     * Adding product to the cart
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->shopCartService->storeCart($request);
    }

    /**
     * Getting products form cart
     */
    private function getProductsForCart(Request $request): Collection
    {
        $user = $request->user();
        $carts = ShopCart::where('user_id', $user->id)->get();
        return $carts;
    }

    /**
     * Cart status validation.
     * If the value of the goods in the basket is greater than the stock level - change.
     * If the item is out of stock - remove the item from the cart
     */
    private function maxQuantityValidation(Collection $carts): int
    {
        $flag = 0;
        foreach ($carts as $cart) {
            if ($cart->quantity > $cart->product->amount && $cart->product->amount != 0) {
                $this->changeMaxQuantity($cart);
                $flag = 1;
            } else if ($cart->quantity >= $cart->product->amount && $cart->product->amount == 0) {
                $this->deleteProductFromCart($cart);
                $flag = 2;
            }
        }
        return $flag;
    }

    private function changeMaxQuantity(ShopCart $cart): void
    {
        $cart->update([
            'quantity' => $cart->product->amount,
        ]);
        $cart->save();
    }

    private function deleteProductFromCart($cart): void
    {
        $cart->delete();
    }

    public function delete(ShopCart $cart): RedirectResponse
    {
        $cart->delete();

        return redirect()->route('cart.index')->with('status', 'cart-deleted');
    }
}
