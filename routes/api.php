<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('menu', 'Api\TransaksiController@index');
Route::post('menu/bayar', 'Api\TransaksiController@bayar');
Route::get('menu/search', 'Api\TransaksiController@cariItem');
Route::post('menu/addtocart', 'Api\TransaksiController@addToCart');
Route::post('menu/removefromcart', 'Api\TransaksiController@removeFromCart');
Route::get('report', 'Api\TransaksiController@masterReport');
Route::get('menu/coba', 'Api\TransaksiController@coba');


Route::post('login', 'Api\UsersController@login');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

