@include('admin.index.public.header')


<body>
<form method="post" action="">
    <div class="panel admin-panel">
        <div class="panel-head"><strong class="icon-reorder"> 评论管理</strong></div>
        <div class="padding border-bottom">
            <ul class="search">
                <li>
                    <button type="button"  class="button border-green" id="checkall"><span class="icon-check"></span> 全选</button>
                    <button type="submit" class="button border-red"><span class="icon-trash-o"></span> 批量删除</button>
                </li>
            </ul>
        </div>
        <table class="table table-hover text-center">
            <tr>
                <th width="120">ID</th>
                <th>用户名</th>
                <th width="25%">内容</th>
                <th width="120">留言时间</th>
                <th>操作</th>
            </tr>

        @if($data)
            @foreach($data as $val)
                <tr>
                    <td><input type="checkbox" name="id[]" value="{{$val['id']}}" />{{$val['id']}}</td>
                    <td>{{$val['username']}}</td>
                    <td>{{$val['content']}}</td>
                    <td>{{$val['addtime']}}</td>
                    <td>
                        <div class="button-group">
                            <a class="button border-main" href="javascript:void(0)" onclick="return edit({{$val['id']}},{{ 1 == $val['status'] ? 2 : 1 }})"><span class="icon-edit"></span> 加入黑名单</a>
                            <a class="button border-red" href="javascript:void(0)" onclick="return del({{$val['id']}})"><span class="icon-trash-o"></span> 删除</a>
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

    function del(id){
        if(confirm("您确定要删除吗?")){
            $.post('/admin/news/delComment', {id:id}, function (data) {
                if( 0 == data.status){
                    alert(data.msg);
                }else{
                    location.reload();
                }
            }, 'json');
        }
    }
    
    function edit(id, state) {
        if(confirm("加入黑名单?")){
            $.post('/admin/news/delComment', {id:id}, function (data) {
                if( 0 == data.status){
                    alert(data.msg);
                }else{
                    location.reload();
                }
            }, 'json');
        }
    }

    $("#checkall").click(function(){
        $("input[name='id[]']").each(function(){
            if (this.checked) {
                this.checked = false;
            }
            else {
                this.checked = true;
            }
        });
    })

    function DelSelect(){
        var Checkbox=false;
        $("input[name='id[]']").each(function(){
            if (this.checked==true) {
                Checkbox=true;
            }
        });
        if (Checkbox){
            var t=confirm("您确认要删除选中的内容吗？");
            if (t==false) return false;
        }
        else{
            alert("请选择您要删除的内容!");
            return false;
        }
    }

</script>
</body></html>