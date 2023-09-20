<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('/transfer_user', 'TransferUserController');
    $router->resource('/try_login', 'TryLoginController');
    $router->resource('{cate}/main_cate', 'MainCateController');
    $router->resource('/{cate}/page', 'PageController');
    $router->resource('/image', 'ImageController');
    $router->resource('/announcement', 'AnnouncementController');
    $router->resource('/serial_number_cate', 'SerialNumberCateController');
    $router->resource('{number}/serial_number', 'SerialNumberController');
    $router->resource('/prereguser', 'PreregUserController');
    $router->resource('/msgboard', 'MsgBoardController');
    $router->resource('/suspension', 'SuspensionController');
    $router->resource('/create_gift', 'GiftCreateController');
    $router->resource('{gift_id}/create_gift_project', 'GiftProjectCreateController');
    $router->resource('{gift_project_id}/create_gift_item', 'GiftItemCreateController');
    $router->resource('serial_number_log', 'SerialNumberLogController');
    $router->resource('gift_get_log', 'GiftGetLogController');
});
