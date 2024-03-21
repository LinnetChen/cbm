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
// 調整蓋台
// Route::get('/', function () {
//     return view('event/20240129');
// });
Route::get('/', 'front\FrontController@index')->name('index');

//首頁
Route::get('/index', 'front\FrontController@index')->name('index');
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
// 桌布下載
Route::get('/wallpaper_download', function () {
    return view('front/wallpaper_download');
})->name('wallpaper_download');
// 百科
Route::get('/wiki/{id?}', 'front\FrontController@wiki')->name('wiki');
// 百科搜尋
Route::get('/wiki_search/{search}', 'front\FrontController@wiki_search');
Route::get('/promotion', function () {
    return view('event/prereg_promotion');
});

// 遊戲主程式
Route::get('/game', function () {
    return view('front/game');
})->name('game');

//國家戰爭
// Route::get('/war', function () {
//     if ($_SERVER["HTTP_CF_CONNECTING_IP"] == '211.23.144.219') {
//         return view('front/war');
//     } else {
//         return redirect('https://digeam.com/index');
//     }
// });
Route::get('/war/{server?}', 'front\FrontController@war')->name('war');

Route::middleware(['setReturnUrl'])->group(function () {
    // 事前預約
    //  Route::get('/MembershipTransfer', function () {
    //      return view('stop_info');
    //  });
    Route::get('/MembershipTransfer', function () {
        return redirect('https://cbo.digeam.com/');
    });
    // 序號兌換
    Route::get('/number_exchange', function () {
        return view('front/number_exchange');
    })->name('number_exchange');
    // 領獎專區
    Route::get('/gift', 'front\FrontController@gift')->name('gift');
    Route::get('/giftContent/{id}', 'front\FrontController@giftContent')->name('giftContent');
    // 測試
    Route::get('/prize/{id}', 'front\FrontController@newGiftContent')->name('prize');

    Route::get('/giftSearch/{year}/{month}/{keyword?}', 'front\FrontController@giftSearch');

    Route::get('/20231220', function () {
        return view('event/20231220_index');
    });
    Route::get('/20240205', function () {
        return view('event/20240205_index');
    });
});
Route::get('/OBT', function () {
    return view('event/OBT');
});

Route::get('/20231030', function () {
    return view('event/20231030_index');
});
Route::get('/20231030', function () {
    return view('event/20231030_index');
});
Route::get('/20240129', function () {
    return view('event/20240129');
});

Route::get('/launcher', 'front\FrontController@launcher');
Route::get('/test_launcher', 'front\FrontController@launcher');

// 後台上傳圖片
Route::post('delCKEImg', 'CkeditorUploadController@delCKEImg');
Route::post('ckeditor/upload', 'CkeditorUploadController@uploadImage');
Route::post('filePath', 'CkeditorUploadController@getImage')->name('filePath');

Route::get('/prereg', 'front\preregController@index');
Route::get('testApi', 'front\testController@testAPI');
