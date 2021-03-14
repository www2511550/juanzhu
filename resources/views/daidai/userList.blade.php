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
                <td><a class="layui-btn layui-btn-danger layui-btn-xs a-del" onclick="delUser({{$vo->id}})">删除</a></td>
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>
</div>

@include('daidai.public.footer')

<script>


function delUser(uid){
    if(confirm('确定删除该用户吗？')){
        $.post('/dd/del-user', {id:uid}, function(result){
            if(!result.status){
                alert(result.info);
            }else{
                layui.use('layer', function(){
                  var layer = layui.layer;
                  layer.msg('删除成功！');
                });
            }
        })

    }
}
</script>

