<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class OrderController extends Controller
{
    public function orderDetail()
    {
        $products = \App\Models\Product::All();
        $data = [
        ];
        return view('order/orderDetail', $data);
    }
}
