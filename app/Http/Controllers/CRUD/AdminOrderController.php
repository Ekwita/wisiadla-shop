<?php

namespace App\Http\Controllers\CRUD;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Mail\OrderStatusMail;
use App\Models\Order;
use App\Services\CRUD\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdminOrderController extends Controller
{

    public function __construct(
        protected ProductService $productService
    ) {}
    public function index(): View
    {
        $orders = Order::with('orderItems')->orderByDesc('created_at')->paginate(5);

        return view('crud.orders.index', [
            'orders' => $orders
        ]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $user = $order->user;
        $status = $request->status;
        $order->update(['status' => $status]);
        
        if ($status == OrderStatusEnum::CANCELLED) {
            $this->productService->increaseProductQuantity($order);
        }
        
        try {
            Mail::to($user->email)->send(new OrderStatusMail($user, $order));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')->with('status', 'email-failed');
        }
        return redirect()->route('orders.index')->with('status', 'status-updated');
    }
}
