@include('daidai.public.header')


@include('daidai.public.menu')


<div class="layui-body">
    <!-- 内容主体区域 -->
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>批量转链接</legend>
    </fieldset>

    <div class="layui-main">
        <div class="layui-form layui-form-pane" action="">
            <div class="layui-form-item layui-form-text">
                <div class="layui-input-block">
                    <textarea name="content" id="content" placeholder="请一行一个链接...." class="layui-textarea"></textarea>
                </div>
            </div>
            {{--<div class="layui-form-item">--}}
                {{--<select name="pid" lay-verify="required" style="display: block;width: 350px;height: 38px;border: 1px solid #dedede;">--}}
                    {{--@if($config)--}}
                        {{--@foreach($config as $vo)--}}
                            {{--<option value="{{ $vo->pid }}">pid-{{ $vo->name.'-'.$vo->pid }}</option>--}}
                        {{--@endforeach--}}
                    {{--@endif--}}
                {{--</select>--}}
            {{--</div>--}}
            <div class="layui-form-item" style="text-align: center;width:50%">
                <button class="layui-btn" id="mkUrl">转换文本链接</button>
                <span class="loading-word" style="color: red;margin-left: 30px;display: none">  ...转链接中...</span>
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
        $('.loading-word').show();
        $('#self_text').val('');
        $.post('/dd/more-link', {content: content,pid:pid}, function (data) {
             $('.loading-word').hide();
            if (0 == data.status) {
                layui.use('layer', function(){
                  layui.layer.msg(data.info);
                })
            } else {
                $('#self_text').val(data.data);
            }

        }).error(function (err) {
            $('.loading-word').hide();
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


@include('daidai.public.footer')



