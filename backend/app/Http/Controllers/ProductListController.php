<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductListController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::All();
        $data = [
            'products'  => $products,
        ];

        return view('products/productList', $data);
    }
}
