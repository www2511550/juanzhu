<div class="nav_box">
    <nav class="nav" id="nav">
        <ul class="">
            <li><a @if(!$_GET['mid'] && !$action) class="active" @endif  href="/" target="_self"><em class="icon icon-jz"></em><span>首页</span><em
                            class="line"></em></a></li>
            <li><a @if($_GET['mid'] == 9.9 ) class="active" @endif href="/home/wap/index?mid=9.9" target="_self"><em
                            class="icon icon-jk"></em><span>9.9包邮</span><em class="line"></em></a></li>
            <li><a @if($_GET['mid'] == 19.9 ) class="active" @endif  href="/home/wap/index?mid=19.9" target="_self"><em class="icon icon-sjk"></em><span>19.9包邮</span><em
                            class="line"></em></a></li>
            <li><a @if($action == 'reward' ) class="active" @endif href="/home/wap/reward" target="_self"><em
                            class="icon icon-bz"></em><span>抽奖王</span><em class="line"></em></a></li>
            <li class="_border" style="border-right: none"><a @if($action == 'center' ) class="active" @endif href="/home/center" target="_self"><em
                            class="icon icon-yg"></em><span>会员中心</span><em class="line"></em></a></li>
        </ul>
    </nav>
</div>