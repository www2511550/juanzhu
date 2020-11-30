<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>
        卷猪猪(juanzhuzhu.com)-优惠券折扣直播第一站！每天更新千款，纯人工筛选验货，限时限量特卖，全场1折包邮！
    </title>
    <meta name="Keywords" content="淘宝优惠券，天猫优惠券，优惠券折扣,9块9包邮,限时特卖,优品折扣,卷猪猪"/>
    <meta name="Description" content="优惠券折扣直播第一站！每天更新千款，纯人工筛选验货，限时限量特卖，全场1折包邮！"/>
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('wap/css/index.css') }}">
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('swipe.jquery.min.js') }}"></script>
    <!--<script type="text/javascript" src="__PUBLIC__/js/jquery.lazyload.min.js"></script>-->
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?ed644c8dba9d7c42b3902ff7c0fcabb3";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>

</head>

@if($action !='shop')
  @include('home.wap.footer')
@endif