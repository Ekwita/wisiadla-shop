<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Repositories\OrderRepository;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }


    public function create($request, $orderItems): null|Order
    {
        if (!$this->validateStockStatus($orderItems)) {
            return null;
        } else {
            $user = $request->user();
            $newOrder = $this->orderRepository->createOrder($user);
            $this->addProductToOrder($orderItems, $newOrder);
            $this->orderRepository->setOrderTotalPrice($newOrder);

            return $newOrder;
        }
    }

    /** 
     * Walidacja stanów magazynowych i wartości w koszyku
     * */
    private function validateStockStatus($orderItems): bool
    {
        foreach ($orderItems as $orderItem) {
            $product = Product::find($orderItem->product_id);
            if ($product->amount < $orderItem->quantity) {
                return false;
            }
        }
        return true;
    }
    private function addProductToOrder($orderItems, $newOrder): void
    {
        foreach ($orderItems as $orderItem) {
            $product = Product::find($orderItem->product_id);
            $this->orderRepository->newOrderItem($orderItem, $newOrder, $product);

            // Zmniejsz ilość produktu na magazynie
            $product->decrement('amount', $orderItem->quantity);

            // Usuń pozycję z koszyka
            $orderItem->delete();
        }
    }

    private function setTotalPrice()
    {

    }
}
