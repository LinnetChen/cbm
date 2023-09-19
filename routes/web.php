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

if($_SERVER['HTTP_CF_CONNECTING_IP'] == '211.23.144.219') {
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
Route::get('/info/{cate?}', 'front\FrontController@info')->name('info');
// 公告內容
Route::get('/announcementContent/{id?}', 'front\FrontController@info_content')->name('info_content');
// 遊戲主程式
Route::get('/game', function () {
    return view('front/game');
})->name('download');
// 桌布下載
Route::get('/wallpaper_download', function () {
    return view('front/wallpaper_download');
})->name('wallpaper_download');

// 百科
Route::get('/wiki/{id?}', 'front\FrontController@wiki')->name('wiki');
// 百科搜尋
Route::get('/wiki_search', function () {
    return view('front/home_wiki_search');
});
}
Route::middleware(['setReturnUrl'])->group(function () {
    // 事前預約
    // Route::get('/MembershipTransfer', function () {
    //     return view('stop_info');
    // });
    Route::get('/MembershipTransfer', function () {
        return view('event/20230728_index');
    });
if($_SERVER['HTTP_CF_CONNECTING_IP'] == '211.23.144.219') {
    // 序號兌換
    Route::get('/number_exchange', function () {
        return view('front/number_exchange');
    })->name('number_exchange');
    // 領獎專區
    Route::get('/gift', 'front\FrontController@gift')->name('gift');
    Route::get('/giftContent/{id}', 'front\FrontController@giftContent')->name('giftContent');
}

});

Route::get('/20230724', function () {
    return view('event/20230724_index');
});

Route::get('/test_launcher', function () {
    return view('test_launcher');
});
Route::get('/launcher', 'front\FrontController@launcher');


// 後台上傳圖片
Route::post('delCKEImg', 'CkeditorUploadController@delCKEImg');
Route::post('ckeditor/upload', 'CkeditorUploadController@uploadImage');
Route::post('filePath', 'CkeditorUploadController@getImage')->name('filePath');

Route::get('/prereg', 'front\preregController@index');
Route::get('testApi', 'front\testController@testAPI');
