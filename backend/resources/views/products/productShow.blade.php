@extends('layouts.app')

@section('title', 'Product Show')

@section('content')
	<h1>{{ $product->product_name }}の詳細ページ</h1>
	<p>単価：{{ $product->price }}</p>
	<p>在庫数：{{ $product->stock_quantity }}</p>
    <form action="{{ route('addToCart') }}" method="post">
		{{ csrf_field() }}
		<input type="hidden" name="product_id" value="{{ $product->id }}">
		<span>購入数</span>
		<select name="order_quantity">
			<option value="1">1</option>
			<option value="2">2</option>
		</select>
		<button type="submit">カートに入れる</button>
    </form>
@endsection