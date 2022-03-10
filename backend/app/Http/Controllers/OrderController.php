<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\DeliveryDestination;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private $products_in_cart; //カートに追加したすべての商品
    private $delivery_destinations; //納品先

    public function orderDetail(Request $request)
    {
        $cart = new Cart;

        $this->products_in_cart = $cart->getProductsInTheCart($request);
        $this->delivery_destinations = \App\Models\DeliveryDestination::All()->where('user_id', Auth::id());

        $data = [
            'products_in_cart'          => $this->products_in_cart,
            'delivery_destinations'     => $this->delivery_destinations,
        ];
        return view('order/orderDetail', $data);
    }
}
