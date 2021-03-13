@include('daidai.public.header')


@include('daidai.public.menu')


<div class="layui-body">
    <!-- 内容主体区域 -->
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend style="color: #009688">添加用户</legend>
    </fieldset>

    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">用户名：</label>
            <div class="layui-input-inline">
                <input type="tel" name="username" lay-verify="required|phone" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">密&nbsp;&nbsp;&nbsp;&nbsp;码：</label>
            <div class="layui-input-inline">
                <input type="text" name="password" lay-verify="email" autocomplete="off" class="layui-input">
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
        </div>
    </div>
</div>

@include('daidai.public.footer')

<script>
layui.use('table', function(){
  $('.layui-btn').click(function(e){
        var username = $('[name="username"]').val();
        var password = $('[name="password"]').val();
        if(!username || !password){
            layer.msg('用户名或密码不能为空！');
        }else{
            $.post('/dd/add-user', {username:username,password:password}, function(result){
                if(!result.status){
                    layer.msg(data.info);
                }else{
                    layer.msg('添加成功！');
                    location.href = "/dd/user-list";
                }
            });
        }
  });
});
</script>

