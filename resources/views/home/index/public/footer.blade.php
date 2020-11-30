<div class="footer">
    <div class="footer-top">
        <div class="wrapper">
            <div class="yl">
                <p style="padding-top: 8px;" class="head">友情链接:</p>
                <div class="yl-links">
                    <a href="http://www.juanzhuzhu.com/" target="_blank">卷猪折扣网</a>
                    <a href="http://www.juanzhuzhu.com" target="_blank">卷猪</a>
                </div>
            </div>

            <div class="logo-slogan">
                <div class="qr-code">
                    <a title="卷猪折扣网" href="http://www.juanzhuzhu.com/">
                        <img alt="卷猪折扣网" src="/images/gongzhonghao.jpg">
                    </a>
                </div>
                <div class="txt">
                    <div class="logo">卷猪折扣网</div>
                    <p class="s1">聪明的人，都会省钱</p>
                    <p class="s2">购物省钱神器</p>
                </div>
            </div>
        </div>
    </div>
    <div style="display:none">
        <form name="filterForm" action="/" method="get">
            <input type="text" name="page" value="1">
            <input type="text" name="sort" value="default">
            <input type="text" name="price" value="0">
            <input type="text" name="kw" value="{{ $_GET['kw'] }}">
            <input type="text" name="cid" value="{{ $cid }}">
            <input type="text" name="mid" value="{{ $mid }}">
            <input type="submit">
        </form>
    </div>
    <div class="footer-bootom">
        <div class="wrapper">
            <p>卷猪折扣网 <a href="http://www.miitbeian.gov.cn/" target="_blank">粤ICP备16100236号</a>　深圳市卷猪信息科技有限公司版权所有 Copyright @2017-{{date('Y')}} 卷猪优惠卷 juanzhuzhu.com All Rights Reserved</p>
        </div>
    </div>
</div>

<script type="text/javascript">
    function scroll() {
        var page = 1;
        var mid = $('#couponList').attr('mid');
        var kw = $('#couponList').attr('kw');
        var cid = $('#couponList').attr('cid');
        var sort = $('#couponList').attr('sort');
        var price = $('#couponList').attr('price');
        $(window).scroll(function() {
            // 获得内容总高度
            var main_height = $('.zk-item').height()*$('.zk-item').length;
            // 获得已经滚动上去的高度
            var scroll_height = $(document).scrollTop();
            // 获得可视区域高度
            var window_height = $(window).height();
            // 计算距离底部的距离
            var bottom = main_height/4-window_height-scroll_height;
//            document.title = bottom;
            if ( bottom<0 ) {
                ++page;
                $.get("/home/index/append",{page:page,mid:mid,kw:kw,cid:cid,sort:sort,price:price},function(str) {
                    $('#couponList').append(str);
                    $("img.lazy").stop().lazyload({});
                    if(!str){
                        $('.more').text('我是有底线的！');
                    }else{
                        $('.more').text('拼命加载中......');
                    }
                },'');
            };
        })
    }
    scroll();
    $(function () {
        $(document).on('scroll', function () {
            var _top = $(document).scrollTop();
            if (_top >= 400) {
                backToTop
                $('.cate-box .tab-area').show();
                $('.tab-area').addClass('fixed');
            } else {

                $('.tab-area').removeClass('fixed');
//                $('.cate-box  .tab-area').hide();
            }
        });
    });
    $(function () {
        $('.sort-type li').each(function () {
            $(this).bind('click', function () {
                $('input[name=sort]').val($(this).attr('data-sort'));
                if ($('.price-filter li').hasClass('active')) {
                    $('input[name=price]').val($('.price-filter').find('.active').attr('data-price'));
                }
                document.filterForm.submit();
            });
        });

        $('.price-filter li').each(function () {
            $(this).bind('click', function () {
                $('input[name=price]').val($(this).attr('data-price'));
                if ($('.sort-type li').hasClass('active')) {
                    $('input[name=sort]').val($('.sort-type').find('.active').attr('data-sort'));
                }
                document.filterForm.submit();
            });
        });

        $('#keyword').bind('input propertychange', function () {
            var ajaxUrl = "index.php/index/ajax_request/suggest.html",
                    keyword = $(this).val();
            $.getJSON(ajaxUrl, {keyword: keyword}, function (result) {
                if (result.code == 1) {
                    if (keyword) {
                        $('.suggest').addClass("dropdown");
                        $(".suggest").html(result.data);
                        $("#suggest ul li a").each(function () {
                            $(this).on('click', function () {
                                var q = $(this).attr('data-keyword');
                                $('#keyword').val(q);
                                $('.suggest').removeClass("dropdown");
                            });

                        });
                    }
                }
            })
        });

        $("body").on('click', function () {
            $('.dropdown-menu').remove();
        });

        $('.search-btn').on('click', function () {
            document.soForm.submit();
        })

        $(document).on('scroll', function () {
            var _top = $(document).scrollTop();
            if (_top >= 400) {
                $('#backToTop').show();
            } else {
                $('#backToTop').hide();
            }
        });

        $("#backToTop").click(function () {
            if ($('html').scrollTop()) {
                $('html').animate({scrollTop: 0}, 1000);
                return false;
            }
            $('body').animate({scrollTop: 0}, 1000);
            return false;
        });
    });
</script>
<script type="text/javascript" src="{{ asset('swipe.jquery.min.js') }}"></script>
<script type="text/javascript">
    $(function () {
        var sw = new Swiper('.banner-area', {
            autoplay: 3000,
            loop: true,
            pagination: '.swiper-pager'
        });
    });
</script>
<div style="margin-left: 590px;" class="side-fixed-menu">
    <div id="backToTop" class="menu-item" style="display:none">
        <i class=" cate-icon">&#xe76d;</i>
        <p>返回顶部</p>
    </div>
    <a target="_blank" href="">
        <div class="menu-item" id="toHis"><i class=" cate-icon" style="font-size:22px;">&#xe62d;</i><p>浏览记录</p></div>
    </a>
</div>
</div>
<div style="display:none">
    <script type="text/javascript">
        var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
        document.write(unescape("%3Cspan id='cnzz_stat_icon_5443025'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s19.cnzz.com/stat.php%3Fid%3D5443025%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));

        (function(win,doc){
            var s = doc.createElement("script"), h = doc.getElementsByTagName("head")[0];
            if (!win.alimamatk_show) {
                s.charset = "gbk";
                s.async = true;
                s.src = "https://alimama.alicdn.com/tkapi.js";
                h.insertBefore(s, h.firstChild);
            };
            var o = {
                pid: "mm_47800736_21362628_76426651",/*推广单元ID，用于区分不同的推广渠道*/
                appkey: "",/*通过TOP平台申请的appkey，设置后引导成交会关联appkey*/
                unid: "",/*自定义统计字段*/
                type: "click" /* click 组件的入口标志 （使用click组件必设）*/
            };
            win.alimamatk_onload = win.alimamatk_onload || [];
            win.alimamatk_onload.push(o);
        })(window,document);
    </script>
</div>

</body>
</html>