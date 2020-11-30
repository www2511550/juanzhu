<div class="cate-box">
    <div class="tab-area">
        <div class="wrapper hori-cate-area">
            <div class="cate-l-1">
                <div class="wrapper">

                    <a href="?cid={{ $cid }}" @if(!$cid) class="active" @endif><i class="cate-icon">&#xe609;</i> 全部分类</a>
                 @if($cate)
                    @foreach($cate as $val)
                        <a href="?cid={{$val['cid']}}&mid={{$mid}}" @if( $val['cid'] == $cid) class="active" @endif>
                            <i class="cate-icon">{{ $arrIcon[$val['cid']]?:'&#xe72b;' }}</i> {{$val['c_name']}}
                        </a>
                    @endforeach
                 @endif

                </div>
            </div>
        </div>
        <div class="wrapper">
            <div class="order-area">
                <ul class="sort-type">
                    <li data-sort="default" @if(!$_GET['sort']) class="active" @endif style="padding-left: 15px;">
                        <i class="cate-icon" style="font-size:14px">&#xe682;</i>排序筛选
                    </li>
                    <li data-sort="default" @if('default'==$_GET['sort']) class="active" @endif>
                        默认 <i class="cate-icon" style="font-size:14px">&#xe607;</i>
                    </li>
                    <li data-sort="new" @if('new'==$_GET['sort']) class="active" @endif>
                        最新 <i class="cate-icon" style="font-size:14px">&#xe607;</i>
                    </li>
                    <li data-sort="volume" @if('volume'==$_GET['sort']) class="active" @endif>
                        销量 <i class="cate-icon" style="font-size:14px">&#xe607;</i>
                    </li>
                    <li data-sort="price" @if('price'==$_GET['sort']) class="active" @endif>
                        价格 <i class="cate-icon" style="font-size:14px">&#xe607;</i>
                    </li>
                    <li data-sort="quan" @if('quan'==$_GET['sort']) class="active" @endif>
                        券额 <i class="cate-icon" style="font-size:14px">&#xe607;</i>
                    </li>
                    <li data-sort="surplus" @if('surplus'==$_GET['sort']) class="active" @endif>
                        剩余 <i class="cate-icon" style="font-size:14px">&#xe607;</i>
                    </li>
                </ul>
                <ul class="price-filter">
                    <li data-price="10" @if('10'==$_GET['price']) class="active" @endif><span><i></i></span>10元券</li>
                    <li data-price="20" @if('20'==$_GET['price']) class="active" @endif><span><i></i></span>20元券</li>
                    <li data-price="50" @if('50'==$_GET['price']) class="active" @endif><span><i></i></span>50元券</li>
                    <li data-price="100" @if('100'==$_GET['price']) class="active" @endif><span><i></i></span>100元券</li>
                </ul>
            </div>
        </div>
    </div>
</div>