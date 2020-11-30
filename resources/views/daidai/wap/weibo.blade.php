@include('daidai.wap.header')

<div class="container" style="margin-bottom: 10px;">
    <div class="page-header">
        <h3 style="margin: 20px 0;text-align: center">微博跳淘宝APP链接转换</h3>
    </div>


    <div class="content-main">
        <div class="form-group">
            <label for="exampleInputEmail1">淘宝链接：</label>
            <input type="text" id="longUrl" placeholder="例如：https://s.click.taobao.com/xxxxxx"
                   autocomplete="off" class="form-control">
        </div>

        <div class="content-secondary" style="text-align: center">
            <button type="button" class="btn btn-info" id="mkUrl">转换链接</button>
        </div>

        <div class="form-group" style="margin-top: 20px;text-align: left">
            <label for="">微博短链接</label>
            <input type="text" id="shortUrl" class="form-control">
            <br>
            <button type="button" class="btn btn-success click_copy" style="float: right;">复制</button>
        </div>
    </div>
</div>




<script src="http://cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
<script>
    $('#mkUrl').on('click', function (e) {
        var longUrl = $('#longUrl').val();
        if (!longUrl) {
            layui.use('layer', function(){
              layui.layer.msg('请输淘宝链接');
            })
            return false;
        }
        $('#shortUrl').val('');
        $.post('/url/short', {longUrl: longUrl}, function (data) {
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
                return $('#shortUrl').val();
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
