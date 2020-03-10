<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => 'Hanson\\LaravelAdminAlioss\\Http\\Controllers',
    'middleware'    => config('admin.route.middleware'),
], function () {

    Route::post('alioss/upload', 'AliossController@upload');
    Route::match(['put', 'post'], 'alioss/delete', 'AliossController@delete');

});
