<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="Keywords" content="淘宝优惠券，天猫优惠券，优惠券折扣,9块9包邮,限时特卖,优品折扣,卷猪猪"/>
    <meta name="Description" content="优惠券折扣直播第一站！每天更新千款，纯人工筛选验货，限时限量特卖，全场1折包邮！"/>
    <title>
        @if($title)
            {{$title}}
        @else
            卷猪猪(juanzhuzhu.com)-优惠券折扣直播第一站！每天更新千款，纯人工筛选验货，限时限量特卖，全场1折包邮！
        @endif
    </title>
    <style>
        *{padding: 0;margin: 0}
        .to_url{display:inline-block;width: 50%;float: left;text-align: center;line-height: 50px;font-size: 14px;color: #fff;text-decoration: none}
        #toast {
            background: #337ccb;
            opacity: .9;
            display: none;
            color: #fff;
            padding: 12px;
            position: fixed;
            margin: auto;
            box-sizing: border-box;
            transform: translateY(-50%);
            top: 50%;
            left: 0;
            right: 0;
            max-width: 200px;
            line-height: 20px;
            z-index: 999;
            text-align: center;
            border-radius: 5px;
            -webkit-transition: all .3s ease-in;
        }
        .download>img{
            width: 100%;position: relative;
        }
    </style>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/clipboard.min.js') }}"></script>
</head>
<body>
<a href="{{$down_url}}" class="download"><img src="/images/go_down.jpg" alt=""></a>
@if(!$is_wx)
<iframe src="{{$quan_url}}" frameborder="0" style="width: 100%;height: 100%;"></iframe>
@else
<div class="img_out">
    <img src="{{ $Pic }}" alt="" style="height: 340px;width: 100%;">
    <p style="font-size: 14px;padding: 15px 5px;color: #051B28;line-height: 22px">{{ $Title }}</p>
    <p style="font-size: 14px;padding: 5px;color: #dd2727;line-height: 22px;margin-left: 5px">
        <i style="font-family: arial;font-style: normal;">¥</i>
        <span style="font-size: 24px">{{ $Price }}</span>
    </p>
    <p style="font-size: 12px;padding: 5px;color: #c40000;font-weight: 500px;">{{ $Introduce }}</p>
    <p style="padding: 10px 5px;font-size: 13px;color: #999"><span style="color: #999">月销量:</span> {{ $Sales_num }}件</p>
    <p style="padding: 10px 5px">
        <img src="//gw.alicdn.com/tps/TB1K84fLpXXXXc1XXXXXXXXXXXX-500-100.png_240x240q50.jpg" alt="" style="width: 60px;height: 12px;padding-top: 10px">
        <span style="font-size: 12px;margin-left: 10px">无条件卷: {{ $Quan_price }}元</span>
    </p>
</div>
<div class="fix_out" style="height: 40px;width:100%;position: absolute;bottom: 0;left: 0;border-top: 1px solid #dedede ">
    <a href="{{$quan_url}}" class="to_url" style="background: #fff;color:#999">直达链接</a>
    <a style="background: #DD2727" class="btncopy to_url" data-clipboard-target="#copy_data"恴ta
       data-item-info="{{ $taokouling }}">复制淘口令</a>
</div>

@endif

<div style="position:fixed;margin-left:-9999px;" id="copy_data"></div>
<div id="toast" style="display: none;">已成功复制淘口令,打开淘宝即可!</div>
<img src="{{$img}}" alt="" style="width: 0;height: 0">
<script>
    var _hmt = _hmt || [];
    (function () {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?dc95aa8b47d7f35ed5010d3ae94f2382";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
    $('.btncopy').on('click', function() {
        var info = $(this).attr('data-item-info');
        $('#copy_data').html(info);
    });

    var clipboard = new Clipboard('.btncopy');
    clipboard.on('success', function(e) {
        $('#toast').show(0);
        $('#toast').delay(1000).hide(200);
        e.clearSelection();
    });
    clipboard.on('error', function(e) {
        alert("由于您的浏览器不兼容或当前网速较慢，复制失败，请手动复制或更换主流浏览器！");
    });

</script>
</body>
</html>