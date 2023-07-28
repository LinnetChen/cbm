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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/20230724', function () {
    return view('event/20230724_index');
});
Route::get('/MembershipTransfer', function () {
    return view('event/20230728_index');
});
Route::get('/test_launcher', function () {
    return view('test_launcher');
});
Route::get('/launcher', function () {
    return view('test_launcher');
});
