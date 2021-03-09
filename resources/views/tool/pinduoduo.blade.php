@include('tool.public.header')


@include('tool.public.menu')


<div class="layui-body">
    <!-- 内容主体区域 -->
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>微博跳拼多多APP链接转换</legend>
    </fieldset>

    <div class="layui-main">
        <div class="layui-form layui-form-pane" action="">
            <blockquote class="layui-elem-quote layui-text">
                <a  style="color: red" href="/wb" target="_blank"><<<点我体验三合一（淘宝、京东、拼多多）新版转链>>></点我体验三合一></a><br>
                输入拼多多优惠券网址,转换后的链接，可在新浪微博APP直接跳转拼多多APP,可防止微博导购拦截，提高成交率，免费转换。<br/>
                <span style="color: red">注：目前只支持p.pinduoduo.com域名</span>
            </blockquote>
            <div class="layui-form-item">
                <label class="layui-form-label">拼多多链接</label>
                <div class="layui-input-block" style="width:50%">
                    <input type="text" id="longUrl" placeholder="例如：https://p.pinduoduo.com/xxxxxx"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item" style="text-align: center;width:50%">
                <button class="layui-btn" id="mkUrl">转换链接</button>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">微博短链接</label>
                <div class="layui-input-inline" style="width:50%">
                    <input type="text" id="shortUrl" required="" lay-verify="required" lay-vertype="tips"
                           autocomplete="off" class="layui-input">
                </div>
                <button class="layui-btn click_copy">复制</button>
            </div>

            {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">淘口令</label>--}}
            {{--<div class="layui-input-inline" style="width:50%">--}}
            {{--<input type="text" id="tkl" lay-verify="required" autocomplete="off" class="layui-input">--}}
            {{--</div>--}}
            {{--<button class="layui-btn click_copy">复制</button>--}}
            {{--</div>--}}
        </div>
    </div>
</div>

<script src="{{ asset('js/clipboard.min.js') }}"></script>
<script>
    $('#mkUrl').on('click', function (e) {
        var longUrl = $('#longUrl').val();
        if (!longUrl) {
            layui.use('layer', function(){
              layui.layer.msg('请输拼多多链接');
            })
            return false;
        }
        $('#shortUrl').val('');
        $.post('/tool/short', {longUrl: longUrl, type:'pdd'}, function (data) {
            if (0 == data.status) {
                layui.use('layer', function(){
                  layui.layer.msg(data.info);
                })
            } else {
                $('#shortUrl').val(data.data.url);
                $('#tkl').val(data.data.tkl);
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


@include('tool.public.footer')



