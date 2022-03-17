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

Route::post('login', 'App\Http\Controllers\ApiController@login');
Route::post('register', 'App\Http\Controllers\ApiController@register');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'App\Http\Controllers\ApiController@logout');

    Route::get('user', 'App\Http\Controllers\ApiController@getAuthUser');

    Route::get('shoppings', 'App\Http\Controllers\ShoppingController@index');
    Route::get('shoppings/{id}', 'App\Http\Controllers\ShoppingController@show');
    Route::post('shoppings', 'App\Http\Controllers\ShoppingController@store');
    Route::put('shoppings/{id}', 'App\Http\Controllers\ShoppingController@update');
    Route::delete('shoppings/{id}', 'App\Http\Controllers\ShoppingController@destroy');
});
