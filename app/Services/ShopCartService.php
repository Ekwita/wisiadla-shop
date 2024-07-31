<?php

namespace App\Services;

use App\Repositories\ShopCartRepository;
use Illuminate\Http\RedirectResponse;

class ShopCartService
{
protected $shopCartRepository;

public function __construct(ShopCartRepository $shopCartRepository)
{
    $this->shopCartRepository = $shopCartRepository;
}
    public function storeCart($request):RedirectResponse
    {
        $user = $request->user();
        $validateData = [
            'user_id' => $user->id,
            'product_id' => $request->product,
            'quantity' => $request->quantity,
        ];
        return $this->shopCartRepository->store($request, $user, $validateData);
    }
}