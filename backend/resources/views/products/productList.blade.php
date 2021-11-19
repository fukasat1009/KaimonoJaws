@extends('layouts.app')

@section('title', 'Produc List')

@section('content')
    <p>商品一覧ページです。</p>
    @foreach($products as $product)
    <p>{{ $product->product_name }}</p>
    @endforeach
@endsection