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
        $cart = new Cart;
        if(!Auth::check()){
            $this->products_in_cart = $cart->getProductsInTheCart($request);
        }
        $this->products_in_cart = $cart->getProductsInTheCart($request);

        $data = [
            'products_in_cart' => $this->products_in_cart,
        ];
        return view('products/cartList',$data);
    }

    //カートに商品を追加する処理
    public function addToCart(Request $request)
    {
        $cart = new Cart;
        $ordered_product = \App\Models\Product::All()->find($request->product_id);
        $ordered_quantity = $request->order_quantity;

        if(Auth::check()){
            //Cartの存在チェック(Cartモデルに記載)
            //カートがない場合はcreateする
            if($cart->exist_check_cart(Auth::id())){
                // //カート内商品の重複チェック
                // //注文した商品がカートに既にあった場合、そのカート内注文数に新たな注文数を加算する。
                $cart->exist_check_auth_cart_product($ordered_product, $ordered_quantity);
            } else {
                $cart_list = Cart::create([
                    'user_id' => Auth::id(),
                ]);
                $cart_list->products()->sync([$ordered_product->id => [ 'quantity' => $ordered_quantity]], false);
            }

        } else {
            //未ログイン時のカート追加処理
            $session_product_id = $request->product_id;
            $session_product_quantity = $ordered_quantity;
            $session_data = $request->session()->get('session_data');

            if($session_data != null){
                // カートのデータがすでに存在している場合
                //最初にカートに入れた商品IDがカート内にすでに存在するかのチェック→あればその数をカート内の数に加算
                $cart->exist_check_session_cart_product($request, $session_data, $session_product_id, $session_product_quantity, $ordered_quantity);
            } else { //セッションがない場合の処理
                $session_data = compact("session_product_id", "session_product_quantity");
                $request->session()->push('session_data', $session_data);
            }
        }
        $this->products_in_cart = $cart->getProductsInTheCart($request);
        $data = [
            'products_in_cart' => $this->products_in_cart,
        ];
        return view('products/cartList', $data);

    }
    //カート内商品削除機能
    public function removeProduct(Request $request)
    {
        if(Auth::check()){
            $cart_list = \App\Models\Cart::All()->where('user_id', Auth::id())->first();
            $cart_list->products()->detach($request->remove_id);
        } else {
            $session_data = $request->session()->get('session_data');
            $key = array_search($request->remove_id, array_column($session_data, 'session_product_id'));
            $request->session()->forget('session_data.'.$key);
        }
        $cart = new Cart;
        $this->products_in_cart = $cart->getProductsInTheCart($request);
        $data = [
            'products_in_cart' => $this->products_in_cart,
        ];
        return view('products/cartList', $data);
    }

}
