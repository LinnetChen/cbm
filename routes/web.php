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

Route::get('/20230724', function () {
    return view('event/20230724_index');
});
Route::get('/test_launcher', function () {
    return view('test_launcher');
});
Route::get('/launcher', function () {
    return view('test_launcher');
});
//首頁
Route::get('/', 'front\FrontController@index')->name('index');


Route::get('/wiki', function () {
    return view('front/home_wiki');
});
Route::get('/wiki_search', function () {
    return view('front/home_wiki_search');
});
Route::get('/game_religion', function () {
    return view('front/game_religion');
});
Route::get('/suspension_list', function () {
    return view('front/suspension_list');
});
Route::get('/info', function () {
    return view('front/info');
});
Route::get('/info_content', function () {
    return view('front/info_content');
});
//模板
Route::get('/app2', function () {
    return view('layouts/app2');
});

Route::get('/wiki/{id?}', 'front\FrontController@wiki')->name('wiki');

Route::middleware(['setReturnUrl'])->group(function () {
    // 事前預約
    // Route::get('/MembershipTransfer', function () {
    //     return view('stop_info');
    // });
    Route::get('/MembershipTransfer', function () {
        return view('event/20230728_index');
    });
});
// 後台上傳圖片
Route::post('delCKEImg', 'CkeditorUploadController@delCKEImg');
Route::post('ckeditor/upload', 'CkeditorUploadController@uploadImage');
Route::post('filePath', 'CkeditorUploadController@getImage')->name('filePath');

Route::get('/prereg', 'front\preregController@index');
Route::get('testApi','front\testController@testAPI');
