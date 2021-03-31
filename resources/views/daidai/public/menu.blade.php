<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
        <ul class="layui-nav layui-nav-tree" lay-filter="test">
            <li class="layui-nav-item layui-nav-itemed">
                <a class="" href="javascript:;"><i class="layui-icon layui-icon-app"></i> 勇猛特工工具箱</a>
                <dl class="layui-nav-child">
                    <dd><a href="/dd/one-link">单链接转换</a></dd>
                    <dd><a href="/dd/more-link">批量转链接</a></dd>
                    @if(isset($_COOKIE['daidai_pid']) && $_COOKIE['daidai_pid'] == 0)
                    <dd><a href="/dd/weibo-to-taobao">微博跳淘宝</a></dd>
                    <dd><a href="/dd/short-url">淘宝短链接</a></dd>
                    <dd><a href="/dd/tkl-create">淘口令生成</a></dd>
                    @endif
                </dl>
            </li>
            @if(isset($_COOKIE['daidai_pid']) && $_COOKIE['daidai_pid'] == 0)
            <li class="layui-nav-item layui-nav-itemed">
                <a href="javascript:;"><i class="layui-icon layui-icon-friends"></i> 用户管理<span class="layui-nav-more"></span></a>
                <dl class="layui-nav-child">
                    <dd><a href="/dd/user-list">用户列表</a></dd>
                    <dd><a href="/dd/add-user">用户添加</a></dd>
                </dl>
            </li>
            @endif
        </ul>
    </div>
</div>