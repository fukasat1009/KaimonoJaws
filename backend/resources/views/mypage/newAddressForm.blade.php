@extends('layouts.app')

@section('title', 'newAddressForm')

@section('content')
    <p>配達先を追加する</p>
    <form action="{{ route('addNewAddress') }}" method="post">
    {{ csrf_field() }}
        <p>郵便番号</p>
        <input type="text" name="postal_code">
        <p>都道府県</p>
        <input type="text" name="prefecture">
        <p>市区町村</p>
        <input type="text" name="city">
        <p>番地号</p>
        <input type="text" name="block">
        <p>建物名</p>
        <input type="text" name="building">
        <p>携帯番号</p>
        <input type="text" name="phone_number">
        <button type="submit">登録する</button>
    </form>
@endsection
