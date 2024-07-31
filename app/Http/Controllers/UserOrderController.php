<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderMail;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShopCart;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class UserOrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $orders = Order::with('orderItems')->where('user_id', $user->id)->orderByDesc('id')->get();

        return view('orders.index', ['orders' => $orders]);
    }

    /**
     * View order summary and confirmation
     */
    public function orderConfirmation(Request $request): View
    {
        $user = $request->user();
        $items = $this->getProductsForCart($request);
        $address = Address::where('user_id', $user->id)->first();
        return view('carts.summary', ['user' => $user, 'items' => $items, 'address' => $address]);
    }

    /**
     * Creating new order
     */
    public function createOrder(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        $orderItems = $this->getProductsForCart($request);

        // Creating a new order
        $newOrder = $this->orderService->create($request, $orderItems);
        if ($newOrder !== null) {
            $items = OrderItem::where('order_id', $newOrder->id)->get();
            // Mail::to($user->email)->send(new NewOrderMail($newOrder, $user, $items));
            return redirect()->intended(route('orders.confirm', absolute: false));
        } else {
            return redirect()->back()->with('status', 'quantity_error');
        }
    }

    public function show(Order $order): View
    {
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        return view('orders.show', ['order' => $order, 'items' => $orderItems]);
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
}
