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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['namespace' => 'api'], function () {
    Route::get('guest','GuestController@index')->name('guest.index');
    Route::get('guest/{id}','GuestController@get')->name('guest.get');
    Route::get('guestByDate/{id}','GuestController@getByDate')->name('guest.getByDate');
    Route::post('guest','GuestController@store')->name('guest.store');

    Route::get('visitor','VisitorController@index')->name('visitor.index');
    Route::get('visitor/{id}','VisitorController@get')->name('visitor.get');
    Route::get('visitor/getByMemberId/{id}','VisitorController@getByMemberId')->name('visitor.getByMemberId');
    Route::post('visitor','VisitorController@store')->name('visitor.store');

    Route::get('loan','LoanController@index')->name('loan.index');
    Route::post('loan/getLoan','LoanController@getByIdMember')->name('loan.getByIdMember');
    Route::post('loan','LoanController@store')->name('loan.store');
    Route::put('loan/{id}','LoanController@update')->name('loan.update');
    Route::delete('loan/{id}','LoanController@destroy')->name('loan.destroy');

    // Route::get('biblio','BiblioController@index')->name('biblio.index');
    // Route::get('biblio/{id}','BiblioController@get')->name('biblio.get');
    // Route::post('biblio','BiblioController@store')->name('biblio.store');
    // Route::put('biblio/{id}','BiblioController@update')->name('biblio.update');
    // Route::delete('biblio/{id}','BiblioController@destroy')->name('biblio.destroy');

    Route::get('item','ItemController@index')->name('item.index');
    Route::get('item/{id}','ItemController@get')->name('item.get');
    Route::post('item','ItemController@getByItem')->name('item.getByItem');
    
    Route::get('member/get/{id}','MemberController@get')->name('member.index');
});