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

Route::get('guest', 'GuestController@index');

Route::get('/', function () {
    return view('Welcome');
});

// Route::get('guest', function () {
//     return view('index');
// });

// Route::get('guest/store', function () {
//     return view('store');
// });

// Route::group(['namespace' => 'Admin'], function () {
//     Route::get('guest', function(){
//         return view('index');
//     });
// });


