<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>特工队致富平台</title>
    {{--<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap40.min.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap337.min.js') }}"></script>
    {{--<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>--}}
    <script src="{{ asset('js/clipboard.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('layui/layui.js') }}"></script>
</head>
<body>


<div class="btn-group" role="group" style="width: 100%">
    <button type="button" class="btn {{ $action=='oneLink' ? 'btn-primary' : 'btn-default' }}" onclick="window.location='/dd/one-link'" style="width: 33.3%">单链接转换</button>
    <button type="button" class="btn {{ $action=='moreLink' ? 'btn-primary' : 'btn-default' }}" onclick="window.location='/dd/more-link'" style="width: 33.3%">批量转链接</button>
    @if(isset($_COOKIE['daidai_pid']) && $_COOKIE['daidai_pid'] == 0)
    <button type="button" class="btn {{ $action=='weibo' ? 'btn-primary' : 'btn-default' }}" onclick="window.location='/dd/weibo-to-taobao'" style="width: 33.3%">微博跳淘宝</button>
    @endif
</div>