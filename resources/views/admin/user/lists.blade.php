@include('admin.index.public.header')


<body>
<form method="post" action="">
    <div class="panel admin-panel">
        <div class="panel-head"><strong class="icon-reorder"> 用户列表</strong></div>

        <table class="table table-hover text-center">
            <tr>
                <th width="120">ID</th>
                <th>用户名</th>
                <th>手机号</th>
                <th>注册方式</th>
                <th>身份</th>
                <th>pid</th>
                <th>注册时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr>

            @if($data)
                @foreach($data as $val)
                    <tr>
                        <td>{{$val['id']}}</td>
                        <td>{{$val['username']}}</td>
                        <td>{{$val['tel']}}</td>
                        <td>{{$type[$val['type']] ?: ''}}</td>
                        <td>{{$val['user_role']}}</td>
                        <td>{{$val['pid']}}</td>
                        <td>{{$val['time']}}</td>
                        <td @if(1!=$val['status'])style="color: red"@endif>{{$arrStatus[$val['status']]}}</td>
                        <td>
                            <div class="button-group">
                                <a class="button border-main" href="javascript:void(0)" onclick="return del({{$val['id']}}, 1)"><span class="icon-edit"></span> 恢复账号</a>
                                <a class="button border-red" href="javascript:void(0)" onclick="return del({{$val['id']}}, 2)"><span class="icon-trash-o"></span> 删除</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif

        </table>
    </div>
    {{ $page }}
</form>
<script type="text/javascript">

    function del(id, status){
        var word = 2==status ? '您确定要删除吗?' : '您确定恢复此账号？';
        if(confirm(word)){
            $.post('/admin/user/delUser', {id:id,status:status}, function (data) {
                if( 0 == data.status){
                    alert(data.msg);
                }else{
                    location.reload();
                }
            }, 'json');
        }
    }

</script>
</body></html>