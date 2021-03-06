<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>特工队致富平台</title>
    <link rel="stylesheet" href="{{ asset('layui/css/layui.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>

<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo"><a href="/" style="color: #009688;">特工队致富平台</a></div>

        @if($_COOKIE['daidai_uid'])
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item">
                    <a href="javascript:;">
                        <img src="http://t.cn/RCzsdCq" class="layui-nav-img">{{ $_COOKIE['daidai_username'] }}
                    </a>
                    <dl class="layui-nav-child" style="text-align: center">
                        <dd><a href="/dd/out">退出</a></dd>
                    </dl>
                </li>
            </ul>
        @else
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item">
                    <a href="/dd/login" id="login">登录</a>
                </li>
                {{--<li class="layui-nav-item">--}}
                    {{--<a href="/dd/register" id="login">注册</a>--}}
                {{--</li>--}}
            </ul>
        @endif
    </div>