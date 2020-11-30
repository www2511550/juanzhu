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

Route::group(['namespace' => 'Money'], function () {

    // 网赚博客链接
    Route::get('/{cate?}', 'IndexController@index');
    Route::get('/detail/{id}.html', 'IndexController@detail')->name('b.detail');
    Route::get('/yangmao/detail/{id}.html', 'IndexController@yangmaoDetail')->name('yangmao.detail');

});
