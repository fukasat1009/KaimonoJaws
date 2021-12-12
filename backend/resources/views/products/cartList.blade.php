@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <p>カートページです。</p>
    @if($products_in_cart == null)
        <p>現在カート内に商品はありません</p>
    @elseif($products_in_cart != null)
        @if(Auth::check())
            @foreach($products_in_cart as $product)
                <div class="cartItems">
                    <div class="cartItems__items">
                        <div class="cartItems__items--name">
                            <p>商品名：{{ $product->product_name }}</p>
                        </div>
                        <div class="cartItems__items--quantity">
                            <p>注文数：{{ $product->pivot->quantity }}</p>
                        </div>
                        <div class="cartItems__items--price">
                            <p>単価：¥{{ $product->price }}</p>
                        </div>
                        <div class="cartItems__items--total-price">
                            <p>合計金額：¥{{ $product->price * $product->pivot->quantity }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            @foreach($products_in_cart as $product)
                <div class="cartItems">
                    <div class="cartItems__items">
                        <div class="cartItems__items--name">
                            <p>商品名：{{ $product->product_name }}</p>
                        </div>
                        <div class="cartItems__items--quantity">
                            <p>注文数：</p>
                        </div>
                        <div class="cartItems__items--price">
                            <p>単価：¥{{ $product->price }}</p>
                        </div>
                        <div class="cartItems__items--total-price">
                            <p>合計金額：¥</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @endif
@endsection