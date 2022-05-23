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

            $this->stockProductCalculation($product,$product->pivot->quantity);
        }

        Cart::where('user_id', Auth::id())->delete();

        return view('order/finishedOrder');
    }

    //注文後に在庫数から注文数を減らす
    public function stockProductCalculation($ordered_product,$ordered_quantity)
    {
        $stock_quantity = $ordered_product->stock_quantity;
        $current_stock_quantity = $stock_quantity - $ordered_quantity;
        $ordered_product->stock_quantity = $current_stock_quantity;
        $ordered_product->save();
    }

    //商品削除機能
    public function removeOrderItem(Request $request)
    {
        $cart_list = \App\Models\Cart::All()->where('user_id', $request->auth_id)->first();
        $cart_list->products()->detach($request->item);

        return response()->json(['cart_list'=> $cart_list]);
    }

    //注文履歴一覧
    public function showOrderHistory()
    {
        $orders = \App\Models\Order::All()->where('user_id', Auth::id());
        $ordered_products = [];
        foreach($orders as $order ){
            foreach($order->products as $order_product){
                $order_product->product_name;
            }
        }
        $data = [
            'orders' => $orders
        ];
        return view('mypage/orderHistory', $data);
    }
}
