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

Route::group(['namespace' => 'Home'], function () {

    // 短链接路由处理
//    Route::get('/{key?}', 'UrlController@index')->name('url.index');
    Route::post('url/short', 'UrlController@short');
    Route::get('go/{key?}', 'UrlController@go')->name('url.go');
    Route::post('url/register', 'UrlController@register')->name('url.register');
    Route::post('url/login', 'UrlController@login')->name('url.login');
    Route::get('url/out', 'UrlController@out')->name('url.out');
    Route::get('url/lists', 'UrlController@lists')->name('url.lists');
    Route::get('url/repair', 'UrlController@repair')->name('url.repair');

    // 工具类路由
    Route::get('/', 'ToolController@index')->name('tool.index');
    Route::any('/wb', 'ToolController@wbapp')->name('tool.wbapp');
    Route::any('/tool/weibo-to-taobao', 'ToolController@weiboToTaobao')->name('tool.weiboToTaobao');
    Route::any('/tool/weibo-to-pinduoduo', 'ToolController@weiboToPinduoduo')->name('tool.weiboToPinduoduo');
    Route::any('/tool/weibo-to-jd', 'ToolController@weiboToJd')->name('tool.weiboToJd');
    Route::any('/tool/tkl-create', 'ToolController@tklCreate')->name('tool.tklCreate');
    Route::any('/tool/short-url', 'ToolController@shortUrl')->name('tool.shortUrl');
    Route::any('/tool/high-rate', 'ToolController@highRate')->name('tool.highRate');
    Route::any('/tool/tbk-order', 'ToolController@tbkOrder')->name('tool.tbkOrder');
    Route::any('/tool/repair-url', 'ToolController@repairUrl')->name('tool.repairUrl');
    Route::any('/tool/login', 'ToolController@login');
    Route::any('/tool/register', 'ToolController@register');
    Route::any('/tool/out', 'ToolController@out');
    Route::any('/tool/personal', 'ToolController@personal')->name('tool.personal');
    Route::any('/tool/text-url', 'ToolController@textUrl')->name('tool.textUrl');
    Route::any('/tool/text-tkl', 'ToolController@textTkl')->name('tool.textTkl');
    Route::any('/tool/to-self-url', 'ToolController@toSelfUrl');
    Route::any('/tool/tkl-decrypt', 'ToolController@tklDecrypt');
    Route::any('/tool/short', 'ToolController@short');
    Route::any('/tool/create-tlj', 'ToolController@createTlj')->name('tool.createTlj');
    Route::get('/tool/item-detail', 'ToolController@itemDetail')->name('tool.itemDetail');

    // 高佣短链接
    Route::any('/tool/search', 'ToolController@search')->name('tool.search');
    Route::any('/tool/test', 'ToolController@test')->name('tool.test');

    // 个人专属
    Route::any('/tool/text', 'ToolController@text');


});
