<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function create(): void
    {
        $orderItem = new OrderItem();
        $orderItem->save();
    }
}
