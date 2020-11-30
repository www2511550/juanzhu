@include('tool.public.header')


@include('tool.public.menu')


<div class="layui-body" style="min-width :900px;">
    <div style="padding: 15px;">

        <!-- 内容主体区域 -->

        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>链接修复</legend>
        </fieldset>

        <div class="layui-form layui-form-pane">
            <table class="layui-table">
                <thead>
                <tr>
                    <th width="80">ID</th>
                    <th width="80">会员ID</th>
                    <th width="200">他人链接</th>
                    <th>自己链接</th>
                </tr>
                </thead>
                <tbody>
                @if($data->total())
                    @foreach($data as $vo)
                        <tr>
                            <td>{{ $vo->id }}</td>
                            <td>{{ $vo->user_id }}</td>
                            <td><a href="{{ $vo->long_url }}" target="_blank">{{ $vo->long_url }}</a></td>
                            <td>
                                <div class="layui-input-inline self_url" style="width:50%; margin-right: 10px;">
                                    <input type="text" id="selfUrl" placeholder="请输入自己的淘客链接...."
                                           autocomplete="off" class="layui-input">
                                </div>
                                <button class="layui-btn" data-id="{{$vo->id}}" onclick="saveUrl(this)">保存</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
            {{ $data->links() }}
        </div>
        <!-- 内容主体结束 -->
    </div>
</div>

<script>

function saveUrl(obj){
    var selfUrl = $(obj).siblings('div.self_url').find('input#selfUrl').val();
    if(!selfUrl){
        layui.use('layer', function(){
          layui.layer.msg("请输入自己的链接再保存");
        })
        return false;
    }
    var id = $(obj).attr('data-id');
    if(!id){
        layui.use('layer', function(){
          layui.layer.msg("id不存在");
        })
        return false;
    }


    $.post('/tool/repair-url', {id:id,selfUrl: selfUrl}, function (data) {
        layui.use('layer', function(){
          layui.layer.msg(data.info);
        })
    }).error(function (err) {
        layui.use('layer', function(){
          layui.layer.msg('服务器错误，请联系管理员！');
        })
    });
}

</script>


@include('tool.public.footer')



