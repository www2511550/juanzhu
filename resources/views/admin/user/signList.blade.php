@include('admin.index.public.header')


<body>
<form method="post" action="">
    <div class="panel admin-panel">
        <div class="panel-head"><strong class="icon-reorder">签到奖励</strong></div>

        <table class="table table-hover text-center">
            <tr>
                {{--<th width="120">ID</th>--}}
                <th>会员名</th>
                <th>注册方式</th>
                <th>注册时间</th>
                <th>操作</th>
            </tr>

            @if($data)
                @foreach($data as $val)
                    <tr>
                        <td>{{$val['username']}}</td>
                        <td>{{$val['register_type']}}</td>
                        <td>{{$val['time']}}</td>
                        <td>
                            @if(1==$val['reward'])
                                已发放奖励红包
                            @else
                                <a href="javascript:;" onclick="editSignReward({{$val['id']}})" style="color: #00aaee">发放签到奖励</a>
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

    function editSignReward(user_id){
        if(confirm('请确定此用户已发放签到红包？')){
            $.post('/admin/user/signList', {user_id:user_id,is_edit:1}, function (data) {
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