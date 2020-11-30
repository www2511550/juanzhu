@include('tool.public.header')


@include('tool.public.menu')


<div class="layui-body">
    <!-- 内容主体区域 -->
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>文本内容链接转换</legend>
    </fieldset>

    <div class="layui-main">
        <div class="layui-form layui-form-pane" action="">
            <blockquote class="layui-elem-quote layui-text">
                文本内容转换为自己的淘客链接，目前只支持单个商品的链接转换<br/>
                <span style="color: red">注：链接转换后为没有显示，表示转换失败，需手动处理，如果链接全部不显示，请检查个人中心session和pid是否过期</span>
            </blockquote>
            <div class="layui-form-item layui-form-text">
                <div class="layui-input-block">
                    <textarea name="content" id="content" placeholder="请输入需要转换的文本内容..." class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">联盟PID</label>
                <div class="layui-input-block">
                    <input type="text" name="pid" autocomplete="off" required
                           placeholder="个人中心已绑定不用填写，例如：mm_xxxxx_xxxxxx_xxxxx"
                           class="layui-input value1">
                </div>
            </div>
            <div class="layui-form-item" style="text-align: center;width:50%">
                <button class="layui-btn" id="mkUrl">转换文本链接</button>
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
        var pid = $("[name='pid']").val();
        var content = $('#content').val();
        if (!content) {
            layui.use('layer', function(){
              layui.layer.msg('请输入需要转换的文本内容');
            })
            return false;
        }
        layui.use('layer', function(){
            layui.layer.msg('链接转换中...', {icon: 16,shade: 0.01});
        })
        $('#self_text').text('');
        $.post('/tool/text-url', {content: content,pid:pid}, function (data) {
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



