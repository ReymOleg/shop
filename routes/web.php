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

// Route::group(['middleware' => 'web'], function () {

//     Route::get('/', function () {
// 	    return view('welcome');
// 	});

// 	Route::any('/{slug}', function($slug) {
// 	   return view('welcome');
// 	})->where('slug', '([A-z\d-\/_.]+)?');
// });

Route::get('/{vue_capture?}', function () {
   return view('app');
 })->where('vue_capture', '[\/\w\.-]*');

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::any('/{slug}', function($slug) {
//    return view('welcome');
// })->where('slug', '([A-z\d-\/_.]+)?');

// Route::any( '(.*)', function(){
//     return view('welcome');
// });
