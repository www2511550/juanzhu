<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="Shortcut Icon" href="/wbtool.ico" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>淘客工具箱-微博短链接跳转淘宝_京东_拼多多</title>
    <meta name="keywords" content="微博跳转淘宝,微博链接直接跳转淘宝,微博短链接,微博跳转京东,淘客工具箱">
    <meta name="description" content="淘客工具箱提供稳定的微博链接跳转淘宝APP的功能,实现微博里打开链接直接跳转手机淘宝APP,便于微博内推广淘宝链接">
    <link rel="stylesheet" href="{{ asset('layui/css/layui.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>

<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo"><a href="/" style="color: #009688;">淘宝客API开放平台</a></div>

        @if($_COOKIE['url_uid'])
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item">
                    <a href="javascript:;">
                        <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                        {{ $_COOKIE['url_username'] }}
                    </a>
                    <dl class="layui-nav-child" style="text-align: center">
                        <dd><a href="/tool/out">退出</a></dd>
                    </dl>
                </li>
            </ul>
        @else
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item">
                    <a href="/tool/login" id="login">登录</a>
                </li>
                <li class="layui-nav-item">
                    <a href="/tool/register" id="login">注册</a>
                </li>
            </ul>
        @endif
    </div>