@extends('layouts.app')

@section('title', 'Order Detail')

@section('content')
    <div class="order_detail">
        <h1>注文明細ページ</h1>
        <form action="{{ route('createOrderDetail') }}" method="post">
            {{ csrf_field() }}
            <h3>お届け先</h3>
                <select-delivery-destination :delivery-destinations="{{ json_encode($delivery_destinations) }}"></select-delivery-destination>

            <h3>お支払い方法</h3>
            <payment-method></payment-method>

            <h3>商品</h3>
            <div class="order_items">
                <div class="order_items__container">
                    @foreach($products_in_cart as $product)
                        <div class="cartItems">
                            <div class="cartItems__items">
                                <div class="cartItems__items--name">
                                    <p>商品名：{{ $product['product_name'] }}</p>
                                </div>
                                <div class="cartItems__items--quantity">
                                    <p>注文数：{{ $product->pivot['quantity'] }}</p>
                                </div>
                                <div class="cartItems__items--price">
                                    <p>単価：¥{{ $product['price'] }}</p>
                                </div>
                                <div class="cartItems__items--total-price">
                                    <p>合計金額：¥{{ $product['price'] * $product->pivot['quantity'] }}</p>
                                </div>
                                <div class="cartItems__items__delete">
                                    <!-- <form action="{{ route('removeProduct') }}" method="post"> -->
                                        <!-- {{ csrf_field() }}
                                        <input name="remove_id" value="{{ $product['product_id'] }}" type="hidden"> -->
                                        <!-- 削除に関してはJavascriptで実装予定-->
                                        <!-- <button id="">削除</button> -->
                                    <!-- </form> -->
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <request-delivery-date name="req_delivery_date" defaultdate="{{ \Carbon\Carbon::now()->addWeekdays(2) }}"></request-delivery-date>
            </div>
            <div class="order_detail__submit">
                <button type="submit">注文確認画面へ進む</button>
            </div>
        </form>
    </div>
@endsection