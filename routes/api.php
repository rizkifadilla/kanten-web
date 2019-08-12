<?php

use Illuminate\Http\Request;

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

Route::group(['namespace' => 'Api'], function () {

    Route::get('inv/{key}/all', array(
        'as' => 'inv-show_all', 
        'uses' => 'InventoriesController@all'
    ), function ($key) {
        return redirect()->action('InventoriesController@all');
    });

    Route::get('inv/{key}/shop/{id}', array(
        'as' => 'inv-show_byShop', 
        'uses' => 'InventoriesController@byShop'
    ), function ($key, $id) {
        return redirect()->action('InventoriesController@byShop');
    });

    Route::get('inv/{key}/show/{id}', array(
        'as' => 'inv-show_byId', 
        'uses' => 'InventoriesController@show'
    ), function ($key, $id) {
        return redirect()->action('InventoriesController@show');
    });

    Route::post('inv/{key}/create/{sellerId}', array(
        'as' => 'inv-create', 
        'uses' => 'InventoriesController@store'
    ), function ($key, $sellerId) {
        return redirect()->action('InventoriesController@store');
    });

    Route::delete('inv/{key}/delete/{sellerId}/{id}', array(
        'as' => 'inv-delete', 
        'uses' => 'InventoriesController@destroy'
    ), function ($key, $sellerId, $id) {
        return redirect()->action('InventoriesController@destroy');
    });

    Route::match(array('PUT', 'PATCH'), 'inv/{key}/update/{sellerId}/{id}', array(
        'as' => 'inv-update',
        'uses' => 'InventoriesController@update'
    ), function ($key, $sellerId, $id) {
        return redirect()->action('InventoriesController@update');
    });
});

Route::group(['namespace' => 'Api'], function () {

    Route::get('shop/{key}/all', array(
        'as' => 'shop-show_all', 
        'uses' => 'ShopsController@all'
    ), function ($key) {
        return redirect()->action('ShopsController@all');
    });

    Route::get('shop/{key}/show/{id}', array(
        'as' => 'shop-show_byId', 
        'uses' => 'ShopsController@show'
    ), function ($key, $id) {
        return redirect()->action('ShopsController@show');
    });

    Route::match(array('PUT', 'PATCH'), 'shop/{key}/update/{sellerId}/{id}', array(
        'as' => 'shop-update',
        'uses' => 'ShopsController@update'
    ), function ($key, $sellerId, $id) {
        return redirect()->action('ShopsController@update');
    });
});

Route::group(['namespace' => 'Api'], function () {

    Route::get('user/{key}/all', array(
        'as' => 'user-show_all', 
        'uses' => 'UsersController@all'
    ), function ($key) {
        return redirect()->action('UsersController@all');
    });

    Route::get('user/{key}/show/id/{id}', array(
        'as' => 'user-show_byId', 
        'uses' => 'UsersController@showById'
    ), function ($key, $id) {
        return redirect()->action('UsersController@showById');
    });

    Route::get('user/{key}/show/email/{email}', array(
        'as' => 'user-show_byEmail', 
        'uses' => 'UsersController@showByEmail'
    ), function ($key, $id) {
        return redirect()->action('UsersController@showByEmail');
    });

    Route::post('user/{key}/register', array(
        'as' => 'user-create', 
        'uses' => 'UsersController@store'
    ), function ($key) {
        return redirect()->action('UsersController@store');
    });

    Route::match(array('PUT', 'PATCH'), 'user/{key}/update/{id}', array(
        'as' => 'user-update',
        'uses' => 'UsersController@update'
    ), function ($key, $userId, $id) {
        return redirect()->action('UsersController@update');
    });
});

Route::group(['namespace' => 'Api'], function () {

    Route::get('trx/{key}/all', array(
        'as' => 'trx-show_all', 
        'uses' => 'TransactionsController@all'
    ), function ($key) {
        return redirect()->action('TransactionsController@all');
    });

    Route::get('trx/{key}/shop/{id}', array(
        'as' => 'trx-show_byShopId', 
        'uses' => 'TransactionsController@showByShopId'
    ), function ($key, $id) {
        return redirect()->action('TransactionsController@byShopId');
    });

    Route::get('trx/{key}/inv/{id}', array(
        'as' => 'inv-show_byTrxId', 
        'uses' => 'TransactionsController@showInventoriesByTransaction'
    ), function ($key, $id) {
        return redirect()->action('TransactionsController@showInventoriesByTransaction');
    });

    Route::get('trx/{key}/user/id/{id}', array(
        'as' => 'trx-show_byUserId', 
        'uses' => 'TransactionsController@showByUserId'
    ), function ($key, $id) {
        return redirect()->action('TransactionsController@byUserId');
    });

    Route::get('trx/{key}/user/email/{email}', array(
        'as' => 'trx-show_byUserEmail', 
        'uses' => 'TransactionsController@showByUserEmail'
    ), function ($key, $id) {
        return redirect()->action('TransactionsController@byUserEmail');
    });

    Route::get('trx/{key}/show/{id}', array(
        'as' => 'trx-show_byId', 
        'uses' => 'TransactionsController@show'
    ), function ($key, $id) {
        return redirect()->action('TransactionsController@show');
    });

    Route::post('trx/{key}/payment', array(
        'as' => 'trx-payment', 
        'uses' => 'TransactionsController@payment'
    ), function ($key, $sellerId, $userId) {
        return redirect()->action('TransactionsController@payment');
    });

    Route::post('trx/{key}/transfer', array(
        'as' => 'trx-transfer', 
        'uses' => 'TransactionsController@transfer'
    ), function ($key, $senderId, $recepientId) {
        return redirect()->action('TransactionsController@transfer');
    });

    /*
    Route::post('trx/{key}/parking/{providerId}/{userId}', array(
        'as' => 'trx-create', 
        'uses' => 'TransactionsController@store'
    ), function ($key, $providerId, $userId) {
        return redirect()->action('TransactionsController@parking');
    });
    */

});

Route::group(['namespace' => 'Api'], function () {

    Route::get('popular/{key}', array(
        'as' => 'recommendation-popular_here', 
        'uses' => 'RecommendationController@popular'
    ), function ($key) {
        return redirect()->action('RecommendationController@popular');
    });

});