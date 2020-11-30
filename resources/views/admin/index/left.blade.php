<div class="leftnav">
    <div class="leftnav-title"><strong><span class="icon-list"></span>菜单列表</strong></div>
    <h2><span class="icon-user"></span>基本设置</h2>
    <ul style="display:block">
        {{--<li><a href="/admin/index/info" target="right" class="on"><span class="icon-caret-right"></span>网站设置</a></li>--}}
        <li><a href="/admin/index/appBanner" target="right"><span class="icon-caret-right"></span>首页轮播</a></li>
        <li><a href="/admin/news/commentList" target="right"><span class="icon-caret-right"></span>评论管理</a></li>
        <li><a href="/admin/index/hotWord" target="right"><span class="icon-caret-right"></span>热词管理</a></li>
        <li><a href="/admin/user/editPass?id={{$_COOKIE['uid']}}" target="right"><span class="icon-caret-right"></span>修改密码</a></li>
        {{--<li><a href="/admin/index/page" target="right"><span class="icon-caret-right"></span>单页管理</a></li>--}}
    </ul>

    <h2><span class="icon-pencil-square-o"></span>订单管理</h2>
    <ul>
        <li><a href="/admin/import/tbInto" target="right"><span class="icon-caret-right"></span>订单导入</a></li>
        <li><a href="/admin/import/tbOrder" target="right"><span class="icon-caret-right"></span>订单列表</a></li>
    </ul>

    <h2><span class="icon-pencil-square-o"></span>用户管理</h2>
    <ul>
        <li><a href="/admin/user/lists" target="right"><span class="icon-caret-right"></span>用户列表</a></li>
        <li><a href="/admin/user/friendList" target="right"><span class="icon-caret-right"></span>邀请列表</a></li>
        <li><a href="/admin/user/signList" target="right"><span class="icon-caret-right"></span>签到奖励</a></li>
    </ul>

    <h2><span class="icon-pencil-square-o"></span>优券头条</h2>
    <ul>
        <li><a href="/admin/news/index" target="right"><span class="icon-caret-right"></span>优券头条列表</a></li>
        <li><a href="/admin/news/addNews" target="right"><span class="icon-caret-right"></span>添加头条</a></li>
    </ul>


    <h2><span class="icon-pencil-square-o"></span>管理员</h2>
    <ul>
        <li><a href="/admin/user/userList" target="right"><span class="icon-caret-right"></span>管理员列表</a></li>
        <li><a href="/admin/user/addUser" target="right"><span class="icon-caret-right"></span>添加管理员</a></li>
    </ul>
</div>