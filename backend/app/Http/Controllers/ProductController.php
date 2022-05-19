<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class ProductController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::All();
        $data = [
            'products'  => $products,
        ];

        return view('products/productList', $data);
    }
    public function show($product_name)
    {
        $product = \App\Models\Product::all()->where('product_name', $product_name)->first();
        $data = [
            'product'  => $product,
            'product_name' =>$product_name,
        ];

        return view('products/productShow', $data);
    }
}
