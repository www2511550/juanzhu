@include('admin.index.public.header')


<body>
<form method="post" action="">
    <div class="panel admin-panel">
        <div class="panel-head"><strong class="icon-reorder"> 用户列表</strong></div>

        <table class="table table-hover text-center">
            <tr>
                <th>成交时间</th>
                <th>订单编号</th>
                <th>商品名称</th>
                <th>付款金额</th>
                <th>状态</th>
                <th>会员名</th>
                <th>总佣金</th>
                <th>实际佣金</th>
                {{--<th>操作</th>--}}
            </tr>

            @if($data)
                @foreach($data as $val)
                    <tr>
                        <td>{{$val['g_time']}}</td>
                        <td>{{$val['order_num']}}</td>
                        <td>{{$val['title']}}</td>
                        <td>{{$val['price']}}</td>
                        <td @if(2==$val['intStatus']) style="color: red" @endif>{{$val['status']}}</td>
                        <td>{{$val['username']}}</td>
                        <td>{{$val['money']}}</td>
                        <td>{{$val['reward']}}</td>
                        {{--<td>--}}
                            {{--<div class="button-group">--}}
                                {{--<a class="button border-red" href="javascript:void(0)" onclick="return del({{$val['id']}}, 2)"><span class="icon-trash-o"></span> 删除</a>--}}
                            {{--</div>--}}
                        {{--</td>--}}
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
            $.post('/admin/user/', {id:id,status:status}, function (data) {
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