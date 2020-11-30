

<style>
    h2{ font-size:18px; font-weight:bold; line-height:45px;}
    .prompt{ line-height:30px; margin-top:10px; font-size:16px;} .msgExp{ line-height:30px; font-size:14px; margin-top:10px;}
    .tip{margin: 80px 0 100px 300px; min-height: 150px; padding-left: 55px; position: relative; }
    dt{margin-bottom: 30px; } h1{font-size: 22px; font-weight: bold; } dd{margin-bottom: 10px; }
    dd p{padding-bottom: 5px; }
    .success{background-position: 0 -67px;color: #00aa00 } .error{background-position: -39px -67px;color: red } .warn{background-position: -78px -67px; }
</style>

<div class="tip">
    <dl style="margin-left:150px;">
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
            <div class="msgExp">{!! $explain !!}</div>
        </div>
    </dl>
</div>

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

