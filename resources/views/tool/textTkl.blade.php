@include('tool.public.header')


@include('tool.public.menu')


<div class="layui-body">
    <!-- 内容主体区域 -->
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>带淘口令文本批量转换</legend>
    </fieldset>

    <div class="layui-main">
        <div class="layui-form layui-form-pane" action="">
            <blockquote class="layui-elem-quote layui-text">
                文本内容中的口令都将被替换为微博短链接<br/>
                <span style="color: red">注：链接转换后显示【为识别】，请检查口令是否能打开，如果要转成自己高佣金链接或口令，请联系管理员QQ</span>
            </blockquote>
            <div class="layui-form-item layui-form-text">
                <div class="layui-input-block">
                    <textarea name="content" id="content" placeholder="请输入带淘口令的文本内容..." class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item" style="text-align: center;width:50%">
                <button class="layui-btn" id="mkUrl">转换</button>
            </div>

            <div class="layui-form-item layui-form-text">
                <div class="layui-input-block">
                    <textarea id="self_text" class="layui-textarea"></textarea>
                </div>
            </div>
            <button class="layui-btn click_copy">复制</button>
        </div>
    </div>
</div>

<script src="{{ asset('js/clipboard.min.js') }}"></script>
<script>
    $('#mkUrl').on('click', function (e) {
        var content = $('#content').val();
        if (!content) {
            layui.use('layer', function(){
              layui.layer.msg('请输入需要转换的文本内容');
            })
            return false;
        }
        layui.use('layer', function(){
            layui.layer.msg('口令转换中...', {icon: 16,shade: 0.01});
        })
        $('#self_text').text('');
        $.post('/tool/text-tkl', {content: content}, function (data) {
            if (0 == data.status) {
                layui.use('layer', function(){
                  layui.layer.msg(data.info);
                })
            } else {
                $('#self_text').val(data.data);
            }
        }).error(function (err) {
            layui.use('layer', function(){
              layui.layer.msg('服务器错误，请联系管理员！');
            })
        });
    })

    window.onload = function() {
        var clipboard = new Clipboard('.click_copy', {
            text: function(e) {
                return $('#self_text').val();
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


@include('tool.public.footer')



