<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>
        卷猪猪(juanzhuzhu.com)-优惠券折扣直播第一站！每天更新千款，纯人工筛选验货，限时限量特卖，全场1折包邮！
    </title>
    <meta name="Keywords" content="淘宝优惠券，天猫优惠券，优惠券折扣,9块9包邮,限时特卖,优品折扣,卷猪猪"/>
    <meta name="Description" content="优惠券折扣直播第一站！每天更新千款，纯人工筛选验货，限时限量特卖，全场1折包邮！"/>
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
</head>


<style>
    h2{ font-size:18px; font-weight:bold; line-height:45px;text-align: center}
    dt{margin-bottom: 30px; } h1{font-size: 22px; font-weight: bold; } dd{margin-bottom: 10px; }
    dd p{padding-bottom: 5px; }
    .success{background-position: 0 -67px;color: #00aa00;text-align: center} .error{background-position: 0 -67px;color: red;text-align: center } .warn{background-position: -78px -67px; }
</style>

<dl style="margin-top: 70px;">
    <dt>
    <h1>
        <present name="message">
            <p class="error"><?php echo($msg); ?></p>
        </present>
    </h1>
    </dt>
    <dd><h2>
            頁面自動 <a id="href" href="{{ $url }}">跳轉</a> 等待時間： <b id="wait">{{$second}}</b>
        </h2></dd>
    <div class="prompt">
        <div class="msgExp" style="text-align: center">{!! $explain !!}</div>
    </div>
</dl>

<script type="text/javascript">
    (function(){
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    })();
</script>