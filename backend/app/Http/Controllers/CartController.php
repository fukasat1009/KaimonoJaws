<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    private $products_in_cart;              //カートに追加したすべての商品

    //カート内商品一覧を出す処理
    //未ログインはセッションから取得し、ログイン状態の場合はテーブルから取得
    public function cartList(Request $request)
    {
        if(!Auth::check()){
            $this->products_in_cart = $this->getSessionProductsInTheCart($request);
        }
        $data = [
            'products_in_cart' => $this->products_in_cart,
        ];
        return view('products/cartList',$data);
    }

    //カートに商品を追加する処理
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
            //未ログイン時のカート追加処理
            $session_product_id = $request->product_id;
            $session_product_quantity = $ordered_quantity;

            $session_data = array();
            $session_data = compact("session_product_id","session_product_quantity");
            $request->session()->push('session_data', $session_data);
            $this->products_in_cart = $this->getSessionProductsInTheCart($request);
        }

        $data = [
            'products_in_cart' => $this->products_in_cart,
        ];
        return view('products/cartList', $data);

    }

    //セッション内のカート商品参照用処理
    public function getSessionProductsInTheCart($request)
    {
        $session_data = $request->session()->get('session_data');
        $this->products_in_cart_id = array_column($session_data, 'session_product_id');
        $ordered_product = [];
        foreach($this->products_in_cart_id as $id){
            array_push($ordered_product,\App\Models\Product::All()->find($id));
        };
        $this->products_in_cart = $ordered_product;
        return $this->products_in_cart;
    }
}
