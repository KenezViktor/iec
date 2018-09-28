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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users/reg', 'UserController@registration');

Route::post('users/login', 'UserController@login');

Route::post('users/logout', 'UserController@logout');

Route::post('product/add', 'ProductController@addProduct');

Route::get('product/all', 'ProductController@getAllProducts');

Route::post('product/one', 'ProductController@getProducts');

Route::post('orders/all', 'OrderController@getAllOrders');

Route::post('orders/add', 'OrderController@addToOrders');
