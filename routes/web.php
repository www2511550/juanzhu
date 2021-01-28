<?php

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

//Route::get('/', function () {
//    Route::get('/', 'IndexController@index');
//});


Route::get('/', 'Home\IndexController@index');
Route::get('test', 'Home\IndexController@test');
Route::get('down', 'Home\WapController@down');
Route::get('down/plan', 'Home\WapController@downPlan');
Route::get('web/{type}', 'Home\IndexController@iframe');

Route::get('zaobao', 'Home\IndexController@zaobao'); // 每日早报
Route::get('wzads', 'Home\IndexController@wzAds'); // 网赚广告
Route::get('ym/{id}.html', 'Dapei\IndexController@ym'); // 褥羊毛详情
Route::get('free', 'Home\IndexController@freeTaoLiJin'); // 淘礼金免单集合
Route::get('tkdata', 'Home\IndexController@tkData'); // 大淘客，好单裤商家、淘客联系方式数据


// 短链接路由处理
Route::get('url', 'Home\UrlController@index')->name('url.index');;
Route::post('url/short', 'Home\UrlController@short');
Route::get('go/{key?}', 'Home\UrlController@go')->name('url.go');
Route::post('url/register', 'Home\UrlController@register')->name('url.register');
Route::post('url/login', 'Home\UrlController@login')->name('url.login');
Route::get('url/out', 'Home\UrlController@out')->name('url.out');
Route::get('pay/qCode', 'Home\PayController@qCode')->name('pay.qCode');


Route::get('plans', 'Plan\IndexController@index');
Route::post('uploadPic', 'Plan\IndexController@uploadPic');

Route::group(['prefix' => 'home','namespace' => 'Home'], function() {

    Route::get('index/test', 'IndexController@test');

    Route::get('index/index', 'IndexController@index');
    Route::get('index/append', 'IndexController@append');
    Route::get('index/detail/{id?}.html', 'IndexController@detail')->name('index.detail');
    Route::get('index/detail', 'IndexController@detail'); // 兼容旧版路由地址-收录
    Route::get('index/quan', 'IndexController@quan');
    Route::get('index/search', 'IndexController@search');
    Route::get('index/login', 'IndexController@login');
    Route::get('index/register', 'IndexController@register');
    Route::get('index/guessLike', 'IndexController@guessLike');
    Route::get('index/sendWeibo', 'IndexController@sendWeibo')->name('index.weibo');
    Route::get('index/sendArticle', 'IndexController@sendArticle')->name('index.wbArticle');


    // 采集接口
    Route::get('query/index', 'QueryController@index');
    Route::get('query/test', 'QueryController@test');


    // wap端
    Route::get('wap/index', 'WapController@index');
    Route::get('wap/url', 'WapController@url');
    Route::get('wap/toTb', 'WapController@toTb');
    Route::get('wap/juanUrl', 'WapController@juanUrl');
    Route::get('wap/zhifubao', 'WapController@zhifubao');  // 支付宝红包
    Route::get('wap/detail', 'WapController@detail');
    Route::get('wap/down', 'WapController@down');
    Route::match(['get', 'post'], 'wap/shop', 'WapController@shop');
    Route::get('wap/reward', 'WapController@reward');
    Route::post('wap/toReward', 'WapController@toReward');
    Route::post('wap/append', 'WapController@append');
    Route::post('wap/addScoreOrder', 'WapController@addScoreOrder');
    Route::get('out', 'WapController@out');
    Route::match(['get', 'post'], 'login', 'WapController@login');
    Route::match(['get', 'post'], 'register', 'WapController@register');
    // wap端 - 会员中心
    Route::get('center', 'CenterController@index');
    Route::get('center/info', 'CenterController@info');
    Route::get('center/score', 'CenterController@score');
    Route::get('center/order', 'CenterController@order');

    // 活动类相关接口
    Route::get('activity/money', 'ActivityController@money');
    // wap 版
    Route::get('/activity/order', 'ActivityController@order'); // 下单送话费
    Route::get('/activity/friend', 'ActivityController@friend'); // 邀请好友赢话费
    Route::get('/activity/binding', 'ActivityController@binding'); // 邀请绑定展示页
    Route::get('/activity/bindTel', 'ActivityController@bindTel'); // 绑定手机-注册资格


    // 代理文案相关介绍
    Route::get('word/agentIntro', 'WordController@agentIntro');
    Route::get('word/rewardRule', 'WordController@rewardRule'); // 奖励规则


    // 微信
    Route::get('wx/poster', 'WxController@poster');

    // 97866.com 花生小程序开放接口
    Route::get('goods/add', 'GoodsController@add');


});


// 百度小程序专用接口
Route::group(['prefix' => 'bd','namespace' => 'Home'], function() {

    Route::match(['get', 'post'], '/article-list', 'BaiducmsController@articleList');
    Route::match(['get', 'post'], '/article-detail', 'BaiducmsController@articleDetail');
    Route::match(['get', 'post'], '/category-list', 'BaiducmsController@categoryList');

});

// 微博专区
Route::group(['prefix' => 'wb','namespace' => 'Home'], function() {

    Route::get('/index', 'WeiBoController@index');
    Route::get('/callback', 'WeiBoController@callback');
    Route::get('/lists', 'WeiBoController@lists');
    Route::any('/pic-text', 'WeiBoController@picText');
    Route::post('/tb-imgs', 'WeiBoController@getTbImgs');
    Route::any('/commit', 'WeiBoController@commit');
    Route::any('/login', 'WeiBoController@login');

});

Route::group(['prefix' => 'article','namespace' => 'Home'], function() {

    Route::get('/', 'ArticleController@index')->name('article'); // 首页
    Route::get('/detail/{id?}.html', 'ArticleController@detail')->name('article.detail'); // 详细页
    Route::get('/detail/{id}', 'ArticleController@detail'); // 详细页旧版路由-收录

});

Route::group(['prefix' => 'dapei','namespace' => 'Dapei'], function() {

    Route::get('/', 'IndexController@index');
    Route::get('/cname/{name}', 'IndexController@index')->name('dp.cname');
    Route::get('/detail/{id}.html', 'IndexController@detail')->name('dp.detail');
    Route::get('/yc/{id}.html', 'IndexController@yc')->name('dp.yc');


});

// 微信公众号接口路由配置
Route::group(['prefix' => 'wx','namespace' => 'Weixin'], function() {

    Route::match(['get', 'post'], '/valid', 'IndexController@valid');  // 验证
    Route::match(['get', 'post'], '/serve', 'IndexController@serve');  // 验证
    Route::match(['get', 'post'], '/chat/valid', 'WechatController@valid');  // 验证
    Route::match(['get', 'post'], '/chat/test', 'WechatController@valid');  // 验证
    Route::match(['get', 'post'], '/chat/valid1', 'WechatController@valid');  // 验证
    Route::match(['get', 'post'], '/chat/valid2', 'WechatController@valid');  // 微赚小能手公众号验证

    Route::get('/center/detail', 'CenterController@detail'); // 首页


    // 品质小说网公众号接口配置
    Route::match(['get', 'post'], '/story/valid', 'StoryController@valid');  // 验证

});

// app接口路由配置
Route::group(['prefix' => 'api','namespace' => 'Api'], function() {

    Route::get('/index/index', 'IndexController@index'); // 首页
    Route::get('/index/indexSearch', 'IndexController@indexSearch'); // 首页搜索界面
    Route::get('/index/news', 'IndexController@news');  //优券头条
    Route::get('/index/lists', 'IndexController@lists');  // 列表页数据
    Route::get('/index/search', 'IndexController@search');  // 搜索列表
    Route::get('/index/searchList', 'IndexController@searchList');  // 外部搜索列表
    Route::get('/index/searchName', 'IndexController@searchName');  // 搜索词推荐
    Route::get('/index/category', 'IndexController@category');  // 列表页数据
    Route::get('/index/detail', 'IndexController@detail');  // 详细页数据


    // 外部调用接口
    Route::get('/ext/coupon', 'ExtController@coupon');  // 详细页数据


    // 优券快报
    Route::get('/news/lists', 'NewsController@lists');  // 优券快报列表
    Route::get('/news/detail', 'NewsController@detail');  // 优券头条详细页单页
    Route::post('/news/collect', 'NewsController@collect');  // 收藏优券头条
    Route::post('/news/comment', 'NewsController@comment');  // 提交评论
    Route::get('/news/commentList', 'NewsController@commentList');  // 提交评论
    Route::post('/news/getCollectAndComment', 'NewsController@getCollectAndComment');  // 收藏状态

    // 用户相关操作
    Route::match(['get', 'post'], '/user/login', 'UserController@login');  // 登录
    Route::post('/user/register', 'UserController@register');  // 注册
    Route::match(['get', 'post'],'/user/sendMsg', 'UserController@sendMsg');  // 短信发送
    Route::post('/user/myCollect', 'UserController@myCollect');  // 我的收藏
    Route::post('/user/addFriend', 'UserController@addFriend'); // 绑定好友
    Route::match(['get', 'post'],'/user/info', 'UserController@info'); // 获取用户基本信息
    Route::post('/user/resetPwd', 'UserController@resetPwd'); // 重置密码
    Route::post('/user/checkCode', 'UserController@checkCode'); // 验证码校验

    // 会员中心相关操作
    Route::post('/center/msgList', 'CenterController@msgList'); // 消息列表

    // 签到相关操作
    Route::get('/sign/index', 'SignController@index'); // 签到首页
    Route::post('/sign/doSign', 'SignController@doSign'); // 签到首页


    // 旧版app接口，切换后遗弃
    Route::get('quan/menu', 'QuanController@menu');
    Route::get('quan/lists', 'QuanController@lists');
    Route::get('dataoke/saleTop', 'DataokeController@saleTop');
    Route::get('dataoke/top100', 'DataokeController@top100');

    // 会员中心接口
    Route::post('login', 'User2Controller@login');
    Route::post('register', 'User2Controller@register');
    Route::post('user/addTbUser', 'User2Controller@addTbUser');
    Route::post('user/getUserInfo', 'User2Controller@getUserInfo');
    Route::post('user/getMyScore', 'User2Controller@getMyScore');



    // 微信程序接口
    Route::get('wx/index', 'WxIndexController@index');
    Route::get('goods/detail', 'WxIndexController@detail');
    Route::get('goods/hot', 'WxIndexController@lists');
    Route::get('goods/related', 'WxIndexController@related');
    Route::get('goods/list', 'WxIndexController@lists');
    Route::get('catalog/index', 'WxIndexController@catalog');
    Route::post('auth/loginByWeixin', 'WxIndexController@loginByWeixin');
    Route::get('wx/orderList ', 'WxIndexController@orderList');
    Route::get('wx/rewardList ', 'WxIndexController@rewardList');
    Route::post('wx/feedBack ', 'WxIndexController@feedBack');
    Route::match(['get','post'],'wx/applyAgent ', 'WxIndexController@applyAgent');
    Route::match(['get','post'],'wx/image ', 'WxIndexController@image');


});


//后台路由配置
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    Route::get('/', 'IndexController@index');  // 首页
    Route::match(['get', 'post'],'/login', 'AuthController@login');   // 登陆
    Route::get('/out', 'AuthController@out');   // 退出登陆

    // 基本设置
    Route::get('/index/info', 'IndexController@info');  // 修改密码
    Route::match(['get','post'],'/index/hotWord', 'IndexController@hotWord');  // 搜索热设置
    Route::post('/index/delHotWord', 'IndexController@delHotWord');  // 删除热词


    Route::get('/index/pass', 'IndexController@pass');  // 修改密码
    Route::get('/index/page', 'IndexController@page');  // 单页管理
    Route::get('/index/adv', 'IndexController@adv');  // 首页轮播图
    Route::get('/index/book', 'IndexController@book');  // 留言管理
    Route::get('/index/column', 'IndexController@column');  // 栏目管理


    // 优券头条
    Route::get('/news/index', 'NewsController@index');  // 头条列表
    Route::match(['get', 'post'],'/news/addNews', 'NewsController@addNews');  // 添加头条新闻
    Route::get('/news/editNews', 'NewsController@editNews');  // 编辑头条新闻
    Route::post('/news/delNews', 'NewsController@delNews');  // 删除头条新闻
    Route::match(['get', 'post'],'/news/commentList', 'NewsController@commentList');  // 评论列表
    Route::post('/news/delComment', 'NewsController@delComment');  // 评论列表

    // banner管理
    Route::get('/index/appBanner', 'BannerController@appBanner');  // banner列表
    Route::post('/index/addBanner', 'BannerController@addBanner');  // banner列表
    Route::post('/index/delBanner', 'BannerController@delBanner');  // banner列表

    // 用户管理
    Route::get('/user/userList', 'UserController@userList');  // 用户列表
    Route::match(['get', 'post'],'/user/addUser', 'UserController@addUser');  // 管理列表
    Route::match(['get', 'post'],'/user/editPass', 'UserController@editPass');  // 管理密码修改
    Route::get('/user/lists', 'UserController@lists');  // 用户列表
    Route::post('/user/delUser', 'UserController@delUser');  // 删除单个用户
    Route::get('/user/friendList', 'UserController@friendList');  // 邀请列表
    Route::get('/user/friendDetail', 'UserController@friendDetail');  // 邀请明细
    Route::post('/user/addReward', 'UserController@addReward');  // 邀请明细
    Route::get('/user/signList', 'UserController@signList');  // 签到七天列表
    Route::post('/user/editSignReward', 'UserController@editSignReward');  // 签到奖励状态修改

    // 淘宝订单管理
    Route::match(['get', 'post'],'/import/tbInto', 'ImportController@tbInto');  // 淘宝订单导入
    Route::get('/import/tbOrder', 'ImportController@tbOrder');  // 淘宝订单列表


});


