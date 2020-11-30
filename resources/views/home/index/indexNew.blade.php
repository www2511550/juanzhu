
@include('home.index.public.header')



{{--列表分类筛选栏目--}}
@if( $cid > 0 || $mid || $_GET['kw'] )
    @include('home.index.public.list_menu')
@endif


{{--首页分类区域--}}
@if($cid == 0 && !$mid && !$_GET['kw'])
    @include('home.index.public.index_menu')
@endif

{{--商品列表区块--}}
<div class="wrapper home-wrapper">
    <div id="couponList" class="zk-list clearfix"
         cid="{{$_GET['cid']}}" mid="{{$_GET['mid']}}" kw="{{$_GET['kw']}}"
         sort="{{$_GET['sort']}}" price="{{$_GET['price']}}">

        @include('home.index.public.goods')

    </div>
    <p class="more" style="text-align: center;line-height: 80px;font-size: 14px;color: red;font-weight: 700">拼命加载中......</p>


</div>


@include('home.index.public.footer')
