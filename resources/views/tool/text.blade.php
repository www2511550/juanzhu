<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>批量转口令</title>
    {{--<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap40.min.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap337.min.js') }}"></script>
    {{--<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>--}}
    <script src="{{ asset('js/clipboard.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('layui/layui.js') }}"></script>
</head>
<body>


{{--<div class="btn-group" role="group" style="width: 100%">--}}
    {{--<button type="button" class="btn {{ $action=='oneLink' ? 'btn-primary' : 'btn-default' }}" onclick="window.location='/dd/one-link'" style="width: 33.3%">单链接转换</button>--}}
    {{--<button type="button" class="btn {{ $action=='moreLink' ? 'btn-primary' : 'btn-default' }}" onclick="window.location='/dd/more-link'" style="width: 33.3%">批量转链接</button>--}}
    {{--<button type="button" class="btn {{ $action=='weibo' ? 'btn-primary' : 'btn-default' }}" onclick="window.location='/dd/weibo-to-taobao'" style="width: 33.3%">微博跳淘宝</button>--}}
{{--</div>--}}

<div class="container" style="margin-bottom: 10px;">
    <div class="page-header">
        <h3 style="margin: 20px 0;text-align: center">批量转口令</h3>
    </div>


    <div class="content-main">
        <div class="form-group">
            <textarea name="content" id="content" placeholder="请输入带口令的文本" class="form-control" style="height: 180px;"></textarea>
        </div>

        <div class="content-secondary" style="text-align: center">
            <button type="button" class="btn btn-info" id="mkUrl">转换口令</button>
            <span class="loading-word" style="color: red;margin-left: 30px;display: none">  ...口令转换中...</span>
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
        var content = $('#content').val();
        if (!content) {
            layui.use('layer', function(){
              layui.layer.msg('请输入需要转换的文本内容');
            })
            return false;
        }
        $('.loading-word').show();
        $('#self_text').val('');
        $.post('/tool/text', {content: content}, function (data) {
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
