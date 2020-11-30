<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>登录页</title>
    <link rel="stylesheet" href="{{ asset('layui/css/layui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layui_login_register.css') }}">

</head>
<body>

<div class="login-main">
    <header class="layui-elip">登录</header>
    <form class="layui-form">
        <div class="layui-input-inline">
            <input type="text" name="username" required lay-verify="required" placeholder="用户名" autocomplete="off"
                   class="layui-input">
        </div>
        <div class="layui-input-inline">
            <input type="password" name="password" required lay-verify="required" placeholder="密码" autocomplete="off"
                   class="layui-input">
        </div>
        <div class="layui-input-inline login-btn">
            <button lay-submit lay-filter="login" class="layui-btn">登录</button>
        </div>
        <hr/>
        <!--<div class="layui-input-inline">
            <button type="button" class="layui-btn layui-btn-primary">QQ登录</button>
        </div>
        <div class="layui-input-inline">
            <button type="button" class="layui-btn layui-btn-normal">微信登录</button>
        </div>-->
        <p><a href="/tool/register" class="fl">立即注册</a>
            {{--<a href="javascript:;" class="fr">忘记密码？</a>--}}
        </p>
    </form>
</div>


<script type="text/javascript" src="{{ asset('layui/layui.js') }}"></script>
<script type="text/javascript">
    layui.use(['form','layer','jquery'], function () {
 
        // 操作对象
        var form = layui.form;
        var $ = layui.jquery;
        form.on('submit(login)',function (data) {
            console.log(data.field);
            $.ajax({
                url:'/tool/login',
                data:data.field,
                dataType:'json',
                type:'post',
                success:function (data) {
                    if (data.status == 1){
                        location.href = "/tool/weibo-to-taobao";
                    }else{
                        layer.msg(data.info);
                    }
                }
            })
            return false;
        })
 
    });
</script>
</body>
</html>