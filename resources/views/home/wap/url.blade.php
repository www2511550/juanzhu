<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>微博短链接转换-支持微博跳转淘宝</title>
    <meta name="keywords" content="微博跳转淘宝，怎么实现微博跳转到淘宝app，微博跳转淘宝app，怎么在微博内打开淘宝优惠券"/>
    <meta name="description" content="微博跳转淘宝-专注帮助淘客实现微博跳转淘宝app！"/>
    {{--<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap40.min.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap337.min.js') }}"></script>
    {{--<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>--}}
    <script src="{{ asset('js/clipboard.min.js') }}"></script>
</head>
<body>


<p style="text-align: center;padding-top: 5px;"><a href="http://tool.juanzhuzhu.com/" style="color: red;text-decoration:underline">👉新版淘客工具箱已上线，欢迎大家使用和吐槽！👈</a></p>

<nav class="navbar navbar-default navbar-fixed-top container-fluid">
    <p class="navbar-text">
        @if($_COOKIE['url_uid'])
            <span style="padding:0 20px;">{{$_COOKIE['url_username']}}</span>
            @if($_COOKIE['is_free'] == 2)
                <button type="button" class="btn btn-warning" style="margin: 0 20px;">会员</button>
            @else
                <button type="button" class="btn btn-info">免费版</button>
            @endif

        @endif
    </p>
    <p class="navbar-text"></p>


    <p class="navbar-text navbar-right">
        @if($_COOKIE['url_uid'])
            <a href="{{ route('url.out') }}">退出</a>
        @else
            <a  style="color: #222;" href="#" class="navbar-link" data-toggle="modal" data-target="#login">登陆</a>
            <a  style="margin: 0 20px;color: #222;" href="#" class="navbar-link" data-toggle="modal" data-target="#register">注册</a>
        @endif
    </p>

</nav>

<div class="container" style="margin-bottom: 10px;">
    <div class="page-header">
        <h3 style="margin: 20px 0;text-align: center">微博跳淘宝短链接</h3>
    </div>


    <div class="content-main">
        <div class="form-group">
            <label for="exampleInputEmail1">淘宝(联盟二合一优惠券)链接：</label>
            <input type="text" class="form-control" id="longUrl" placeholder="如：https://s.click.taobao.com/miYfmQw" >
        </div>
        <div class="content-secondary" style="text-align: center">
            <button type="button" class="btn btn-info" id="mkUrl">转换网址</button>
        </div>

        <div class="form-group" style="margin-top: 20px">
            <label for="exampleInputPassword1" style="display: block">短链接结果：</label>
            <input type="text" class="form-control" id="shortUrl" placeholder="" style="width:82%;display: inline-block">
            <button type="button" class="btn btn-success click_copy" style="float: right;">复制</button>
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1" style="display: block">淘口令：</label>
            <input type="text" class="form-control" id="tkl" placeholder="" style="width:82%;display: inline-block">
            <button type="button" class="btn btn-success click_copy" style="float: right">复制</button>
        </div>
    </div>


    <h3 style="margin-top: 50px;">FAQ：</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5 class="panel-title">Q、为什么要注册和限制转换次数</h5>
        </div>
        <div class="panel-body">
            A、防止脚本抓取转换接口，给服务器带来压力。
            <br>B、使用人数增多，会使数据库压力越来越大，为了链接能更快的转换和打开，故限制转换次数 <span style="color: red">(100次/天)</span>
            <br><span style="color: red">注：如有链接转换需求较大，可以联系管理员开通，只为更好的体验！</span>
        </div>
    </div>
    <br>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5 class="panel-title">Q、用途介绍</h5>
        </div>
        <div class="panel-body">
            A、输入淘宝优惠券网址,转换以后就可在新浪微博APP直接跳转淘宝APP,可防止微博导购拦截，提高成交率，免费转换。
            <br><span style="color: red">注：uland.taobao.com域名暂不支持，建议使用联盟https://s.click.taobao.com/xxxxxx链接</span>
        </div>
    </div>
    <br>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5 class="panel-title">Q、是否安全可靠？</h5>
        </div>
        <div class="panel-body">
            A、阿里云服务器,安全可靠，支持链接和淘口令双重保证。
        </div>
    </div>
    <br>
    <div class="panel-heading">
        <h5 class="panel-title">咨询QQ：</h5>1248694991
    </div>


    <h5 style="text-align: center;font-size: 12px;margin-top: 50px;"><a href="http://www.miitbeian.gov.cn/" target="_blank" style="color: #222">粤ICP备16100236号</a>Copyright @2017-{{date('Y')}} 卷猪科技 juanzhuzhu.com/url All Rights Reserved</h5>


</div>

<!-- 注册窗口 -->
<div id="register" class="modal" tabindex="-1" style="background: #dfdfdf">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-title">
                <h1 class="text-center">注册</h1>
            </div>
            <div class="modal-body">
                <form class="form-group" action="{{ route('url.register') }}"  method="post">
                    <div class="form-group">
                        <label for="">用户名</label>
                        <input class="form-control" name="username" type="text" placeholder="6-15位字母或数字">
                    </div>
                    <div class="form-group">
                        <label for="">密码</label>
                        <input class="form-control" name="password" type="password" placeholder="至少6位字母或数字">
                    </div>
                    <div class="form-group">
                        <label for="">再次输入密码</label>
                        <input class="form-control" name="pwd" type="password" placeholder="至少6位字母或数字">
                    </div>
                    <div class="form-group">
                        <label for="">邮箱</label>
                        <input class="form-control" name="email" type="email" placeholder="例如:123@123.com">
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">提交</button>
                        <button class="btn btn-danger" data-dismiss="modal">取消</button>
                    </div>
                    <a href="" data-toggle="modal" data-dismiss="modal" data-target="#login">已有账号？点我登录</a>
                </form>
            </div>
        </div>
    </div>
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
                <h1 class="text-center">登录</h1>
            </div>
            <div class="modal-body">
                <form class="form-group" action="{{ route('url.login') }}" method="post">
                    <div class="form-group">
                        <label for="">用户名</label>
                        <input class="form-control" name="username" type="text" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">密码</label>
                        <input class="form-control" name="password" type="password" placeholder="">
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">登录</button>
                        <button class="btn btn-danger" data-dismiss="modal">取消</button>
                    </div>
                    <a href="" data-toggle="modal" data-dismiss="modal" data-target="#register">还没有账号？点我注册</a>
                </form>
            </div>
        </div>
    </div>
</div>




<script src="http://cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
<script>
    $('#mkUrl').on('click', function (e) {
        var longUrl = $('#longUrl').val();
        if (!longUrl) {
            return alert('请输入长链接');
        }
        $('#shortUrl').val('');
        $.post('/url/short', {longUrl: longUrl}, function (data) {
            if (0 == data.status) {
                alert(data.info);
            } else {
                $('#shortUrl').val(data.data.url);
                $('#tkl').val(data.data.tkl);
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
