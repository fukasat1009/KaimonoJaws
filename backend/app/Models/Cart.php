<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    /** リレーション(従属関係) */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('quantity')->withTimestamps();
    }

    /** カートの存在チェック */
    public function exist_check_cart($user_id)
    {
        $exist = \App\Models\Cart::All()->where('user_id', $user_id)->first();

        if(!$exist == null){
            return true;
        } else {
            return false;
        }
    }

    /** カート内商品の重複チェック */
    public function exist_check_auth_cart_product($ordered_product, $ordered_quantity)
    {
        $cart_list = \App\Models\Cart::All()->where('user_id', Auth::id())->first();

        //注文した商品がカートに既にあった場合、そのカート内注文数に新たな注文数を加算する。
        $already_ordered_product = $cart_list->products->where('id', $ordered_product->id)->first();
        if($already_ordered_product != null){
            if($already_ordered_product->id == $ordered_product->id){
                $already_quantity = $already_ordered_product->pivot->quantity;
                $total_quantity = $already_quantity + $ordered_quantity;
                $cart_list->products()->sync([$ordered_product->id => [ 'quantity' => $total_quantity]], false);
            }
        } else {
            $cart_list->products()->sync([$ordered_product->id => [ 'quantity' => $ordered_quantity]], false);
        }
    }

    /** セッションのカート内の商品重複チェック */
    public function exist_check_session_cart_product($request, $session_data, $ordered_product_id, $session_product_quantity, $ordered_quantity)
    {
        //最初にカートに入れた商品IDがカート内にすでに存在するかのチェック→あればその数をカート内の数に加算
        //重複していなければそのままcompactで配列を作成する
        if(in_array($ordered_product_id, array_column($session_data, 'session_product_id'))){
            $key = array_search($ordered_product_id, array_column($session_data, 'session_product_id'));
            foreach ( $session_data[$key] as $session_product_quantity => $already_quantity ){
                $total_quantity = $already_quantity + $ordered_quantity;
            }
            $request->session()->put('session_data.'.$key.'.session_product_quantity',$total_quantity);
        } else{
            $session_product_id = $ordered_product_id;
            $session_data = compact("session_product_id", "session_product_quantity");
            $request->session()->push('session_data', $session_data);
        }
    }

    /** カート商品参照用処理 */
    public function getProductsInTheCart($request)
    {
        if(Auth::check()){
            $cart = \App\Models\Cart::All()->where('user_id', Auth::id())->first();
            if($cart != null){
                $products_in_cart = $cart->products;
            } else{
                $products_in_cart = null;
            }
            return $products_in_cart;
        } else {
            $session_data = $request->session()->get('session_data');
            if($session_data == null){
                return null;
            }
            $products_in_cart_id = array_column($session_data, 'session_product_id');
            $ordered_product = [];
            foreach($products_in_cart_id as $id){
                $key = array_search($id, $products_in_cart_id);
                $product = \App\Models\Product::All()->find($id);
                $ordered_product[$id]['product_id'] = $product->id;
                $ordered_product[$id]['product_name'] = $product->product_name;
                $ordered_product[$id]['price'] = $product->price;
                $ordered_product[$id]['quantity'] = $session_data[$key]['session_product_quantity'];
            };
            $products_in_cart = $ordered_product;
            return $products_in_cart;
        }
    }

    /** カート内の合計金額参照処理 */
    public function getTotalPriceInTheCart($request)
    {
        $cart = new Cart();
        $cart_products = $cart->getProductsInTheCart($request);
        $price_array = [];
        foreach($cart_products as $product){
            $price_array[]['total_price'] = $product->price * $product->pivot->quantity;
        }
        $total_price = array_sum(array_column($price_array, 'total_price'));
        return $total_price;
    }

    /** 非ログイン時にカート商品をログイン後に引き継がせる */
    public function getProductsAfterLogin($request)
    {
        $cart = new Cart;
        $session_data = $request->session()->get('session_data');

        if($session_data != null){
            $products_in_cart_id = array_column($session_data, 'session_product_id');
            $ordered_product = [];
            foreach($products_in_cart_id as $id){
                $key = array_search($id, $products_in_cart_id);
                $product = \App\Models\Product::All()->find($id);
                $ordered_product[$id]['product_id'] = $product->id;
                $ordered_product[$id]['product_name'] = $product->product_name;
                $ordered_product[$id]['price'] = $product->price;
                $ordered_product[$id]['quantity'] = $session_data[$key]['session_product_quantity'];
            };
            $products_in_cart = $ordered_product;

            if($cart->exist_check_cart(Auth::id())){
                // //カート内商品の重複チェック
                // //注文した商品がカートに既にあった場合、そのカート内注文数に新たな注文数を加算する。
                foreach($products_in_cart as $product){
                    $ordered_product = \App\Models\Product::All()->find($product['product_id']);
                    $cart->exist_check_auth_cart_product($ordered_product, $product['quantity']);
                }
            } else {
                $cart_list = Cart::create([
                    'user_id' => Auth::id(),
                ]);
                foreach($products_in_cart as $product){
                    $cart_list->products()->sync([$product->product_id => [ 'quantity' => $product->quantity]], false);
                }
            }
        }
    }

}
