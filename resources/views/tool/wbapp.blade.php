<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="Shortcut Icon" href="/wbtool.ico" type="image/x-icon">
    <title>微博跳转助手-微博短链接跳转淘宝_京东_拼多多APP</title>
    <meta name="keywords" content="微博跳转淘宝,微博链接直接跳转淘宝,微博短链接,微博跳转京东">
    <meta name="description" content="微博跳转助手提供稳定的微博链接跳转淘宝APP的功能,实现微博里打开链接直接跳转手机淘宝APP,便于微博内推广淘宝链接">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layui.min.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/layui.js') }}"></script>
    <style class="vjs-styles-defaults">
        .video-js {
            width: 300px;
            height: 150px;
        }

        .vjs-fluid {
            padding-top: 56.25%
        }
    </style>
    <style type="text/css">
        html, body {
            padding: 0;
            margin: 0;
            height: 100%;
            width: 100%
        }

        .layui-form {
            height: 460px;
            margin: auto;
            background: #ffffffa3;
            padding-top: 30px
        }

        .layui-input, .layui-textarea {
            width: 90%
        }

        .layui-elem-quote {
            border-left: 5px solid #ff5722
        }

        .layui-unselect {
            color: #fff
        }

        .layui-form-radio > i {
            color: #fff
        }

        .layui-form-radio > i:hover, .layui-form-radioed > i {
            color: #512da8
        }

        .layui-form-label {
            font-size: 20px;
            font-weight: bold;
            float: left;
            display: block;
            padding: 9px 15px;
            width: 120px;
            line-height: 20px;
            color: #512da8;
            text-align: right
        }

        .layui-form-radioed {
            color: #512da8
        }
    </style>
    <link id="layuicss-layer" rel="stylesheet" href="{{ asset('css/layer.css') }}" media="all">
</head>
<body style="">
<!--header-->
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary ">
    <a class="navbar-brand" href="/#"><img
                src="{{ asset('wb1.png') }}" width="50" alt="微博跳转助手"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item mr-3">
                <a class="nav-link page-scroll" href="/wb/#toolsy">使用功能</a>
            </li>
            <li class="nav-item mr-3">
                <a class="nav-link page-scroll" href="/wb/#toolys">功能演示</a>
            </li>
            <li class="nav-item mr-3">
                <a class="nav-link page-scroll" href="/wb/#features">功能介绍</a>
            </li>
            <li class="nav-item mr-3">
                <a class="nav-link page-scroll" href="/wb/#contact">联系客服</a>
            </li>
        </ul>
    </div>
</nav>

<!--main section-->
<section class="bg-texture hero " id="toolsy">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-white wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                <div class="mt-5 d-none d-md-block"></div>
                <h1>微博跳转 </h1>
                <h2><span class="text-orange">微博直跳淘宝、京东、拼多多（直开外链）</span></h2>
                <p class="mt-4 lead">
                    手机微博<span>直接</span>跳转淘宝APP打开指定链接（如商品链接、优惠券链接、淘宝客链接等等）
                </p>
                <p class="mt-4 lead">
                    微博跳转交流QQ：379624432
                </p>
            </div>
            <div class="col-md-12 pt-6  d-md-block wow fadeIn"
                 style="margin-top: 40px; visibility: visible; animation-name: fadeIn;">
                <div class="layui-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label">原始链接</label>
                        <div class="layui-input-block">
                            <input type="text" name="title" autocomplete="off" required="" value="" lay-verify="required"
                                   placeholder="请输入原始链接" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">跳转类型</label>
                        <div class="layui-input-block">
                            <input type="radio" name="type" value="tb" title="淘宝" checked="">
                            <div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i>
                                <div>淘宝</div>
                            </div>
                            <input type="radio" name="type" value="jd" title="京东">
                            <div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i>
                                <div>京东</div>
                            </div>
                            <input type="radio" name="type" value="pdd" title="拼多多">
                            <div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i>
                                <div>小红书</div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-block">
                            <button class="layui-btn mkUrl" lay-submit="" lay-filter="formDemo" style="background-color:#512da8;">立即生成
                            </button>
                            <input class="layui-btn ipt-reset" type="reset" style="background-color:#512da8;" value="重置">
                        </div>
                    </div>
                    <div class="layui-form-item">
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">生成结果</label>
                        <div class="layui-input-block">
                            <textarea name="desc" style="color: #512da8;" placeholder="请将生成的内容复制到微博粘贴"
                                      class="layui-textarea"></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-block">
                            <button class="layui-btn copy" type="button" style="background-color:#512da8;" data-clipboard-text="">
                                复制结果
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white" id="toolys">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-8 mx-auto text-center wow fadeIn" style="visibility: hidden; animation-name: none;">
                <h2 class="text-primary">功能演示</h2>
            </div>
        </div>
        <div class="row d-md-flex mt-4 text-center" style="justify-content: center;">
            <div class="col-sm-4 wow fadeIn" style="visibility: hidden; animation-name: none;">
                <img class="img-fluid mx-auto d-block pb-3" src="/wbtotb.gif" alt="微博跳淘宝">
            </div>
        </div>
    </div>
</section>

<!--main features-->
<section class="bg-white" id="features">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-8 mx-auto text-center wow fadeIn" style="visibility: hidden; animation-name: none;">
                <h2 class="text-primary">功能介绍</h2>
            </div>
        </div>
        <div class="row d-md-flex mt-4 text-center">
            <div class="col-sm-6 col-md-4 mt-2">
                <div class="card border-none wow fadeIn" style="visibility: hidden; animation-name: none;">
                    <div class="card-body">
                        <div class="icon-box" style="background-image: url(/wb1.png);background-repeat: round; ">
                        </div>
                        <h5 class="card-title text-primary pt-5">什么是微博跳淘宝？</h5>
                        <p class="card-text">微博跳淘宝的功能是可以实现微博内打开链接直接跳转到淘宝APP打开指定页面</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mt-2">
                <div class="card border-none wow fadeIn" style="visibility: hidden; animation-name: none;">
                    <div class="card-body">
                        <div class="icon-box" style="background-image: url(/wb2.png);background-repeat: round;">
                        </div>
                        <h5 class="card-title text-primary pt-5">微博跳淘宝有哪些好处？</h5>
                        <p class="card-text">便于淘宝客、淘宝商家在微博推广淘宝商品、优惠券等链接</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mt-2">
                <div class="card border-none wow fadeIn" style="visibility: hidden; animation-name: none;">
                    <div class="card-body">
                        <div class="icon-box" style="background-image: url(/wb3.png);background-repeat: round; ">

                        </div>
                        <h5 class="card-title text-primary pt-5">功能是否会失效？</h5>
                        <p class="card-text">本站的跳转技术是采用官方接口研发而成</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--team-->
<section class="bg-white" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-8 mx-auto text-center">
                <h2 class="text-primary">联系客服</h2>
            </div>
        </div>
        <div class="row d-md-flex mt-4 text-center">
            <div class="col-sm-6 mt-2 wow fadeIn" style="visibility: hidden; animation-name: none;">
                <div class="card border-none">
                    <div class="card-body">
                        <img src="{{ asset('weixin.png') }}" alt=""
                             class="img-team img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mt-2 wow fadeIn" style="visibility: hidden; animation-name: none;">
                <div class="card border-none">
                    <div class="card-body">
                        <img src="{{ asset('qq.png') }}" alt=""
                             class="img-team img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--footer-->
<section class="bg-dark pt-5" id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-xs-12 text-center wow fadeIn"
                 style="visibility: hidden; animation-name: none;">
                <p class="pt-2 text-muted">
                    Copyright © 2017 - {{ date('Y') }} 微博跳转助手｜微博跳转淘宝｜微博链接直接跳转淘宝
                </p>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/wow.min.js') }}"></script>
<script src="{{ asset('js/scripts.min.js') }}"></script>
<script src="{{ asset('js/clipboard.min.js') }}"></script>
<script>
    window.onload = function() {
        var clipboard = new Clipboard('.copy', {
            text: function(e) {
                return $("[name='desc']").val();
            }
        });
        clipboard.on('success', function(e) {
            layui.use('layer', function(){
              layui.layer.msg('复制成功');
            })
        });
        // 复制失败
        clipboard.on('error', function(e) {
            layui.use('layer', function(){
              layui.layer.msg('复制失败！');
            })
        });
    }
$(document).ready(function(){
    layui.use('form', function(){
        var form = layui.form;

    });


    $('.mkUrl').click(function(){
        var title = $("[name='title']").val();
        var type = $('input[name="type"]:checked').val();
        if(title){
            var request_url = (type == 'tb' ? '/tool/short-url' : '/tool/short')
            $.post(request_url, {url: title, type:type}, function (data) {
                if (0 == data.status) {
                    layui.use('layer', function(){
                      layui.layer.msg(data.info);
                    })
                } else {
                    $("[name='desc']").val(data.data.url);
                }
            }).error(function (err) {
                layui.use('layer', function(){
                  layui.layer.msg('服务器错误，请联系管理员！');
                })
            });
        }
    })

    $('.ipt-reset').click(function(){
        $("[name='title']").val('')
    })

});

</script>


</body>
</html>