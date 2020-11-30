@include('daidai.public.header')


@include('daidai.public.menu')


<div class="layui-body">
    <!-- 内容主体区域 -->
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>淘口令生成</legend>
    </fieldset>

    <div class="layui-main">
        <div class="layui-form layui-form-pane" action="">

            <form class="layui-form layui-form-pane" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">弹框内容</label>
                    <div class="layui-input-block">
                        <input type="text" name="content" autocomplete="off" placeholder="长度大于5个字符"
                               class="layui-input value1" minlength="5">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">跳转目标页</label>
                    <div class="layui-input-block">
                        <input type="text" name="to_url" autocomplete="off"
                               placeholder="例如：https://uland.taobao.com/coupon/edetail?e=....)"
                               class="layui-input value2">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">弹框Logo</label>
                    <div class="layui-input-block">
                        <input type="text" name="logo_url" autocomplete="off" placeholder="" class="layui-input value3">
                    </div>
                </div>

                <div class="layui-form-item" style="text-align: center">
                    <button class="layui-btn" type="button" onclick="get()">生 成</button>
                </div>
            </form>

            <div class="layui-form-item">
                <label class="layui-form-label">淘口令</label>
                <div class="layui-input-inline" style="width:50%">
                    <input type="text" id="tkl" lay-verify="required" autocomplete="off" class="layui-input">
                </div>
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

    // 异步获取
    function get(){
        var content = $("[name='content']").val();
        var to_url = $("[name='to_url']").val();
        var logo_url = $("[name='logo_url']").val();
        $.post('/dd/tkl-create', {content: content,to_url:to_url,logo_url:logo_url}, function (data) {
            if (0 == data.status) {
                layui.use('layer', function(){
                  layui.layer.msg(data.info);
                })
            } else {
                $('#tkl').val(data.tkl);
            }
        }).error(function (err) {
            layui.use('layer', function(){
              layui.layer.msg('服务器错误，请联系管理员！');
            })
        });
    }




</script>


@include('daidai.public.footer')



