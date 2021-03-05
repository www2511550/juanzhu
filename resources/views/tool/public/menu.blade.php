<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
        <ul class="layui-nav layui-nav-tree" lay-filter="test">
            <li class="layui-nav-item">
                <a href="/tool/personal"><i class="layui-icon layui-icon-home"></i> 个人中心</a>
            </li>
            <li class="layui-nav-item layui-nav-itemed">
                <a class="" href="javascript:;"><i class="layui-icon layui-icon-app"></i> 淘宝客工具箱</a>
                <dl class="layui-nav-child">
                    <dd @if($a == 'weibo-to-taobao') class="layui-this" @endif><a href="/wb">微博跳淘宝<img
                                    src="/hot.gif"></a></dd>
                    <dd @if($a == 'weibo-to-pinduoduo') class="layui-this" @endif><a href="/tool/weibo-to-pinduoduo">微博跳拼多多<img
                                    src="/new.gif"></a></dd>
                    <dd @if($a == 'weibo-to-jd') class="layui-this" @endif><a href="/tool/weibo-to-jd">微博跳京东<img
                                    src="/new.gif"></a></dd>
                    <dd @if($a == 'short-url') class="layui-this" @endif><a href="/tool/short-url">淘宝短链接</a></dd>
                    <dd @if($a == 'to-self-url') class="layui-this" @endif><a href="/tool/to-self-url">他人链接转换</a></dd>
                    <dd @if($a == 'tkl-decrypt') class="layui-this" @endif><a href="/tool/tkl-decrypt">淘口令解密</a></dd>
                    <dd @if($a == 'tkl-create') class="layui-this" @endif><a href="/tool/tkl-create">淘口令生成</a></dd>
                    <dd @if($a == 'tbk-order') class="layui-this" @endif><a href="/tool/tbk-order">淘宝订单查询</a></dd>
                    <dd @if($a == 'high-rate') class="layui-this" @endif><a href="/tool/high-rate">单品券高效转链(高佣API)</a></dd>
                </dl>
            </li>
        </ul>
    </div>
    <style>
        dl.layui-nav-child > dd > a > img {
            position: absolute;
            top: 2px;
        }
    </style>
</div>