<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\DeliveryDestination;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private $products_in_cart; //カートに追加したすべての商品
    private $delivery_destinations; //納品先リスト

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

    public function createOrderDetail(Request $request)
    {
        $cart = new Cart;

        $payment = $request->payment;
        $address_id = $request->address_id;
        $req_delivery_date = $request->req_delivery_date;
        $req_delivery_destination = \App\Models\DeliveryDestination::All()->find($address_id);
        $this->products_in_cart = $cart->getProductsInTheCart($request);

        $data = [
            'products_in_cart'          => $this->products_in_cart,
            'req_delivery_date'         => $req_delivery_date,
            'req_delivery_destination'  => $req_delivery_destination,
            'payment'                   => $payment,
        ];
        return view('order/orderConfirm', $data);
    }

    public function createOrder(Request $request)
    {
        $cart = new Cart;

        if($request->payment == 'credit'){
            $payment_method = 0;
        } else {
            $payment_method = 1;
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'delivery_destination_id'   => $request->delivery_destination_id,
            'payment_method'            => $payment_method,
            'total_price'               => $cart->getTotalPriceInTheCart($request),
        ]);
        $products_in_cart = $cart->getProductsInTheCart($request);
        foreach($products_in_cart as $product){
            $order->products()->sync([
                $product->id => [
                    'quantity' => $product->pivot->quantity,
                    'total_price' => $product->pivot->quantity * $product->price,
                    'requested_delivery_date' => $request->req_delivery_date
                ]
            ], false);
        }
        Cart::where('user_id', Auth::id())->delete();

        return view('order/finishedOrder');
    }
}
