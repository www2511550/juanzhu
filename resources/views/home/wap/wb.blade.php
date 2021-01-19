<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>正在跳转至优惠券页面</title>

    <script language="javascript" type="text/javascript">
    </script>
</head>
<body>
<script language="javascript" type="text/javascript">
    var ur = 'n7Flzru';
    var sc = 'n7Flzru';
    var sclick = 'https://s.click.taobao.com/n7Flzru';
    var jump_domain = 'https://s.click.taobao.com/';
    /**
    var ur = String(window.location).substring(String(window.location).indexOf('/') + 1);
    ur = ur.substring(ur.indexOf('/') + 1);
    ur = ur.substring(ur.indexOf('/') + 1);
    if(ur.indexOf('/')!= -1){
        ur=ur.substring(0,ur.indexOf('/'));
    }else if(ur.indexOf('?')!= -1){
        ur=ur.substring(0,ur.indexOf('?'));
    }else if(ur.indexOf('.')!= -1){
        ur=ur.substring(0,ur.indexOf('.'));
    }
    **/
    var ua = navigator.userAgent.toLowerCase();//获取判断用的对象
    if (ua.match(/WeiBo/i) == "weibo") {
    //if (1==1){
        document.body.style.backgroundColor = "#FC5200";
        //在新浪微博客户端打开
        var ifr = document.createElement('iframe');
        var url = "tbopen://m.taobao.com/tbopen/index.html?action=ali.open.nav&module=h5&bootImage=0&h5Url={jump_url}"
        ifr.src = url.replace(/{jump_url}/, encodeURI(jump_domain + ur));
        //alert(ifr.src);
        ifr.style.display = 'none';
        document.body.appendChild(ifr);
    } else {
        window.location.href = decodeURIComponent(jump_domain + ur);
    }
</script>

<img src="https://ae03.alicdn.com/kf/Ha03196a2cccd4743b84e55b602677c73o.jpg" style="float:right;"/>

</body>
</html>