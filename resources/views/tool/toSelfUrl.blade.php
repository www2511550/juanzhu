@include('tool.public.header')


@include('tool.public.menu')


<div class="layui-body">
    <!-- 内容主体区域 -->
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>他人链接转换为自己的高佣链接</legend>
    </fieldset>

    <div class="layui-main">
        <div class="layui-form layui-form-pane" action="">
            <blockquote class="layui-elem-quote layui-text">
                他人淘客链接转换为自己的淘客链接<br/>
                <span style="color: red">注：商品id、淘口令、uload、s.click，或tb.cn等短链接均支持，优先返回带券地址</span>
            </blockquote>
            <form class="layui-form layui-form-pane" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">他人链接</label>
                    <div class="layui-input-block">
                        <input type="text" name="content" autocomplete="off" placeholder="商品id、淘口令、uload、s.click，或tb.cn"
                               class="layui-input value1" minlength="5">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">自己的PID</label>
                    <div class="layui-input-block">
                        <input type="text" name="pid" autocomplete="off" placeholder="mm_xxxx_xxx_xxx，个人中心设置可不填写" class="layui-input value3">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">授权session</label>
                    <div class="layui-input-block">
                        <input type="text" name="tbk_session" autocomplete="off"
                               placeholder="已绑定可以不用填写"
                               class="layui-input value1">
                    </div>
                </div>

                <div class="layui-form-item" style="text-align: center">
                    <button class="layui-btn" type="button" onclick="get()">生 成</button>
                </div>
            </form>

            <div class="layui-form-item">
                <div class="layui-input-inline" style="width:50%;display: block">
                    <textarea name="selfContent" id="selfContent" placeholder="" class="layui-textarea"></textarea>
                </div><br/><br/>
                <button class="layui-btn click_copy">复制</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/clipboard.min.js') }}"></script>
<script>
    window.onload = function() {
        var clipboard = new Clipboard('.click_copy', {
            text: function(e) {
                return $('#selfContent').val();
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

    // 异步获取
    function get(){
        var content = $("[name='content']").val();
        var pid = $("[name='pid']").val();
        var tbk_session = $("[name='tbk_session']").val();
        $.post('/tool/to-self-url', {content: content,pid:pid,tbk_session:tbk_session}, function (data) {
            if (0 == data.status) {
                layui.use('layer', function(){
                  layui.layer.msg(data.info);
                })
            } else {
                $('#selfContent').val(data.data);
            }
        }).error(function (err) {
            layui.use('layer', function(){
              layui.layer.msg('服务器错误，请联系管理员！');
            })
        });
    }




</script>


@include('tool.public.footer')



