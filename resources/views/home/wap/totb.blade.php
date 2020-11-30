<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>{{ $title ?: '卷猪优惠券' }}</title>
    <style>
        *{margin: 0;padding: 0}
    </style>
</head>
<body>

<iframe id="mainiframe" width="100%" height="600" src="{{ $url }}"  frameborder="0" scrolling="auto"></iframe>


<script>
    function changeFrameHeight(){
        var ifm= document.getElementById("mainiframe");
        ifm.height=document.documentElement.clientHeight-56;
    }
    window.onresize=function(){ changeFrameHeight();}
    $(function(){changeFrameHeight();});
</script>

</body>
</html>
