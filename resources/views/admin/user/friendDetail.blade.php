@include('admin.index.public.header')


<body>
<form method="post" action="">
    <div class="panel admin-panel">
        <div class="panel-head"><strong class="icon-reorder">邀请明细</strong></div>

        <table class="table table-hover text-center">
            <tr>
                {{--<th width="120">ID</th>--}}
                <th>新用户</th>
                <th>邀请人</th>
                <th>邀请时间</th>
                <th>注册方式</th>
                <th>注册时间</th>
                <th>状态</th>
            </tr>

            @if($data)
                @foreach($data as $val)
                    <tr>
                        {{--<td>{{$val['id']}}</td>--}}
                        <td>{{$val['new_user']}}</td>
                        <td>{{$val['user']}}</td>
                        <td>{{$val['yaoqing_time']}}</td>
                        <td>{{$val['register_type']}}</td>
                        <td>{{$val['register_time']}}</td>
                        <td @if(1!=$val['intStatus'])style="color:red;" @endif>{{$val['status']}}</td>
                    </tr>
                @endforeach
            @endif

        </table>
    </div>

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