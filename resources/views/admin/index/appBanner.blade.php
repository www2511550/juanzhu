@include('admin.index.public.header')

<body>
<div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> banner</strong></div>
    <div class="padding border-bottom">
        <button type="button" class="button border-yellow" onclick="window.location.href='/admin/index/appBanner'"><span class="icon-plus-square-o"></span> 添加内容</button>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th width="10%">ID</th>
            <th width="20%">图片</th>
            <th width="10%">分类</th>
            <th width="13%">名称</th>
            <th width="20%">描述</th>
            <th width="7%">排序</th>
            <th width="15%">操作</th>
        </tr>
    @if( $data )
        @foreach( $data as $key=>$vo )
        <tr>
            <td>{{ ++$key }}</td>
            <td><img src="/{{ $vo->img_url }}" alt="" width="120" height="50" /></td>
            <td>{{ $cate[$vo->cid] }}</td>
            <td>{{ $vo->title }}</td>
            <td>{{ $vo->note }}</td>
            <td>{{ $vo->sort }}</td>
            <td><div class="button-group">
                    <a class="button border-main" href="?pid={{ $vo->id }}&k={{ $key-1 }}"><span class="icon-edit"></span> 修改</a>
                    <a class="button border-red" href="javascript:void(0)" onclick="return del({{ $vo->id }})"><span class="icon-trash-o"></span> 删除</a>
                </div></td>
        </tr>
        @endforeach
    @endif

    </table>
</div>
<script type="text/javascript">
    function del(pid){
        if(confirm("您确定要删除吗?")){
            $.post('/admin/index/delBanner', {pid:pid}, function (data) {
                if( 0 == data.status){
                    alert(data.msg);
                }else{
                    location.reload();
                }
            }, 'JSON');
        }
    }
</script>
<div class="panel admin-panel margin-top" id="add">
    <div class="panel-head"><strong><span class="icon-pencil-square-o"></span> 增加内容</strong></div>
    <div class="body-content">
        <form method="post" class="form-x" action="/admin/index/addBanner" enctype="multipart/form-data">
            <input type="hidden" name="pid" value="{{ intval($_GET['pid']) }}">
            <div class="form-group">
                <div class="label">
                    <label>标题：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" value="{{ $data[$_GET['k']] ? $data[$_GET['k']]->title : '' }}" name="title" data-validate="required:请输入标题" />
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>跳转URL：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="to_url" value="{{ $data[$_GET['k']] ? $data[$_GET['k']]->to_url : '' }}"  />
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>分类：</label>
                </div>
                <div class="field">
                    <select name="cid" id="" style="margin-top: 5px;padding: 5px;">
                    @if( $cate )
                        @foreach( $cate as $cid => $name )
                        <option value="{{ $cid }}" @if($cid == $data[$_GET['k']]['cid']) selected="" @endif>{{ $name }}</option>
                        @endforeach
                    @endif
                    </select>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>图片：</label>
                </div>
                <div class="field">
                    <input type="text" id="url1" name="pic" class="input tips" style="width:25%; float:left;"  value="{{ $data[$_GET['k']] ? $data[$_GET['k']]->img_url : '' }}" data-toggle="hover" data-place="right" data-image="/{{ $data[$_GET['k']] ? $data[$_GET['k']]->img_url : '' }}" />
                    <input type="file" class="button bg-blue margin-left" id="image1" name="pic" value="+ 浏览上传"  style="float:left;">
                    <div class="tipss">app图片尺寸：500*138</div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>描述：</label>
                </div>
                <div class="field">
                    <textarea type="text" class="input" name="note" style="height:120px;" value="">{{ $data[$_GET['k']] ? $data[$_GET['k']]->note : '' }}</textarea>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>排序：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="sort" value="{{ $data[$_GET['k']] ? $data[$_GET['k']]->sort : 0 }}"  data-validate="required:,number:排序必须为数字" />
                    <div class="tips"></div>
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
</body></html>