@include('daidai.public.header')


@include('daidai.public.menu')


<div class="layui-body">
    <!-- 内容主体区域 -->
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>个人中心</legend>
    </fieldset>

    <div class="layui-main">
        <div class="layui-form layui-form-pane" action="">

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 150px">联盟PID</label>
                <div class="layui-input-inline" style="width:50%">
                    <input type="text" name="tbk_pid" value="{{ isset($user->tbk_pid) ? $user->tbk_pid : '' }}" placeholder="例如：mm_xxxxx_xxxxx_xxxxx"
                           autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 150px">高佣授权码</label>
                <div class="layui-input-inline" style="width:80%">
                    <input type="text" name="tbk_session" value="{{ isset($user->tbk_session) ? $user->tbk_session : '' }}"
                           autocomplete="off" class="layui-input">
                    @if($user) <p style="color: red">有效期剩余天数：{{ isset($user->last_day) ? $user->last_day : 0 }}天</p> @endif
                </div>
            </div>

            <div class="layui-form-item" style="text-align: center;width:50%">
                <button class="layui-btn" id="save">保存</button>
            </div>


            <blockquote class="layui-elem-quote layui-text">
                <h3 class="layui-timeline-title">如何获取淘宝高佣授权码</h3>
                <p style="line-height: 50px;">
                    1、先访问：<a style="color: red" target="_blank" href="https://oauth.taobao.com/authorize?response_type=token&client_id=23196777&state=1212&view=web">>>淘宝授权传送门</a>
                </p>
                <p><img src="{{ asset('images/tool/session_1.png') }}" alt=""></p>
                <p style="line-height: 50px;">2、登陆淘宝后，复制下图红圈的sessionKey。</p>
                <p><img src="{{ asset('images/tool/session_2.png') }}" alt=""></p>
            </blockquote>

        </div>
    </div>
</div>

<script src="{{ asset('js/clipboard.min.js') }}"></script>
<script>
    $('#save').on('click', function (e) {
        var tbk_session = $("[name='tbk_session']").val();
        var tbk_pid = $("[name='tbk_pid']").val();
        if (!(tbk_session || tbk_pid)) {
            layui.use('layer', function(){
              layui.layer.msg('请填写高佣授权码或联盟PID');
            })
            return false;
        }
        $.post('/tool/personal', {tbk_session: tbk_session,tbk_pid:tbk_pid}, function (data) {
            layui.use('layer', function(){
              layui.layer.msg(data.info);
            })
        }).error(function (err) {
            layui.use('layer', function(){
              layui.layer.msg('服务器错误，请联系管理员！');
            })
        });
    })

    window.onload = function() {
        var clipboard = new Clipboard('.click_copy', {
            text: function(e) {
                return $(e).siblings('div.layui-input-inline').find('input').val();
            }
        });
        clipboard.on('success', function(e) {
            layui.use('layer', function(){
              layui.layer.msg('短连接复制成功');
            })
        });
        // 复制失败
        clipboard.on('error', function(e) {
            layui.use('layer', function(){
              layui.layer.msg('复制失败！');
            })
        });
    }




</script>


@include('daidai.public.footer')



