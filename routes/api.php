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

Route::group(['middleware' => ['throttle:300']], function() {

	Route::middleware('auth:api')->get('/user', function (Request $request) {
	    return $request->user();
	});

	Route::get('/sessionStatus', function() {
	    return ['user' => Auth::user() ? Auth::user()->load('profile') : null];
	});

	// PRODUCTS
	Route::group(['prefix' => 'products'], function() {
		Route::get('/', ['uses' => 'ProductController@getMainProducts']);
		Route::get('/searchAutocomplete/{query?}', ['uses' => 'ProductController@searchAutocomplete'])->where('query', '(.*)');
	});
	Route::get('/product/{url}', ['uses' => 'ProductController@getProduct'])->where('url', '(.*)');

	// USER
	Route::group(['prefix' => 'user'], function() {

		Route::post('/login', ['uses' => 'AuthController@login']);

		Route::post('/logout', ['uses' => 'AuthController@logout']);

		Route::post('/create', ['uses' => 'AuthController@createUser']);

		Route::post('/checkAuth', ['uses' => 'AuthController@checkAuth']);

	});

	// CATEGORIES
	Route::get('/categories', ['uses' => 'ProductController@getAllCategories']);

	Route::get('/category/{category}/{subcategory?}', ['uses' => 'ProductController@getProductsByCategory'])
			->where(['category' => '(.*)', 'subcategory' => '(.*)']);


	// CART
	Route::group(['prefix' => 'cart', 'middleware' => ['authUser']], function() {
		Route::get('/', ['uses' => 'CartController@index']);
		Route::post('/add', ['uses' => 'CartController@add']);
		Route::post('/delete', ['uses' => 'CartController@delete']);
	});

});