@extends('layouts.app')

@section('title', 'Product Show')

@section('content')
	<h1>{{ $product->product_name }}の詳細ページ</h1>
	<p>単価：{{ $product->price }}</p>
	<p>在庫数：{{ $product->stock_quantity }}</p>
    <form>
		<span>購入数</span>
		<input>
		<button type="submit">カートに入れる</button>
    </form>
@endsection