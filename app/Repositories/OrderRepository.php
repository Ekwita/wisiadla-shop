<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository
{
    public function createOrder(User $user): Order
    {
        $newOrder = new Order([
            'user_id' => $user->id,
            'total_price' => 0,
        ]);
        $newOrder->save();
        return $newOrder;
    }

    public function newOrderItem($orderItem, $newOrder, $product): void
    {
        $newOrderItem = new OrderItem([
            'order_id' => $newOrder->id,
            'product_id' => $orderItem->product_id,
            'quantity' => $orderItem->quantity,
            'total_price' => $product->price * $orderItem->quantity
        ]);
        $newOrderItem->save();
    }

    public function setOrderTotalPrice($newOrder): Order
    {
        $orderTotalPrice = 0;
        $items = $this->getTotalPricesFromOrderItems($newOrder);
        foreach ($items as $item) {
            $orderTotalPrice += $item->total_price;
        }

        $newOrder->update([
            'total_price' => $orderTotalPrice,
        ]);

        return $newOrder;
    }

    private function getTotalPricesFromOrderItems($newOrder): Collection
    {
        $items = OrderItem::where('order_id', $newOrder->id)->get();
        return $items;
    }
}
