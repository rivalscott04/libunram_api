<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
    return view('welcome');
});

Route::get('/tem', function () {
    return view('app');
});

Route::get('/visitor', function () {
    $date = Carbon::now()->format('Y-m-d');
    // $room = DB::table('room')->get();
    // return $room;
    $visitor = DB::table("visitor_count")
    ->join('room', 'visitor_count.id_ruangan', '=', 'room.id_ruangan')
    ->where(DB::raw("(DATE_FORMAT(checkin_date,'%Y-%m-%d'))"),$date)
    ->get();
    // return $visitor;
    // return view('grafik',compact('visitor'));
    return view('grafik');
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


