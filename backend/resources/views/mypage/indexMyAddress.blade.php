@extends('layouts.app')

@section('title', 'indexMyAddress')

<!-- css style-->
<link rel="stylesheet" href="{{ asset('css/mypage/indexMyAddress.css') }}">
<!-------------->

@section('content')
    <h1>MyAddress</h1>
    <a href="{{ route('newAddressForm') }}">配達先を追加する</a>

    @foreach($my_addresses as $my_address)
        <div class="addressBox">
            <div class="addressBox__container">
                <div class="container__items">{{ $my_address->postal_code }}</div>
                <div class="container__items">{{ $my_address->prefecture }}</div>
                <div class="container__items">{{ $my_address->city }}</div>
                <div class="container__items">{{ $my_address->block }}</div>
                <div class="container__items">{{ $my_address->building }}</div>
                <div class="container__items">{{ $my_address->phone_number }}</div>
            </div>
        </div>
    @endforeach
@endsection
