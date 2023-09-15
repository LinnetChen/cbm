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
if(1 == 2) {


    //首頁
    Route::get('/', 'front\FrontController@index')->name('index');
    Route::get('/index', 'front\FrontController@index');
    // 遊戲規章
    Route::get('/game_religion', function () {
        return view('front/game_religion');
    })->name('game_religion');
    // 停權名單
    Route::get('/suspension_list', 'front\FrontController@suspension_list')->name('suspension_list');
    // 公告
    Route::get('/info', function () {
        return view('front/info');
    })->name('info');
    // 公告內容
    Route::get('/info_content', function () {
        return view('front/info_content');
    });
    Route::get('/game', function () {
        return view('front/game');
    });
    Route::get('/wallpaper_download', function () {
        return view('front/wallpaper_download');
    });
    Route::get('/number_exchange', function () {
        return view('front/number_exchange');
    });
    Route::get('/gift', function () {
        return view('front/gift');
    });
    //模板
    Route::get('/app3', function () {
        return view('layouts/app3');
    });
}
// 百科
Route::get('/wiki/{id?}', 'front\FrontController@wiki')->name('wiki');
// 百科搜尋
Route::get('/wiki_search', function () {
    return view('front/home_wiki_search');
});
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
