<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>发微博-微博跳转淘宝</title>
    <meta name="keywords" content="手动发微博，微博跳转淘宝，怎么实现微博跳转到淘宝app，微博跳转淘宝app，怎么在微博内打开淘宝优惠券"/>
    <meta name="description" content="手动、自动发微博-专注帮助淘客实现微博跳转淘宝app！"/>
     <link rel="stylesheet" href="{{ asset('css/bootstrap40.min.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap337.min.js') }}"></script>
     <script src="{{ asset('js/clipboard.min.js') }}"></script>
    <style>
        ul{
            display: block;position: relative;height: auto;width: 100%;
        }
        ul.imgs>li{
            list-style: none;float: left;margin-right: 5px;
        }
        ul.imgs>li>img{
            width: 150px;height: 150px;
        }

    </style>
</head>
<body>


<p style="text-align: center;padding-top: 5px;"><a href="http://tool.juanzhuzhu.com/" style="color: red;text-decoration:underline">👉新版(微博)淘客工具箱已上线，欢迎大家使用和吐槽！👈</a></p>

<nav class="navbar navbar-default navbar-fixed-top container-fluid">
    <p class="navbar-text"></p>
    <p class="navbar-text navbar-right">
        @if($_SESSION['wb_cookie'])
            <a target="_blank" href="https://weibo.com/logout.php?backurl=">微博已授权</a>
        @else
            微博授权：<a href="{{ $code_url }}" class="navbar-link" data-toggle="modal" data-target="#login"><img src="/weibo_login.png" title="点击进入授权页面" alt="点击进入授权页面" border="0" style="width: 50%;" /></a>
        @endif
    </p>

</nav>

<div class="container" style="margin-bottom: 10px;">
    <div class="page-header">
        <h3 style="margin: 20px 0;text-align: center">手动发微博</h3>
    </div>


    <div class="content-main">
        <div class="form-group">
            <label for="exampleInputEmail1">微博内容：</label>
            <textarea name="content" id="content" placeholder="微博内容不允许超出140个字符" maxlength="140" class="form-control"></textarea>
        </div>
        {{--<div class="form-group">--}}
            {{--<label for="exampleInputEmail1">微博COOKIE：</label>--}}
            {{--<input type="text" class="form-control" name="cookie" placeholder="微博cookie">--}}
        {{--</div>--}}
        <div class="form-group">
            <label for="exampleInputEmail1">微博图片：</label>
            <input type="text" class="form-control" name="goodsId" placeholder="输入淘宝商品id" style="width: 50%;display: inline-block;">
            <button type="button" class="btn btn-info" id="getImg" style="display: inline-block;">获取图片</button>
        </div>
        <div class="form-group">
            <ul class="imgs" id="imgs">
            </ul>
        </div>
        <div class="content-secondary" style="text-align: center">
            <button type="button" class="btn btn-info" id="mkUrl">发送</button>
        </div>
    </div>


    <h3 style="margin-top: 50px;">FAQ：</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5 class="panel-title">发微博功能介绍</h5>
        </div>
        <div class="panel-body">
            A、只支持单张图片微博
        </div>
    </div>
    <br>
    <div class="panel-heading">
        <h5 class="panel-title">需要自动发微博可以咨询QQ：</h5><span style="color:red;">1248694991</span>
    </div>


    <h5 style="text-align: center;font-size: 12px;margin-top: 50px;"><a href="http://www.miitbeian.gov.cn/" target="_blank" style="color: #222">粤ICP备16100236号</a>Copyright @2017-{{date('Y')}} 卷猪科技 juanzhuzhu.com/url All Rights Reserved</h5>


</div>

<!-- 登录窗口 -->
<div id="login" class="modal" style="background: #dfdfdf">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-title">
                <h1 class="text-center">微博登录</h1>
            </div>
            <div class="modal-body">
                <form class="form-group" action="/wb/login" method="post">
                    <div class="form-group">
                        <label for="">微博用户名</label>
                        <input class="form-control" name="username" type="text" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">微博密码</label>
                        <input class="form-control" name="password" type="password" placeholder="">
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">登录</button>
                        <button class="btn btn-danger" data-dismiss="modal">取消</button>
                    </div>
                    <a href="javascript:;">请放心使用，本平台不会存储个人账号，只用来获取登陆信息</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="http://cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
<script>
    $('#mkUrl').on('click', function (e) {
        var content = $('#content').val();
        if (!content) {
            return alert('请输入微博内容');
        }
        var imgs = $('#imgs>li>img').attr('src');
        var cookie = $("[name='cookie']").val();
        $.post('/wb/pic-text', {content: content,imgs:imgs, cookie:cookie}, function (data) {
            if (0 == data.status) {
                alert(data.info);
            } else {
                alert(data.info);
            }
        }).error(function (err) {
            alert('服务器错误，请联系管理员！');
        });
    })

    $('#getImg').on('click', function (e) {
        var goodsId = $("[name='goodsId']").val();
        $.post('/wb/tb-imgs', {goods_id: goodsId}, function (data) {
            if (0 == data.status) {
                alert(data.info);
            } else {
                $('#imgs>li').remove();
                var html = '';
                for(var i in data.data){
                    html += '<li><img src="'+data.data[i]+'"></li>';
                }
                $('#imgs').append(html);
            }
        }).error(function (err) {
            alert('服务器错误，请联系管理员！');
        });
    })

    window.onload = function() {
        var clipboard = new Clipboard('.click_copy', {
            text: function(e) {
                return $(e).siblings('input.form-control').val();
            }
        });
        clipboard.on('success', function(e) {
            alert('短连接复制成功！');
        });
        // 复制失败
        clipboard.on('error', function(e) {
            alert('复制失败');
        });
    }

</script>


</body>
</html>


