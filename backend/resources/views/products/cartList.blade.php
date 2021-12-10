@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <p>カートページです。</p>
    @foreach($products_in_cart as $product)
        <p>{{ $product->product_name }}</p>
    @endforeach
@endsection