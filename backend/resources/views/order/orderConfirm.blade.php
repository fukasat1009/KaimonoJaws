@extends('layouts.app')

@section('title', 'orderConfirm')

@section('content')
<div class="order_detail">
    <h1>注文確認ページ</h1>
    <form action="{{ route('createOrder') }}" method="post">
        {{ csrf_field() }}
        <h3>お届け先</h3>
            <input name="delivery_destination_id" value="{{ $req_delivery_destination->id }}">
            〒{{ $req_delivery_destination->postal_code }}
            {{ $req_delivery_destination->prefecture }}
            {{$req_delivery_destination->city}}
            {{ $req_delivery_destination->block }}
            {{ $req_delivery_destination->building }}
            {{ $req_delivery_destination->room_number }}
            TEL:{{ $req_delivery_destination->phone_number }}

        <h3>お支払い方法</h3>
        <input name="payment" value="{{ $payment }}">{{ $payment }}</input>
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
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="order_items__req-delivery-date">
                <input name="req_delivery_date" value="{{ $req_delivery_date }}">
            </div>
        </div>
        <div class="order_detail__submit">
            <button type="submit">注文を確定させる</button>
        </div>
    </form>
</div>
@endsection