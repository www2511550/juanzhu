
@include('admin.index.public.header')

<body>
<div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 内容列表</strong></div>
    <div class="padding border-bottom">
        <a class="button border-yellow" href=""><span class="icon-plus-square-o"></span> 添加热词</a>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th width="15%">ID</th>
            <th>热词名称</th>
            <th>所属组</th>
            <th width="250">操作</th>
        </tr>

    @if($data)
        @foreach($data as $vo)
        <tr>
            <td>{{$vo->created_at}}</td>
            <td>{{$vo->name}}</td>
            <td>第{{$vo->type}}组</td>
            <td>
                <div class="button-group">
                    <a type="button" class="button border-main" href="/admin/index/hotWord?id={{$vo->id}}"><span class="icon-edit"></span>修改</a>
                    <a class="button border-red" href="javascript:void(0)" onclick="return del({{$vo->id}})"><span class="icon-trash-o"></span> 删除</a>
                </div>
            </td>
        </tr>
        @endforeach
    @endif


    </table>
</div>
{{ $page }}
<script>
    function del(id){
        if(confirm("您确定要删除吗?")){
            $.post('/admin/index/delHotWord',{id:id},function (data) {
                if(0==data.status){
                    alert(data.info);
                }else{
                    location.reload();
                }
            },'JSON');
        }
    }
</script>
<div class="panel admin-panel margin-top">
    <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>增加内容</strong></div>
    <div class="body-content">
        <form method="post" class="form-x" action="">
            <input type="hidden" name="id"  value="{{intval($hot->id)}}" />
            <div class="form-group">
                <div class="label">
                    <label>栏目名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="name" value="{{ $hot->name ?: '' }}" data-validate="required:请输入标题" />
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>所属组：</label>
                </div>
                <div class="field">
                    <select name="type" id="">
                        @for($i=1;$i<=3;$i++)
                        <option value="{{$i}}" @if($i==intval($hot->type)) selected="" @endif>第{{$i}}组</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label></label>
                </div>
                <div class="field">
                    <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>