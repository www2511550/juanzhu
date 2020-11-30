<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>
        {{ $title ?: '卷猪优惠券' }}
    </title>
    <meta name="Keywords" content="淘宝优惠券，天猫优惠券，优惠券折扣,9块9包邮,限时特卖,优品折扣,卷猪猪"/>
    <meta name="Description" content="优惠券折扣直播第一站！每天更新千款，纯人工筛选验货，限时限量特卖，全场1折包邮！"/>
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>