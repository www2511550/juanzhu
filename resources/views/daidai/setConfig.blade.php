@include('daidai.public.header')


@include('daidai.public.menu')


<div class="layui-body">
    <!-- 内容主体区域 -->
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>联盟PID设置</legend>
    </fieldset>

    <div class="layui-main">
        <div class="layui-form layui-form-pane" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">名称</label>
                <div class="layui-input-block">
                    <input type="text" name="pid_name" required placeholder=""
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">联盟PID</label>
                <div class="layui-input-block">
                    <input type="text" name="pid" required placeholder="例如: mm_xxxxxx_xxxxx_xxxxxx"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item" style="text-align: center">
                <button class="layui-btn" id="mkUrl">保存</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#mkUrl').on('click', function (e) {
        var pid = $("[name='pid']").val();
        var pid_name = $("[name='pid_name']").val();
        if (!pid_name || !pid) {
            layui.use('layer', function(){
              layui.layer.msg('名称或pid不能为空！');
            })
            return false;
        }
        $.post('/admin/', {pid_name: pid_name, pid:pid}, function (data) {
            layui.use('layer', function(){
                  layui.layer.msg(data.info);
                })
        }).error(function (err) {
            layui.use('layer', function(){
              layui.layer.msg('服务器错误，请联系管理员！');
            })
        });
    })

</script>


@include('daidai.public.footer')



