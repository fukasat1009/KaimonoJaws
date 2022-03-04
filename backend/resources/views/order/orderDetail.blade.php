@extends('layouts.app')

@section('title', 'Order Detail')

@section('content')
    <div class="order_detail">
        <h1>注文明細ページ</h1>
        <form>
            <h3>お届け先</h3>
            <div class="delivery_destination">
                <div class="delivery_destination__container">
                    @foreach($delivery_destinations as $destination)
                        <input type="radio" name="" value="">
                        <div class="address__post_code">{{ $destination->post_code }}</div>
                        <div class="address__prefecture">{{ $destination->prefecture }}</div>
                        <div class="address__city">{{ $destination->city }}</div>
                        <div class="address__block">{{ $destination->block }}</div>
                        <div class="address__building">{{ $destination->building }}</div>
                        <div class="address__room_number">{{ $destination->room_number }}</div>
                        <div class="address__phone_number">{{ $destination->phone_number }}</div>
                    @endforeach
                </div>
            </div>

            <h3>お支払い方法</h3>
            <payment-method v-bind:test='{{$test}}'></payment-method>

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
                                    <form action="{{ route('removeProduct') }}" method="post">
                                        {{ csrf_field() }}
                                        <input name="remove_id" value="{{ $product['product_id'] }}" type="hidden">
                                        <!-- 削除に関してはJavascriptで実装予定-->
                                        <button id="">削除</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="order_detail__submit">
                <a href="#">注文確認画面へ進む</a>
            </div>
        </form>
    </div>
@endsection