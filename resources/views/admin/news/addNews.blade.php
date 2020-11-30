@include('admin.index.public.header')

<link href="{{ asset('umeditor/themes/default/css/umeditor.css') }}" type="text/css" rel="stylesheet">
<script type="text/javascript" src="{{ asset('umeditor/third-party/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('umeditor/third-party/template.min.js') }}"></script>
<script type="text/javascript" charset="utf-8" src="{{ asset('umeditor/umeditor.config.js') }}"></script>
<script type="text/javascript" charset="utf-8" src="{{ asset('umeditor/umeditor.min.js') }}"></script>

<body>
<div class="panel admin-panel">
    <div class="panel-head"><strong><span class="icon-pencil-square-o"></span>添加优券头条</strong></div>
    <div class="body-content">
        <form method="post" class="form-x" action="" enctype="multipart/form-data">
            <div class="form-group">
                <div class="label">
                    <label>标题：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" name="title" value="" />
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>副标题：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" name="intro" value="" />
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>封面图：</label>
                </div>
                <div class="field">
                    <input type="text" id="url1" name="cover" class="input tips" style="width:25%; float:left;" value="" data-toggle="hover" data-place="right" data-image=""  />
                    <input type="file" class="button bg-blue margin-left" id="image1" name="cover" value="+ 浏览上传"  style="float:left;">
                    <div class="tipss">app图片尺寸：350x350</div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>是否置顶：</label>
                </div>
                <div class="field">
                    <div class="button-group radio">

                        <label class="button active">
                            <span class="icon icon-check"></span>
                            <input name="is_top" value="1" type="radio">是
                        </label>

                        <label class="button"><span class="icon icon-times"></span>
                            <input name="is_top" value="0"  type="radio" checked="checked">否
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>内容：</label>
                </div>
                <div class="field">
                    <!--style给定宽度可以影响编辑器的最终宽度-->
                    <script type="text/plain" id="myEditor" style="width:60%;height:1000px;" name="content"></script>
                    {{--<textarea name="content"></textarea>--}}
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
<script type="text/javascript">
    //实例化编辑器
    var um = UM.getEditor('myEditor');
</script>
</body>
</html>