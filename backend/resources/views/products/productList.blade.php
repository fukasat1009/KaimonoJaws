@extends('layouts.app')

@section('title', 'Produc List')

@section('content')
    <p>商品一覧ページです。</p>
    @foreach($products as $product)
    <a href="{{ route('productShow', $product->product_name) }}">{{ $product->product_name }}</a>
    @endforeach
@endsection