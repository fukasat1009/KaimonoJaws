@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <p>カートページです。</p>
    @foreach($products_in_cart as $product)
        <p>{{ $product->product_name }}</p>
        @foreach($session_data as $data)
            <?php dd($data); ?>
            @if(in_array($product->id,array_column($data,'session_product_id')))
                <span>{{ $data['session_product_quantity'] }}</span>
            @endif
        @endforeach
    @endforeach
@endsection