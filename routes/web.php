<?php

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
    return view('auth/login');
});
Route::get('/cart/{orderId}', 'BuyController@index')->name('cart');

Route::match(array('PUT', 'PATCH'), "home/admin/topup", array(
    'uses' => 'AdminController@topUp',
    'as' => 'admins.topup'
))->middleware('auth');

Route::match(array('PUT', 'PATCH'), "home/admin/create_card", array(
    'uses' => 'AdminController@create_card',
    'as' => 'admins.create_card'
))->middleware('auth');

Route::match(array('PUT', 'PATCH'), "home/admin/create_store", array(
    'uses' => 'AdminController@create_store',
    'as' => 'admins.create_store'
))->middleware('auth');

Auth::routes();

Route::get('/home','HomeController@index')->name('home');

Route::post('/save-to-chart', 'CartController@create')->name('save.cart');

Route::resource('users','UserController');
Route::resource('stores','StoreController');
Route::resource('merchants','MerchantController');
Route::resource('inventories','SellerController');
Route::get('chart','SellerController@chart');
Route::post('transactions','SellerController@buy')->name('buy');
Route::post('transactionscart','BuyController@buyCart')->name('buyCart');
Route::get('/home','SellerController@search')->name('search');
