@include('admin.index.public.header')


<body>
<form method="post" action="">
    <div class="panel admin-panel">
        <div class="panel-head"><strong class="icon-reorder"> 用户列表</strong></div>

        <table class="table table-hover text-center">
            <tr>
                {{--<th width="120">ID</th>--}}
                <th>邀请人</th>
                <th>已邀请人数</th>
                <th>注册方式</th>
                <th>注册时间</th>
                <th>操作</th>
            </tr>

            @if($data)
                @foreach($data as $val)
                    <tr>
                        <td>{{$val['username']}}</td>
                        <td><a href="/admin/user/friendDetail?user_id={{$val['id']}}" style="color: #00aaee">{{$val['num']}}</a></td>
                        <td>{{$val['register_type']}}</td>
                        <td>{{$val['time']}}</td>
                        <td>
                            @if(1==$val['reward'])
                                已充值
                            @else
                                <a href="javascript:;" onclick="addReward({{$val['id']}})" style="color: #00aaee">充值话费</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif

        </table>
    </div>
    {{ $page }}
</form>
<script type="text/javascript">

    function addReward(user_id){
        if(confirm('请确定此用户话费已充值？')){
            $.post('/admin/user/addReward', {user_id:user_id}, function (data) {
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