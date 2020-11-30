<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Url Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => '', 'namespace' => 'Dapei'], function () {

    // 2搭配链接
    Route::get('/', 'IndexController@index');
    Route::get('/cname/{name}', 'IndexController@index')->name('dp.cname');
    Route::get('/detail/{id}.html', 'IndexController@detail')->name('dp.detail');
    Route::get('/yc/{id}.html', 'IndexController@yc')->name('dp.yc');
    Route::get('/ym/{id}.html', 'IndexController@ym')->name('dp.ym');

});
