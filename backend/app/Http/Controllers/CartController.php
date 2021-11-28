<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    private $product;       //showページ用の変数
    private $products;      //indexページ用の変数

    public function cartList()
    {
        return view('products/cartList');
    }

    public function addToCart(Request $request)
    {
        $ordered_product = \App\Models\Product::All()->find($request->product_id);
        $ordered_quantity = $request->order_quantity;
        $stock_quantity = $ordered_product->stock_quantity;
        $cart = new Cart;

        //カートに商品追加時の在庫数を調整する
        $current_stock_quantity = $stock_quantity - $ordered_quantity;
        $ordered_product->stock_quantity = $current_stock_quantity;
        $ordered_product->save();

        if(Auth::check()){
            if($cart->cart_exist(Auth::id())){
                $cart = \App\Models\Cart::All()->where('user_id', Auth::id())->first();
                $cart->products()->sync([$ordered_product->id => [ 'quantity' => $ordered_quantity]], false);
            } else {
                $cart = Cart::create([
                'user_id' => Auth::id(),
                ]);
                $cart->products()->sync([$ordered_product->id => [ 'quantity' => $ordered_quantity]], false);
            }

        } else{
            //ここはセッションでcartに商品を登録予定
        }
        $products = \App\Models\Product::All();

        $data = [
            'products' => $products,
        ];
        return view('products/productList', $data);

    }
}
