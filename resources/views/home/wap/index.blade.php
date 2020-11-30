
@include('home.wap.header')

<body style="background:#EDECEA" onload='cc._init()'>
<a href="{{$down_url}}" class="download"><img src="/images/go_down.jpg" alt="" style="width: 100%;height: 56px;position: relative;"></a>
<!-- 头部区块 -->
<div class="header_out" mid="{{ $_GET['mid'] }}" kw="{{ $_GET['kw'] }}">
    <!-- 头部搜索区块 -->
    <div class="top_out_rel" id="top">
        <div class="top_left">
            <p class="logo">&nbsp;&nbsp;<a href="/"><img src="/wap/imgs/wap_logo.png" style="margin-top: 5px;height: 22px;" alt="卷猪"></a></p>
        </div>
        <form action="">
            <div class="top_center">
                <input type="text" name="kw" class="s_txt" placeholder="{{ $_GET['kw'] ? $_GET['kw'] : 'T恤 ' }}" >
                <input type="submit" class="s_btn" value="">
            </div>
        </form>
        <!-- 菜单列表 -->
        <div class="top_right">
            <a href="javascript:;" onclick="cc.menu()"><img src="/wap/imgs/more.png" alt=""></a>
            <div class="menu">
                <ul>
                    <li><a href="/">今日上新</a></li>
                        @foreach( $cate as $val)
                            <li><a href="?mid={{$val['cid']}}">{{ $val['c_name'] }}</a></li>
                        @endforeach

                </ul>
            </div>
        </div>
    </div>
    <!--主推菜单-->
    <div style="width: 100%">
        <div class="main_menu" style="width: 1000px;">
            <a href="/" @if( !$_GET['mid']) class="cur" @endif >今日上新</a>
            @foreach( $cate as $val)
                <a href="?mid={{ $val['cid'] }}" @if( $_GET['mid'] == $val['cid']) class="cur" @endif >{{ $val['c_name'] }}</a>
            @endforeach
        </div>
    </div>

        <!-- 轮播图区块 -->
    @if( $banner )
        <div class="swiper-container banner_out">
            <ul class="swiper-wrapper banner2">
                @foreach($banner as $val)

                    <li class="swiper-slide" @if( !$key ) style="display:block" @endif >
                    <a href="{{$val['toUrl']}}">
                        <img src="{{$val['img_url']}}" alt="{{$val['title']}}" height="138" width="100%">
                    </a>
                    </li>

                @endforeach

            </ul>
            <ol class="banner_nums">
                <li class="current"></li>
                <li></li>
                <li></li>
            </ol>
        </div>

        <!--四大专区-->
        <div class="area_box">
            <a href="https://ju.taobao.com/m/jusp/o/chouchouchou/mtp.htm?pid=mm_47800736_21362628_72092261"><img src="/wap/imgs/hot_80x80.png" alt="淘宝热销"><span>支付抢免单</span></a>
            <a href="https://temai.m.taobao.com/cheap.htm?pid=mm_47800736_21362628_72092261"><img src="/wap/imgs/jiu_80x80.png" alt="九块九包邮"><span>九块九邮</span></a>
            <a href="?mid=6"><img src="/wap/imgs/eat_80x80.png" alt="吃货最爱"><span>吃货最爱</span></a>
            <a href="?mid=6666"><img src="/wap/imgs/good_80x80.png" alt="小编精选"><span>小编精选</span></a>
        </div>
    @endif

</div>
<!-- 头部区块结束 -->

<!-- 中间商品展示区块 -->
<div class="body_out">
    <div class="bd_top">
        <div class="text">
            <span class="index" style="padding-top: 3px;line-height: 21px;">独家优惠券直播<span style="color: #d43f3a">({{ $total }})</span></span>
        </div>
    </div>

    @if( $data[0] )
    <div class="body">
            <!-- body商品区块 -->
            <div class="bd_right">
                @foreach( $data as $vo )

                    <div class="one_out">
                        <b class="is_new"></b>
                        <a href="{{ $vo->getQuanUrl($vo) }}" class="is_quan"><span>内部券<br/>{{ $vo->Quan_price }}元</span><img src="/images/qulingquan.png" alt=""></a>
                        <div class="one_img" style="overflow:hidden">
                            <a href="{{ $vo->getQuanUrl($vo) }}">
                                <img class="lazy" src="{{ $vo->Pic }}{{ $vo->SellerID ? '_320x320.jpg' : '' }}"  alt="{{ $vo->Title }}" style="height:170px;" />
                                <!--<img class="lazy" data-original="{$vo.img_url}"  alt="{$vo.g_name}" style="height:160px;" />-->
                            </a>
                        </div>
                        <p class="title">
                            <a href="{{ $vo->getQuanUrl($vo) }}">{{ $vo->Title }}</a>
                        </p>
                        <div class="price">
                            <p class="new_price">
                                卷后<b>￥</b><span>{{ $vo->Price }}</span>
                            </p>
                            <p class="old_price">
                                {{--<span>￥{{ $vo->Org_Price }} </span>--}}
                            </p>
                            <a href="{{ $vo->getQuanUrl($vo) }}" class="buy">{{ $vo->Quan_price }}元卷</a>
                        </div>
                    </div>

                @endforeach
            </div>
            <!-- body商品区块结束 -->
    </div>
    @else
    <a href="javascript:history.go(-1);" style="position: absolute;left: 50%;top:40%;margin-left: -200px;font-size: 25px;color: #ff3366;line-height:35px;text-align: center;width: 400px">
        亲,暂无相关优惠卷额<br/>点我返回!</a>
    @endif

</div>
<!-- 中间商品展示区块结束 -->

<!-- 底部区块 -->
<div class="bottom_out">

</div>
<!-- 底部区块结束 -->
{{--<a href="{{$down_url}}" @if($_COOKIE['hongbao']) style="display: none;" @endif class="a_down"><img onclick="window.location.href='{{$down_url}}'" src="/images/hongbao.jpg" alt="" style="width:80%;margin-top: 10%;margin-left: 10%"><b class="b_close" onclick="closeHongBao()"></b></a>--}}

<a href="javascript:scroll(0,0);" class="toTop"><img src="/images/top.png" width="33" height="33" /></a>
</body>
<script type="text/javascript">
    function setCookie(c_name,value,expiredays)
    {
        var exdate=new Date()
        exdate.setDate(exdate.getDate()+expiredays)
        document.cookie=c_name+ "=" +escape(value)+
                ((expiredays==null) ? "" : "; expires="+exdate.toGMTString())
    }
    function closeHongBao() {
        $('a.a_down').hide();
        setCookie('hongbao', 1, 30);
    }
    $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    var mySwiper = new Swiper('.swiper-container',{
        loop: true,
        autoplay: 2000,
    });
    //$("img.lazy").lazyload({
    //	effect : "fadeIn"
    //});
    !function(e) {
        cc = {
            num : 0,
            _init : function() {
                this.topFix();
                this.photoChange();
                this.changeBytime();
                this.scrolls();
            },
            topFix : function() {
                e(window).scroll(function() {
                    if ( e(document).scrollTop()>100 ) {
                        e('.main_menu').addClass('main_menu_fix');
                    }else{
                        e('.main_menu').removeClass('main_menu_fix');
                    }
                })
            },
            photoChange : function() {    // 轮播图
                e('.banner_nums>li').click(function() {
                    var num = e(this).index();
                    e(this).addClass('current').siblings('li').removeClass('current');
                    e('.banner>li').eq(num).fadeIn(500).siblings('li').fadeOut(500);
                })
            },
            changeBytime : function() {  // 轮播图定时轮播
                timer = setInterval(function () {
                    e('.banner_nums>li').eq(cc.num).addClass('current').siblings('li').removeClass('current');
                    e('.banner>li').eq(cc.num).fadeIn(1500).siblings('li').fadeOut(1500);
                    cc.num++;
                    if (cc.num>2)cc.num=0;
                },3000)
            },
            menu : function() {
                e('.menu').toggle(500);
            },
            scrolls : function() {   //  无限追加
                var page = 1;
                var mid = $('.header_out').attr('mid');
                var kw = $('.header_out').attr('kw');
                $(window).scroll(function() {
                    // 获得内容总高度
                    var main_height = e('.one_out').height()*e('.one_out').length;
                    // 获得已经滚动上去的高度
                    var scroll_height = e(document).scrollTop();
                    // 获得可视区域高度
                    var window_height = e(window).height();
                    // 计算距离底部的距离
                    var bottom = main_height/2-window_height-scroll_height;
                    // document.title = bottom;
                    if ( bottom<0 ) {
                        ++page;
                        e.post("/home/wap/append",{page:page,mid:mid,kw:kw},function(str) {
                            e('.bd_right').append(str);
//						$("img.lazy").stop().lazyload({});
                        },'JSON');
                    };

                })
            },
        }
    }(window.jQuery);
</script>
</html>