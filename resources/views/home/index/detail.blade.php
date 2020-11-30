@include('home.index.public.header')

<div class="wrapper zk-detail">
    <div class="wrapper-l zk-main">
        <p class="bread-area">
            您的位置：<a href="/">卷猪优惠券</a> &nbsp;&gt;&nbsp;<a href="?cid={{ $info['cid'] }}">{{ $info->cate ?:'详情' }}</a></span>&nbsp;&gt;&nbsp;{{$info['Title']}} </p>
        <div class="zk-content">
            <div class="img-area">
                <img src="{{$info['Pic']}}" alt="{{$info['Title']}}">
            </div>
            <div class="info-area">
                <h1 class="title elli"> <span>包邮</span>{{$info['Title']}}</h1>
                <p class="endtime" id="eventTimeStr">优惠券即将失效:<em></em>天<em></em>时<em></em>分<em></em>秒</p>
                <input id="endTime" value="1505145599" type="hidden">
                <div class="platform">
                    <i style="background-image: url(/images/platform_tmall.png);"></i> 天猫
                </div>
                <div class="stat">
                    <p class="price-area">
                        <span class="ori-price">现价：¥{{ $info['Org_Price'] }}</span>
                        <span class="price"><i>券后价</i><em class="decimal">¥</em><em class="int">{{ $info['Price'] }}</em></span>
                    </p>
                    <div class="buy-area">
                        <p class="desc">有效期内领券下单，享受立减优惠！</p>
                        <a href="{{ $info->getQuanUrl($info) }}" target="_blank" rel="nofollow" class="buy-btn">
                            <div class="line line-l"><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div>
                            <div class="line line-r"><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div>
                            领券立减<em>{{ $info['Quan_price'] }}</em>元
                        </a>
                    </div>
                </div>

                <div class="tags">

                    小编点评：{{$info['Introduce']}}
                    {{--<div class="tag-list">--}}
                        {{--<a  class="tag-item" href="/index.php/index/so/index/wd/%E9%98%B2%E8%A3%82.html">防裂</a>--}}
                    {{--</div>--}}
                    {{--<p class="coll"><i></i>按<em>Ctrl&nbsp;+&nbsp;D</em>加入收藏</p>--}}
                </div>
            </div>
        </div>
    </div>

    @if($history)
    <div class="wrapper-r">
        <div class="rel-zk-area" style="margin-top: 60px;">
            <p class="head">
                <span>最近浏览</span>
                <a  href="" class="more-his">查看更多
                </a>
            </p>
            <div class="hot-zk-list clearfix swiper-container swiper-container-horizontal">

                <div style="transition-duration: 0ms; transform: translate3d(0px, 0px, 0px);" class="swiper-wrapper">
                    <div style="width: 262px;" class="swiper-slide swiper-slide-active">


                        @foreach($history as $vo)
                        <a class="zk-img-item" title="{{ $vo['Title'] }}" href="{{ route('index.detail', ['id'=>$vo['id']]) }}">
                            <img style="opacity: 1;" src="" class="lazy" data-original="{{ $vo['Pic'] }}" alt="{{ $vo['Title'] }}">
                            <p class="fixed-bottom">即将失效</p>
                        </a>
                        @endforeach


                    </div>

                </div>

            </div>
        </div>
    </div>
    @endif

</div>
<div class="wrapper">
    <div class="rel-zk-area gussLike" style="margin-bottom: 30px;" data-id="{{ $_GET['id'] }}" data-cid="{{ $info['Cid'] }}" data-price="{{ $info['Price'] }}" >
        <p class="head"><span>猜你喜欢</span></p>
        <div class="rel-zk-list clearfix">

            @include('home.index.public.goods')


        </div>
    </div>
</div>
<script type="text/javascript">
    // 倒计时
    $(function(){
        var timeArea = $('#eventTimeStr');
        var endTime = $('#endTime').val();
        setInterval(dateCountDown,1000);
        function dateCountDown(){
            var now = Math.floor(new Date().getTime()/1000)*1;
            if(now > endTime){
                timeArea.html('');
            }else{
                var gap = endTime - now;
                var dd = Math.floor(gap/(60*60*24));
                var hh = Math.floor((gap-dd*60*60*24)/(60*60));
                var mm = Math.floor((gap-dd*60*60*24-hh*60*60)/60);
                var ss = gap-dd*60*60*24-hh*60*60-mm*60;
                var timeStr = '优惠券即将失效:&nbsp;'
                        +(dd>0?'<em>'+dd+'</em>天':'')
                        +(hh>0?'<em>'+hh+'</em>时':'')
                        +(mm>0?'<em>'+mm+'</em>分':'')
                        +(ss>=0?'<em>'+ss+'</em>秒':'');
                timeArea.html(timeStr);
            }
        }
    });
    // 加载猜你喜欢数据
    var id = $('.gussLike').attr('data-id');
    var cid = $('.gussLike').attr('data-cid');
    var price = $('.gussLike').attr('data-price');
    $.get('/home/index/guessLike', {id:id,cid:cid,price:price}, function (str) {
        $('.rel-zk-list').append(str);
    }, '');


//    $(function(){
//        //浏览历史
//        var goodsId = '43098899241';
//        var hisGoodsIds = $.cookie('his_goods_ids') || '';
//        hisGoodsIds = decodeURIComponent(hisGoodsIds);
//        if(hisGoodsIds.indexOf(goodsId+',') >= 0){
//            hisGoodsIds = hisGoodsIds.replace(goodsId+',','');
//        }
//        hisGoodsIds += '43098899241';
//        hisGoodsIds = hisGoodsIds.split(',');
//        if(hisGoodsIds.length > 20){
//            hisGoodsIds = hisGoodsIds.splice(hisGoodsIds.length-20,20);
//        }
//        hisGoodsIds = hisGoodsIds.join(',')+',';
//        var d = new Date();
//        d.setTime(d.getTime()+(365*24*60*60*1000));
//        $.cookie('his_goods_ids',hisGoodsIds,{
//            path:'/',
//            expires:d
//        });
//
//
//        var timeArea = $('#eventTimeStr');
//        var endTime = $('#endTime').val()*1;
//        setInterval(dateCountDown,1000);
//        function dateCountDown(){
//            var now = Math.floor(new Date().getTime()/1000)*1;
//            if(now > endTime){
//                timeArea.html('优惠券已失效');
//            }else{
//                var gap = endTime - now;
//                var dd = Math.floor(gap/(60*60*24));
//                var hh = Math.floor((gap-dd*60*60*24)/(60*60));
//                var mm = Math.floor((gap-dd*60*60*24-hh*60*60)/60);
//                var ss = gap-dd*60*60*24-hh*60*60-mm*60;
//                var timeStr = '优惠券即将失效:&nbsp;'
//                        +(dd>0?'<em>'+dd+'</em>天':'')
//                        +(hh>0?'<em>'+hh+'</em>时':'')
//                        +(mm>0?'<em>'+mm+'</em>分':'')
//                        +(ss>=0?'<em>'+ss+'</em>秒':'');
//                timeArea.html(timeStr);
//            }
//        }
//    });
</script>


@include('home.index.public.footer')