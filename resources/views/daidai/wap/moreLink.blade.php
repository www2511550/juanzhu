@include('daidai.wap.header')

<div class="container" style="margin-bottom: 10px;">
    <div class="page-header">
        <h3 style="margin: 20px 0;text-align: center">批量转链接</h3>
    </div>


    <div class="content-main">
        <div class="form-group">
            <textarea name="content" id="content" placeholder="请一行一个链接...." class="form-control" style="height: 160px;"></textarea>
        </div>
        <div class="form-group">
            <select name="pid" lay-verify="required" style="display: none;width: 350px;height: 38px;border: 1px solid #dedede;">
                @if($config)
                    @foreach($config as $vo)
                        <option value="{{ $vo->pid }}">pid-{{ $vo->name.'-'.$vo->pid }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="content-secondary" style="text-align: center">
            <button type="button" class="btn btn-info" id="mkUrl">转换文本链接</button>
        </div>

        <div class="form-group" style="margin-top: 20px;text-align: center">
            <textarea id="self_text" class="form-control" style="height: 180px;"></textarea>
            <br>
            <button type="button" class="btn btn-success click_copy" style="float: right;">复制</button>
        </div>
    </div>
</div>




<script src="http://cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
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


</body>
</html>
