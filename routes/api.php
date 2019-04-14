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

// Route::group([], function () {
//     Route::post('login', 'AuthController@login');
//     Route::post('register', 'AuthController@register');
  
//     Route::group(['middleware' => 'auth:api'], function() {
//         Route::get('logout', 'AuthController@logout');
//         Route::get('user', 'AuthController@user');

	    
		
//     });
// });


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('orders', 'OrderController@index');
	Route::get('orders/{order}', 'OrderController@show');
	Route::post('orders', 'OrderController@store');
	Route::put('orders/{order}', 'OrderController@update');
	Route::delete('orders/{order}', 'OrderController@delete');

	Route::post('orders/{order}/add', 'OrderController@attachProduct');
	Route::post('orders/{order}/pay', 'OrderController@payOrder');
});