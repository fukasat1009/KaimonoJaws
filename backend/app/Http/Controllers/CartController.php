<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cartList()
    {
        return view('products/cartList');
    }

    public function addToCart(Request $request)
    {
        //カートに商品追加時の在庫数を調整する
        $ordered_product = \App\Models\Product::All()->find($request->product_id);
        $current_stock_quantity = $ordered_product->stock_quantity - $request->order_quantity;
        $ordered_product->stock_quantity = $current_stock_quantity;
        $ordered_product->save();

        if(Auth::check()){
            Cart::create([
                //'id' => $,
            ]);
        }

        $data = [
            'ordered_product' => $ordered_product
        ];
        return view('products/productShow', $data);

    }
}
