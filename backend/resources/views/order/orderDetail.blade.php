@extends('layouts.app')

@section('title', 'Order Detail')

@section('content')
    <div class="order_detail">
        <h1>注文明細ページ</h1>
        <form action="{{ route('createOrderDetail') }}" method="post">
            {{ csrf_field() }}
            <h3>お届け先</h3>
                <select-delivery-destination :delivery-destinations="{{ json_encode($delivery_destinations) }}"></select-delivery-destination>

            <h3>お支払い方法</h3>
            <payment-method></payment-method>

            <h3>商品</h3>
            <div class="order_items">
                <order-items :order-items="{{ json_encode($products_in_cart) }}"></order-items>
                <request-delivery-date name="req_delivery_date" defaultdate="{{ \Carbon\Carbon::now()->addWeekdays(2) }}"></request-delivery-date>
            </div>
            <div class="order_detail__submit">
                <button type="submit">注文確認画面へ進む</button>
            </div>
        </form>
    </div>
@endsection