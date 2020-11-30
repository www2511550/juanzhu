
@include('home.wap.header')
<style>
    .order_info{
        position: fixed;top: 0;bottom: 0;left: 0;right: 0;background: #000000;opacity: 0.6;display: none;
    }
    .o_info{
        width: 85%;height: auto;background: #fff;position: fixed;top: 10%;left: 5%;padding: 20px 0 20px 5%;border-radius: 5px;display: none;
    }
    .o_info>p{
        line-height:25px;text-align: left;font-size: 14px;
    }
    .o_info>p>span{
        font-size: 14px;font-weight: 700;
    }
    .o_info>p>input{
        border: 1px solid #dedede;width: 95%;height: 30px;color: #ff3366;
    }
    .ipt-sbt{
        background: #f40;border: 1px solid #f40;width: 100px;height: 30px;color: #fff;border-radius: 1px;margin-top: 30px;float: right;margin-right: 30px;
    }
    .p_error{
        color: red;font-size: 12px;float: right;margin-right: 10px;
    }
</style>
<body style="background:#EDECEA" onload='cc._init()'>

<!-- 中间商品展示区块 -->
<div class="body_out">
    <div class="bd_top">
        <div class="text">
            <span style="padding-top: 3px;line-height: 50px;font-size: 24px;color: #ff3366">卷猪积分商城</span>
            <span class="index" style="padding-top: 3px;line-height: 50px;float: right;font-size: 18px;">我的积分:<a href="/home/center" style="color: red;font-size: 20px;" class="b_score" total_score="{{ intval($score) }}">{{ intval($score) }}分</a></span>
        </div>
    </div>

    @if( $data )
        <div class="body">
            <!-- body商品区块 -->
            <div class="bd_right">
                @foreach( $data as $vo )

                    <div class="one_out">
                        <b class="is_new"></b>
                        <a href="javascript:;" class="is_quan"><span>积分<br/>换购</span></a>
                        <div class="one_img" style="overflow:hidden">
                            <a href="javascript:;">
                                <img class="lazy" src="{{ $vo->pic_url.'_320x320.jpg' }}"  alt="{{ $vo->title }}" style="height:170px;" />
                            </a>
                        </div>
                        <p class="title">
                            <a href="javascript:;">{{ $vo->title }}</a>
                        </p>
                        <div class="price">
                            <p class="new_price">
                                <span>{{ $vo->score }}</span><b>积分</b>
                            </p>
                            <p class="old_price">
                            </p>
                            <a href="javascript:;" class="buy" onclick="showOrder(this)" uid="{{ intval($_GET['uid']) }}" gid="{{ $vo->gid }}" g_score="{{ $vo->score }}" g_title="{{ $vo->title }}">兑换</a>
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

        <div class="order_info"></div>
        <div class="o_info">
            <p><span>商品标题:</span><b class="o_title" style="display: block;color: #ff3366"></b></p>
            <p><span>所需积分: </span><b class="o_score" style="color: #ff3366;font-size: 14px;"></b></p>
            <p><span>商品备注:</span><input type="text" name="note"  placeholder="如颜色,款式,xl"></p>
            <p><span>收货地址:</span><input type="text" name="address" class="address" placeholder="地址填写到门牌号!"></p>
            <p><span>联系电话:</span><input type="text" name="tel" class="tel" placeholder="请输入联系方式!"></p>
            <p><span>收货人:</span><input type="text" name="name" class="name" placeholder="如:曾小贤"></p>
            <p class="p_error"></p>
            <input type="button" value="提交订单" class="ipt-sbt" onclick="addScoreOrder()">
        </div>

</div>
<!-- 中间商品展示区块结束 -->

<!-- 底部区块 -->
<div class="bottom_out">

</div>
<!-- 底部区块结束 -->

<a href="javascript:scroll(0,0);" class="toTop"><img src="/images/top.png" width="33" height="33" /></a>
</body>
<script type="text/javascript">
    $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    function showOrder(obj) {
        var strScore = $(obj).attr('g_score')+'分';
        $('.o_title').text($(obj).attr('g_title'));
        $('.o_score').text(strScore);
        $('.order_info').show();
        $('.o_info').show();
    }
    $('.order_info').click(function () {
        $(this).hide();
        $('.o_info').hide();
    })
    function addScoreOrder() {
        var address = $(".address").val();
        var tel = $(".tel").val();
        var name = $(".name").val();
        var score = $('.buy').attr('g_score');
        var gid = $('.buy').attr('gid');
        var uid = $('.buy').attr('uid');
        var total_score  = $('.b_score').attr('total_score');
//        if(score>total_score){
//            $('.p_error').text('积分不足,可以通过分享赚获取哦!');
//            return false;
//        }
        if(!address){
            $('.p_error').text('请填写正确的地址!');
            return false;
        }
        if(!tel){
            $('.p_error').text('请填写正确的电话号码!');
            return false;
        }
        if(!name){
            $('.p_error').text('请填写正确的收货人!');
            return false;
        }
        $.post('/home/wap/addScoreOrder',{gid:gid,address:address,tel:tel,score:score,name:name,uid:uid},function (data) {
                if(data.status == 0){
                    $('.p_error').text(data.msg);
                }else{
                    alert(data.msg);
                    $('.order_info').hide();
                    $('.o_info').hide();
                }
        },'json');
    }
    !function(e) {
        cc = {
            num : 0,
            _init : function() {
                this.topFix();
                this.scrolls();
            },
            topFix : function() {
                e(window).scroll(function() {
                    if ( e(document).scrollTop()>40 ) {
                        e('.main_menu').addClass('main_menu_fix');
                    }else{
                        e('.main_menu').removeClass('main_menu_fix');
                    }
                })
            },
            scrolls : function() {   //  无限追加
                var page = 1;
                var uid = $('.buy').attr('uid');
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
                        e.post("/home/wap/shop",{page:page,uid:uid,isAjax:1},function(str) {
                            e('.bd_right').append(str);
                        },'JSON');
                    };

                })
            },
        }
    }(window.jQuery);
</script>
</html>