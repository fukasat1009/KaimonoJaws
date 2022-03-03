<?php

namespace App\Http\Controllers;

use App\Models\DeliveryDestination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryDestinationController extends Controller
{
    public function indexMyAddress()
    {
        $my_addresses = \App\Models\DeliveryDestination::All()->where('user_id', Auth::id());
        $data = [
            'my_addresses' => $my_addresses,
        ];
        return view('mypage/indexMyAddress',$data);
    }

    public function newAddressForm()
    {
        return view('mypage/newAddressForm');
    }

    public function addNewAddress(Request $request)
    {
        $new_address = new DeliveryDestination();
        $new_address->user_id = Auth::id();
        $new_address->prefecture = $request->prefecture;
        $new_address->city = $request->city;
        $new_address->postal_code = $request->postal_code;
        $new_address->block = $request->block;
        $new_address->building = $request->building;
        $new_address->phone_number = $request->phone_number;
        $new_address->save();

        $my_addresses = \App\Models\DeliveryDestination::All()->where('user_id', Auth::id());
        $data = [
            'my_addresses' => $my_addresses,
        ];
        return view('mypage/indexMyAddress',$data);

    }
}
