@include('admin.index.public.header')

<body>
<form method="post" action="">
    <div class="panel admin-panel">
        <div class="panel-head"><strong class="icon-reorder">用户列表</strong></div>
        </div>
        <table class="table table-hover text-center">
            <tr>
                <th width="120">ID</th>
                <th>姓名</th>
                <th>身份</th>
                <th>账号状态</th>
                <th>最后登陆时间</th>
                <th>IP地址</th>
                <th>操作</th>
            </tr>

         @foreach( $data as $vo )
            <tr>
                <td><input type="checkbox" name="id[]" value="{{ $vo->id }}" /></td>
                <td>{{ $vo->username }}</td>
                <td>{{ $role[$vo->user_role] }}</td>
                <td>{{ $status[$vo->status] }}</td>
                <td>{{ $vo->lastLoginTime }}</td>
                <td>{{ $vo->ip}}</td>
                <td><div class="button-group">
                        <a class="button border-main" href="/admin/user/editPass?id={{ $vo->id }}"><span class="icon-edit"></span> 修改</a>
                        <a class="button border-red" href="javascript:void(0)" onclick="return del(1)"><span class="icon-trash-o"></span> 删除</a>
                    </div>
                </td>
            </tr>
          @endforeach
        </table>
    </div>
    {{ $page }}
</form>
<script type="text/javascript">

    function del(id){
        if(confirm("您确定要删除吗?")){

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