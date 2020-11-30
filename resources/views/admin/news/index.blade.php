@include('admin.index.public.header')


<body>
<form method="post" action="">
    <div class="panel admin-panel">
        <div class="panel-head"><strong class="icon-reorder"> 优券头条</strong></div>
        <table class="table table-hover text-center">
            <tr>
                <th width="120">ID</th>
                <th width="25%">标题</th>
                <th>封面图</th>
                <th>评论数</th>
                <th>浏览人数</th>
                <th>是否置顶</th>
                <th>更新时间</th>
                <th>操作</th>
            </tr>
    @if(count($data))
        @foreach($data as $vo)
            <tr>
                <td><input type="checkbox" name="id[]" value="{{ $vo->id }}" />{{ $vo->id }}</td>
                <td>{{ $vo->title }}</td>
                <td><img src="{{ $vo->cover }}" alt="" width="70" height="70"></td>
                <td>{{ $vo->comment_num }}</td>
                <td>{{ $vo->browse_num }}</td>
                <td>{{ $vo->is_top ? '是' : '否'}}</td>
                <td>{{ strtotime($vo->updated_at) ? $vo->updated_at : $vo->created_at }}</td>
                <td>
                    <div class="button-group">
                        <a class="button border-main" href="/admin/news/editNews?id={{ $vo->id }}"><span class="icon-edit"></span> 修改</a>
                        <a class="button border-red" href="javascript:void(0)" onclick="return del({{ $vo->id }})"><span class="icon-trash-o"></span> 删除</a>
                    </div>
                </td>
            </tr>
         @endforeach
    @endif
        </table>
    </div>
    {{ $data->appends($_GET)->render() }}
</form>
<script type="text/javascript">

    function del(id){
        if(confirm("您确定要删除吗?")){
            $.post('/admin/news/delNews',{id:id},function(data){
                if(0==data.status){
                    alert(data.info);
                }else{
                    location.reload();
                }
            },'JSON')
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