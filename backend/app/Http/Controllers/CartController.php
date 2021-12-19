<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    private $products_in_cart; //カートに追加したすべての商品

    //カート内商品一覧を出す処理
    //未ログインはセッションから取得し、ログイン状態の場合はテーブルから取得
    public function cartList(Request $request)
    {
        if(!Auth::check()){
            $this->products_in_cart = $this->getProductsInTheCart($request);
        }
        $session_data = $request->session()->get('session_data');
        dd($session_data);
        $this->products_in_cart = $this->getProductsInTheCart($request);
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

        //カートに商品追加時の在庫数を調整する
        $current_stock_quantity = $stock_quantity - $ordered_quantity;
        $ordered_product->stock_quantity = $current_stock_quantity;
        $ordered_product->save();

        if(Auth::check()){
            $cart = new Cart;
            //Cartの存在チェック(Cartモデルに記載)
            //カートがない場合はcreateする
            if($cart->cart_exist(Auth::id())){
                $cart = \App\Models\Cart::All()->where('user_id', Auth::id())->first();

                //カート内商品の重複チェック
                //注文した商品がカートに既にあった場合、そのカート内注文数に新たな注文数を加算する。
                $already_ordered_product = $cart->products->where('id', $request->product_id)->first();
                if($already_ordered_product != null){
                    if($already_ordered_product->id == $request->product_id){
                        $already_quantity = $already_ordered_product->pivot->quantity;
                        $total_quantity = $already_quantity + $ordered_quantity;
                        $cart->products()->sync([$ordered_product->id => [ 'quantity' => $total_quantity]], false);
                    }
                } else {
                    $cart->products()->sync([$ordered_product->id => [ 'quantity' => $ordered_quantity]], false);
                }
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
            $session_data = $request->session()->get('session_data');

            // $request->session()->push('session_data', $session_data);
            if($session_data != null){
                //もしカートに追加した商品が既にカートにあった場合は、過去にカートに入れた数量にプラスする
                if(in_array($session_product_id, array_column($session_data, 'session_product_id'))){
                    $key = array_search($session_product_id, array_column($session_data, 'session_product_id'));
                    foreach ( $session_data[$key] as $session_product_quantity => $already_quantity ){
                        $total_quantity = $already_quantity + $ordered_quantity;
                        // $session_product_quantity = $total_quantity;
                    }
                    $request->session()->put('session_data.'.$key.'.session_product_quantity',$total_quantity);
                    // dd($session_data);
                    // $session_data = compact("session_product_id", "session_product_quantity");
                    // $request->session()->flush();
                    // $session_data = compact("session_product_id", "session_product_quantity");
                    // $request->session()->push('session_data', $session_data);
                } else{
                    $session_data = compact("session_product_id", "session_product_quantity");
                    $request->session()->push('session_data', $session_data);
                }
            } else {
                // $session_data = array();
                $session_data = compact("session_product_id", "session_product_quantity");
                $request->session()->push('session_data', $session_data);
            }
            // $session_data = compact("session_product_id", "session_product_quantity");
            // $request->session()->push('session_data', $session_data);
            // $request->session()->flush();
        }
        $this->products_in_cart = $this->getProductsInTheCart($request);
        // $request->session()->flush();
        $data = [
            'products_in_cart' => $this->products_in_cart,
        ];
        return view('products/cartList', $data);

    }

    //セッション内のカート商品参照用処理
    public function getProductsInTheCart($request)
    {
        if(Auth::check()){
            $cart = \App\Models\Cart::All()->where('user_id', Auth::id())->first();
            $this->products_in_cart = $cart->products;
            return $this->products_in_cart;
        } else {
            $session_data = $request->session()->get('session_data');
            if($session_data == null){
                return null;
            }
            $this->products_in_cart_id = array_column($session_data, 'session_product_id');
            $ordered_product = [];
            foreach($this->products_in_cart_id as $id){
                array_push($ordered_product,\App\Models\Product::All()->find($id));
            };
            $this->products_in_cart = $ordered_product;
            return $this->products_in_cart;
        }
    }
    //商品IDの重複チェック
    public function ProductIdRepeatCheck()
    {
        //
    }
}
