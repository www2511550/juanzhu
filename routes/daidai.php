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
/**
 * 呆呆个人定制
 */

Route::group(['namespace' => 'Home'], function () {

    // 基础类路由
//    Route::get('/{key?}', 'UrlController@index')->name('url.index');
    Route::post('url/short', 'UrlController@short');
    Route::get('go/{key?}', 'UrlController@go')->name('url.go');
    Route::post('url/register', 'UrlController@register')->name('url.register');
    Route::post('url/login', 'UrlController@login')->name('url.login');
    Route::get('url/out', 'UrlController@out')->name('url.out');
    Route::get('url/lists', 'UrlController@lists')->name('url.lists');
    Route::get('url/repair', 'UrlController@repair')->name('url.repair');


    // 工具类路由
    Route::get('/', 'DaidaiController@index');
    Route::any('/dd/one-link', 'DaidaiController@oneLink');
    Route::any('/dd/more-link', 'DaidaiController@moreLink');
    Route::any('/dd/weibo-to-taobao', 'DaidaiController@weiboToTaobao');
    Route::any('/dd/tkl-create', 'DaidaiController@tklCreate');
    Route::any('/dd/short-url', 'DaidaiController@shortUrl');
    Route::any('/dd/text-url', 'DaidaiController@textUrl');
    Route::any('/dd/test', 'DaidaiController@test');

    // config设置
    Route::any('/admin', 'DaidaiController@setConfig');


});
