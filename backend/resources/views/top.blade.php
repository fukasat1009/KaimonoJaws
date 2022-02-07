@extends('layouts.app')

@section('title', 'Top Page')

@section('content')
    <p>Topページです。</p>
    <a href="{{ route('productList') }}">商品一覧</a>
    <a href="{{ route('cartList') }}">カート</a>
    <a href="{{ route('indexMyAddress') }}">MyAddress</a>
@endsection