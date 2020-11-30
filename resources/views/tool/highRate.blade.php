@include('tool.public.header')


@include('tool.public.menu')


<div class="layui-body" style="min-width :900px;">
    <div style="padding: 15px;">

        <!-- 内容主体区域 -->

        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>单品券高效转链(高佣API)</legend>
        </fieldset>

        <form class="layui-form layui-form-pane" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">商品id</label>
                <div class="layui-input-block">
                    <input type="text" name="itemId" autocomplete="off" required
                           placeholder="例如：525107009904"
                           class="layui-input value1">
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

            <div class="layui-form-item">
                <label class="layui-form-label">授权session</label>
                <div class="layui-input-block">
                    <input type="text" name="session" autocomplete="off"
                           placeholder="个人中心已绑定可以不用填写"
                           class="layui-input value1">
                </div>
            </div>

            <div class="layui-form-item" style="text-align: center">
                <button class="layui-btn" type="button" onclick="get()">生 成</button>
            </div>
        </form>


        <div class="layui-form layui-form-pane" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">高佣优惠券</label>
                <div class="layui-input-inline" style="width: 80%">
                    <input type="text" autocomplete="off" class="layui-input" id="coupon_url">
                </div>
                <button class="layui-btn click_copy">复制</button>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">微博短链接(优惠券)</label>
                <div class="layui-input-inline" style="width: 80%">
                    <input type="text" autocomplete="off" class="layui-input" id="weibo_url">
                </div>
                <button class="layui-btn click_copy">复制</button>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">高佣商品</label>
                <div class="layui-input-inline" style="width: 80%">
                    <input type="text" autocomplete="off" class="layui-input" id="item_url">
                </div>
                <button class="layui-btn click_copy">复制</button>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">佣金比例</label>
                <div class="layui-input-inline" style="width: 80%">
                    <input type="text" autocomplete="off" class="layui-input" id="max_rate">
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
        return false;
    }

    // 异步获取
    function get(){
        var itemId = $("[name='itemId']").val();
        var pid = $("[name='pid']").val();
        var session = $("[name='session']").val();
        $.post('/tool/high-rate', {itemId: itemId,pid:pid,session:session}, function (data) {
            if (0 == data.status) {
                layui.use('layer', function(){
                  layui.layer.msg(data.info);
                })
            } else {
                $('#coupon_url').val(data.data.coupon_url);
                $('#weibo_url').val(data.data.weibo_url);
                $('#item_url').val(data.data.item_url);
                $('#max_rate').val(data.data.max_rate);
            }
        }).error(function (err) {
            layui.use('layer', function(){
              layui.layer.msg('服务器错误，请联系管理员！');
            })
        });
    }




</script>


@include('tool.public.footer')



