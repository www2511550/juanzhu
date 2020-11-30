@include('tool.public.header')


@include('tool.public.menu')


<div class="layui-body" style="min-width :900px;">
    <div style="padding: 15px;">

        <!-- 内容主体区域 -->

        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>淘宝订单查询</legend>
        </fieldset>

        <form class="layui-form layui-form-pane" action="">
            <blockquote class="layui-elem-quote layui-text">
                默认查询20分钟内的数据，以开始时间为准<br/>
            </blockquote>

            <div class="layui-form-item">
                <label class="layui-form-label">开始时间</label>
                <div class="layui-input-block">
                    <input type="text" name="start_time" autocomplete="off"
                           placeholder="例如：{{ date('Y-m-d H:i:s') }}"
                           class="layui-input value1">
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
                <button class="layui-btn" type="button" onclick="get()">查询</button>
            </div>
        </form>

        {{--订单列表--}}
        <table class="layui-table">
            <colgroup>
                <col width="150">
                <col width="200">
                <col>
            </colgroup>
            <thead>
            <tr>
                <th>标题</th>
                <th>订单号</th>
                <th>订单佣金(元)</th>
                <th>推广位（id）</th>
                <th>店铺</th>
                <th>订单时间</th>
            </tr>
            </thead>
            <tbody id="orderList">

            </tbody>
        </table>
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
        var start_time = $("[name='start_time']").val();
        var tbk_session = $("[name='tbk_session']").val();
        $.post('/tool/tbk-order', {start_time: start_time, tbk_session:tbk_session}, function (data) {
            if (0 == data.status) {
                layui.use('layer', function(){
                  layui.layer.msg(data.info);
                })
            } else {
                var xqo = eval(data.data);
                var str = "";
                for(var i in xqo){
                    str += ("<tr>"
                    +"<td>" + xqo[i].item_title + "</td>"
                    +"<td>" + xqo[i].trade_id + "</td>"
                    +"<td>" + xqo[i].seller_shop_title +"</td> "
                    +"<td>" + xqo[i].adzone_name +"("+xqo[i].adzone_id+")" +"</td>"
                    +"<td>" + xqo[i].seller_shop_title +"</td>"
                    +"<td>" + xqo[i].create_time +"</td>"
                    +"</tr>");
                }
                $("#orderList").append(str);
            }
        }).error(function (err) {
            layui.use('layer', function(){
              layui.layer.msg('服务器错误，请联系管理员！');
            })
        });
    }




</script>


@include('tool.public.footer')



