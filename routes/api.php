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

Route::get('/sessionStatus', function() {
    return ['user' => Auth::user() ? Auth::user()->load('profile') : null];
});

Route::group(['prefix' => 'products'], function() {
	Route::get('/', ['uses' => 'ProductController@getMainProducts']);
	Route::get('/searchAutocomplete/{query?}', ['uses' => 'ProductController@searchAutocomplete'])->where('query', '(.*)');
});

Route::get('/product/{url}', ['uses' => 'ProductController@getProduct'])->where('url', '(.*)');



Route::group(['prefix' => 'user'], function() {

	Route::post('/login', ['uses' => 'AuthController@login']);

	Route::post('/create', ['uses' => 'AuthController@createUser']);

});