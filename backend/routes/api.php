<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->post('/token', function (Request $request) {
    $user = $request->user();
    $auth_id = $request->auth_id;
    if($auth_id === $user->id){
        return true;
    }
    return false;
});

// Route::middleware('auth:sanctum')->post('/orderDetail/remove', function (Request $request) {
//     Route::group(['middleware' => 'api'], function() {
//         //注文詳細画面で商品を削除する
//         Route::post('/orderDetail/remove', [App\Http\Controllers\OrderController::class, 'removeOrderItem'])->name('removeOrderItem');
//     });
// });

Route::post('/authenticate', [AuthController::class, 'authenticate']);

Route::group(['middleware' => 'api'], function() {
    //注文詳細画面で商品を削除する
    Route::post('/orderDetail/remove', [App\Http\Controllers\OrderController::class, 'removeOrderItem'])->name('removeOrderItem');
});
