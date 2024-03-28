<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
    'as' => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('/transfer_user', 'TransferUserController');
    $router->resource('/try_login', 'TryLoginController');
    $router->resource('{cate}/main_cate', 'MainCateController');
    $router->resource('/{cate}/page', 'PageController');
    $router->resource('/image', 'ImageController');
    $router->resource('/announcement', 'AnnouncementController');
    $router->resource('/prereguser', 'PreregUserController');
    $router->resource('/msgboard', 'MsgBoardController');
    $router->resource('/suspension', 'SuspensionController');
    // 序號系統
    $router->resource('/serial_number_cate', 'SerialNumberCateController');
    $router->resource('{number}/serial_number', 'SerialNumberController');
    $router->resource('{id}/serial_item', 'SerialItemController');
    $router->resource('serial_number_log', 'SerialNumberLogController');
    // 領獎專區
    $router->resource('/create_gift', 'GiftCreateController');
    $router->resource('{gift_id}/create_gift_project', 'GiftProjectCreateController');
    $router->resource('{gift_project_id}/create_gift_item', 'GiftItemCreateController');
    $router->resource('gift_get_log', 'GiftGetLogController');
    $router->resource('gift_error_get_log', 'GiftErrorGetLogController');
    // 領獎專區(新)
    $router->resource('/new_create_gift', 'NewGiftCreateController');
    $router->resource('{gift_id}/new_create_gift_project', 'NewGiftProjectCreateController');
    $router->resource('{gift_project_id}/new_create_gift_item', 'NewGiftItemCreateController');
    //CCU
    $router->resource('/ccu', 'CCUController');
    //Event231220
    $router->resource('/event231220', 'Event231220Controller');
    //Event240205
    $router->resource('/event240205', 'Event240205Controller');
    // Event240329
    $router->resource('/event20240329', 'Event20240329Controller');
    $router->resource('/event20240329_binding_log', 'Event20240329BindingLogController');
    $router->resource('/event20240329_get_log', 'Event20240329GetLogController');
});
