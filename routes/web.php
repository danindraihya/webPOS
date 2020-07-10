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

// Route::get('/', function () {
//     return view('layouts.app');
// });

Route::get('/', 'Auth\LoginController@showLoginForm');

Auth::routes();

Route::get('/menu', 'MenuController@index');
Route::post('/menu', 'MenuController@store');
Route::put('/menu', 'MenuController@update');
Route::delete('/menu', 'MenuController@destroy');
Route::get('/cari', 'MenuController@cariBarang')->name('menu-cari');

Route::get('/transaksi', 'TransaksiController@index');
Route::get('/transaksi/search', 'TransaksiController@cariItem')->name('cari-item');
Route::get('/transaksi/addtocart', 'TransaksiController@addToCart');
Route::get('/transaksi/removefromcart', 'TransaksiController@removeFromCart');
Route::get('/transaksi/bayar', 'TransaksiController@bayar');