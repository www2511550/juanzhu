@include('admin.index.public.header')


<body style="background-color:#f2f9fd;">
<div class="header bg-main">
    <div class="logo margin-big-left fadein-top">
        <h1><img src="images/y.jpg" class="radius-circle rotate-hover" height="50" alt=""/>后台管理中心</h1>
    </div>
    <div class="head-l">
         <a href="##" class="button button-little bg-blue">
             <span class="icon-wrench"></span> 清除缓存
         </a> &nbsp;&nbsp;
        <a class="button button-little bg-red"  href="/admin/out">
            <span class="icon-power-off"></span> 退出登录
        </a>
    </div>
</div>


@include('admin.index.left')

<script type="text/javascript">
    $(function () {
        $(".leftnav h2").click(function () {
            $(this).next().slideToggle(200);
            $(this).toggleClass("on");
        })
        $(".leftnav ul li a").click(function () {
            $("#a_leader_txt").text($(this).text());
            $(".leftnav ul li a").removeClass("on");
            $(this).addClass("on");
        })
    });
</script>
<ul class="bread">
    <li><a href="/admin/index/appBanner" target="right" class="icon-home"> 首页</a></li>
    <li><a href="##" id="a_leader_txt">网站信息</a></li>
    <li><b>当前语言：</b><span style="color:red;">中文</span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;切换语言：<a href="##">中文</a> &nbsp;&nbsp;<a href="##">英文</a></li>
</ul>
<div class="admin">
    <iframe scrolling="auto" rameborder="0" src="/admin/index/appBanner" name="right" width="100%" height="100%" id="iframe_id"></iframe>
</div>
<div style="text-align:center;">
    <p>来源:<a href="" target="_blank"></a></p>
</div>
</body>
</html>