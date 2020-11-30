@include('tool.public.header')


@include('tool.public.menu')


<div class="layui-body" style="min-width :900px;">
    <div style="padding: 15px;">

        <!-- 内容主体区域 -->

        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>淘宝短链接</legend>
        </fieldset>
        <blockquote class="layui-elem-quote layui-text">
            输入淘宝长链接网址,可生成https://s.click.taobao.com/xxxx短链接。<br/>
            <span style="color: red">注：目前只支持(https://uland.taobao.com/quan/detail?sellerId=xxxx&activityId=xxxx)
                <br>(https://s.click.taobao.com/t?e=m%3D2%26s%3DsG2LxOLEy7IcQipKwQzePOe....）两种链接</span>
        </blockquote>
        <form class="layui-form layui-form-pane">
            <div class="layui-form-item">
                <label class="layui-form-label">淘宝长连接</label>
                <div class="layui-input-block">
                    <input type="text" name="url" autocomplete="off"
                           placeholder="例如：https://s.click.taobao.com/t?e=m%3D2%26s%3DsG2LxOLEy7IcQipKwQzePOe....）"
                           class="layui-input value1">
                </div>
            </div>


            <div class="layui-form-item" style="text-align: center">
                <button class="layui-btn" type="button" onclick="get()">生 成</button>
            </div>
        </form>


        <div class="layui-form layui-form-pane">
            <div class="layui-form-item">
                <label class="layui-form-label">淘宝短连接</label>
                <div class="layui-input-inline" style="width: 50%">
                    <input type="text" autocomplete="off" class="layui-input" id="url">
                </div>
                <button class="layui-btn click_copy">复制</button>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">微博短连接</label>
                <div class="layui-input-inline" style="width: 50%">
                    <input type="text" autocomplete="off" class="layui-input" id="weibo_url">
                </div>
                <button class="layui-btn click_copy">复制</button>
            </div>
        </div>
        <!-- 内容主体结束 -->
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
        var url = $("[name='url']").val();
        $.post('/tool/short-url', {url: url}, function (data) {
            if (0 == data.status) {
                layui.use('layer', function(){
                  layui.layer.msg(data.info);
                })
            } else {
                $('#url').val(data.data.short_url);
                $('#weibo_url').val(data.data.url);
            }
        }).error(function (err) {
            layui.use('layer', function(){
              layui.layer.msg('服务器错误，请联系管理员！');
            })
        });
    }



</script>


@include('tool.public.footer')



