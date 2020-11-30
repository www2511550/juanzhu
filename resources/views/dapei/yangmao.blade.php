<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>白菜菜薅羊毛</title>
    <meta name="keywords" content="白菜菜薅羊毛，褥羊毛，优惠活动，优惠券"/>
    <meta name="description" content="目前“薅羊毛”的定义越来越广泛，已经跨出了金融行业的界定，渗透到各个领域，滴滴打车等打车和拼车软件送代金券，美团外卖，饿了么点餐减免活动，百度钱包，免费送话费充流量等诸多活动，都可以称为薅羊毛。"/>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="{{ asset('js/clipboard.min.js') }}"></script>
    <script type="text/javascript">
        function showImg(url) {
            var frameid = 'frameimg' + Math.random();
            window.img = '<img id="img" src=\'' + url + '?' + Math.random() + '\' /><script>window.onload = function() { parent.document.getElementById(\'' + frameid + '\').height = document.getElementById(\'img\').height+\'px\'; }<' + '/script>';
            document.write('<iframe id="' + frameid + '" src="javascript:parent.img;" frameBorder="0" scrolling="no" width="100%" style="text-align: center"></iframe>');
        }
    </script>
</head>
<body>

<div class="container" style="margin-bottom: 10px;">
    <div class="page-header">
        <h3 style="margin: 30px 0;text-align: center">{{ $data->title }}</h3>
    </div>

    <div class="panel panel-default">
        {!! $data->content !!}
    </div>

    <h5 style="text-align: center;font-size: 12px;margin-top: 50px;"><a href="http://www.miitbeian.gov.cn/" target="_blank" style="color: #222">粤ICP备16100236号</a>Copyright @2017-{{date('Y')}} 卷猪科技 juanzhuzhu.com/url All Rights Reserved</h5>


</div>
</body>
</html>
