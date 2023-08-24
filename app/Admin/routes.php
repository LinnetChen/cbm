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
    $router->resource('/serial_number', 'SerialNumberController');
});
