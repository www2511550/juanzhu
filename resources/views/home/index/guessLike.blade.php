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
                <a href="{{ $val->getQuanUrl($val, 'pc_detail') }}" target="_blank"
                   title="{{$val['Title']}}">
                    <img alt="{{$val['Title']}}" class="lazy" src="{{$val['Pic']}}"
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

    @endforeach
@endif
