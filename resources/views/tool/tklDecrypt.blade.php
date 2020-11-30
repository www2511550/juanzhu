@include('tool.public.header')


@include('tool.public.menu')


<div class="layui-body">
    <!-- 内容主体区域 -->
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>淘口令解密</legend>
    </fieldset>

    <div class="layui-main">
        <div class="layui-form layui-form-pane" action="">
            <form class="layui-form layui-form-pane" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">淘口令</label>
                    <div class="layui-input-block">
                        <input type="text" name="content" autocomplete="off" placeholder="请输入淘口令..."
                               class="layui-input value1" minlength="5">
                    </div>
                </div>

                <div class="layui-form-item" style="text-align: center">
                    <button class="layui-btn" type="button" onclick="get()">解密</button>
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
        $.post('/tool/tkl-decrypt', {content: content}, function (data) {
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



