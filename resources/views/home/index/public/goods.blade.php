@if($data)
    @foreach($data as $val)

        <div class="zk-item">
            <div class="img-area">

                <div class="lq">
                    <a href="{{ $val->getQuanUrl($val) }}"
                       target="_blank" rel="nofollow">
                        <div class="lq-t">
                            <p class="lq-t-d1">领优惠券</p>
                            <p class="lq-t-d2">省<span>{{$val['Quan_price']}}</span>元</p>
                        </div>
                        <div class="lq-b"></div>
                    </a>
                </div>

                <div class="bottom-info">
                    <p class="time-count eventTimeStr" id="eventTimeStr"><em></em>天<em></em>时<em></em>分<em></em>秒</p>
                    <input class="endTime" id="endTime" value="{{ strtotime($val['Quan_time']) }}" type="hidden">
                    {{--<p class="time-count" data-endtime="1504799999"><i class="cate-icon">&#xe66b;</i> 还剩:</p>--}}
                </div>
                <a href="{{ $val->getQuanUrl($val, 'pc_detail') }}" target="_blank"
                   title="{{$val['Title']}}">
                    <img alt="{{$val['Title']}}"
                         data-original="{{$val['Pic']}}" class="lazy" src="/images/loading.gif"
                         style="opacity: 1;">
                </a>
            </div>
            <p class="title-area elli">
                <span class="post-free">包邮</span>{{$val['Title']}}
            </p>
            <div class="raw-price-area">现价：¥<s>{{$val['Org_Price']}}</s><p class="sold">已领 <i style="color:red">{{$val['Quan_surplus']}}</i> 张券</p></div>
            <div class="info">
                <div class="price-area">
                    <span class="price">
                        ¥<em class="number-font">{{$val['Price']}}</em>
                        <i></i>
                    </span>
                </div>
                <div class="buy-area">
                    <a href="{{ $val->getQuanUrl($val) }}" target="_blank" rel="nofollow">
                        <span class="coupon-amount">去天猫</span>
                        <span class="btn-title">火速领券</span>
                    </a>
                </div>
                <div class="platform-area">
                    <img src="/images/platform_tmall.png">天猫
                </div>
            </div>
        </div>

<script type="text/javascript">
    // 倒计时
    $(function(){
        $('.eventTimeStr').each(function (idx) {
            var timeArea = $('.eventTimeStr').eq(idx);
            var endTime = $('.endTime').eq(idx).val();
            setInterval(dateCountDown,1000);
            function dateCountDown(){
                var now = Math.floor(new Date().getTime()/1000)*1;
                if(now > endTime){
                    timeArea.html('优惠券已失效');
                }else{
                    var gap = endTime - now;
                    var dd = Math.floor(gap/(60*60*24));
                    var hh = Math.floor((gap-dd*60*60*24)/(60*60));
                    var mm = Math.floor((gap-dd*60*60*24-hh*60*60)/60);
                    var ss = gap-dd*60*60*24-hh*60*60-mm*60;
                    var timeStr = '<i class="cate-icon">&#xe66b;</i>还剩:&nbsp;'
                            +(dd>0?'<em>'+dd+'</em>天':'')
                            +(hh>0?'<em>'+hh+'</em>时':'')
                            +(mm>0?'<em>'+mm+'</em>分':'')
                            +(ss>=0?'<em>'+ss+'</em>秒':'');
                    timeArea.html(timeStr);
                }
            }
        })
    });
</script>
    @endforeach
@endif


