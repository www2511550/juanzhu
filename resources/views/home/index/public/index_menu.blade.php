<div class="wrapper home-oper-area">
    <div class="cate-area">

    @if($cate)
        @foreach($cate as $val)
            <a class="cate-item" href="?cid={{$val['cid']}}&mid={{$mid}}" @if( $val['cid'] == $cid) class="active" @endif>
                <div class="inner">
                    <i class="cate-icon">{{ $arrIcon[$val['cid']]?:'&#xe72b;' }}</i> {{ $val['c_name'] }}
                </div>
            </a>
        @endforeach
    @endif

    </div>
    <!--广告轮播-->
    <div class="banner-top">
        <div class="banner-area swiper-container swiper-container-horizontal">

            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <a target="_blank" class="swiper-slide swiper-slide-duplicate" href="https://s.click.taobao.com/YCcbIbw"
                       data-swiper-slide-index="1"  style="width: 660px;">
                        <img style="width: 100%;" src="/shop/imgs/3f1ceb548b2bec275864d59a8081636b.jpg">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a target="_blank" class="swiper-slide swiper-slide-duplicate" href="?cid=1&sort=volume"
                       data-swiper-slide-index="2" style="width: 660px;">
                        <img style="width: 100%;" src="/shop/imgs/7c009191502ce96f53a03fe29447a73e.jpg">
                    </a>
                </div>

            </div>

            <div class="swiper-bottom">
                <div class="swiper-pager"></div>
            </div>

        </div>

        <div class="top-right-banner">
            <a href="/" target="_blank" title="轮播右侧">
                <img src="/images/down_app.png" title="官方微信" style="width: 200px;height: 230px;">
            </a>
        </div>

    </div>


    <div class="small-banner-area">
        <div href="javascript:;" class="small-banner-item">
            <a target="_blank" href="?kw=短袖">
                <img src="/shop/imgs/a8283a0300dd1c29e699a56cc9c71b00.jpg">
                <p class="title">新款短袖</p>
            </a>
        </div>
        <div href="javascript:;" class="small-banner-item">
            <a target="_blank" href="?kw=唇妆">
                <img src="/shop/imgs/78de719addf37e44acd6b8651cc9c434.jpg">
                <p class="title">唇妆</p>
            </a>
        </div>
        <div href="javascript:;" class="small-banner-item">
            <a target="_blank" href="?kw=薄款 外套">
                <img src="/shop/imgs/bd3f3c9bbd13b0227c8d97d82a714aae.jpg">
                <p class="title">薄款外套</p>
            </a>
        </div>
        <div href="javascript:;" class="small-banner-item">
            <a target="_blank" href="?kw=单肩包">
                <img src="/shop/imgs/2d09d5722be9dc0f42f613ba82b56263.jpg">
                <p class="title">单肩包</p>
            </a>
        </div>
        <div href="javascript:;" class="small-banner-item">
            <a target="_blank" href="?kw=男士 T恤">
                <img src="/shop/imgs/d11dd600269309f1578ac6e7ecc41627.jpg">
                <p class="title">男士T恤</p>
            </a>
        </div>
        <div href="javascript:;" class="small-banner-item">
            <a target="_blank" href="?kw=气质 美裙">
                <img src="/shop/imgs/5fc14b1bb6e1a63011a658c8bafefd3d.jpg">
                <p class="title">气质美裙</p>
            </a>
        </div>

    </div>
</div>