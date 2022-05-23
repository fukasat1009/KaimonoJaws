@extends('layouts.app')

@section('title', 'orderHistory')

@section('content')
    <h1>注文履歴</h1>
    @foreach($orders as $ordered)
        <p>{{ $ordered->created_at->format('Y/m/d/ h:m') }}</p>
        @foreach($ordered->products as $item)
            <a href="{{ route('productShow', $item->product_name) }}">{{ $item->product_name }}</a>
            <p>数量：{{ $item->pivot->quantity }}</p>
        @endforeach
    @endforeach
@endsection
