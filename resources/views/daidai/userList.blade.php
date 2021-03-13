@include('daidai.public.header')


@include('daidai.public.menu')


<div class="layui-body">
    <!-- 内容主体区域 -->
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend style="color: #009688">用户列表</legend>
    </fieldset>

    <table lay-filter="demo" class="layui-table">
        <thead>
        <tr>
            <th>序号</th>
            <th>用户名</th>
            <th>状态</th>
            <th>创建时间</th>
            <th>最后登录时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($data) && $data)
        @foreach($data as $k => $vo)
            <tr>
                <td>{{ $k+1}}</td>
                <td>{{ $vo->username }}</td>
                <td>{{ $vo->status == 1 ? '正常' : '异常' }}</td>
                <td>{{ $vo->created_at }}</td>
                <td>{{ $vo->updated_at ?: '--' }}</td>
                <td><a class="layui-btn layui-btn-danger layui-btn-xs a-del" data-id={{ $vo->id }} lay-event="del">删除</a></td>
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>
</div>

@include('daidai.public.footer')

<script>
layui.use('table', function(){
  $('a.a-del').click(function(e){
        layer.confirm('确定删除该用户？', function(index){
            var id = $(e).attr('data-id');
            $.post('/dd/del-user', {id:id}, function(result){
                if(!result.status){
                    layer.msg(result.info)
                }
            })
            layer.close(index);
      });
  });
});
</script>

