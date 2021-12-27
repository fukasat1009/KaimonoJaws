<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryDestinationController extends Controller
{
    public function indexMyAddress()
    {
        // $data = [
        //     'products_in_cart' => $this->products_in_cart,
        // ];
        return view('mypage/indexMyAddress');
    }

    public function addMyAddress()
    {
        //
    }
}
