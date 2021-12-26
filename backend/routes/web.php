<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('top');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//商品一覧画面
Route::get('/productList', [App\Http\Controllers\ProductController::class, 'index'])->name('productList');

//商品詳細画面
Route::get('/products/{product_name}', [App\Http\Controllers\ProductController::class, 'show'])->name('productShow');

//カート画面
Route::get('/cart', [App\Http\Controllers\CartController::class, 'cartList'])->name('cartList');

//商品をカートに追加する
Route::post('/cart',[App\Http\Controllers\CartController::class, 'addToCart'])->name('addToCart');

//商品をカートから除外する
Route::post('/removeProduct',[App\Http\Controllers\CartController::class, 'removeProduct'])->name('removeProduct');