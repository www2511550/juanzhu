<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>卷猪优惠卷</title>
    <meta name="Keywords" content="淘宝优惠券，天猫优惠券，优惠券折扣,9块9包邮,限时特卖,优品折扣,卷猪猪"/>
    <meta name="Description" content="优惠券折扣直播第一站！每天更新千款，纯人工筛选验货，限时限量特卖，全场1折包邮！"/>
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/quan.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.lazyload.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/clipboard.min.js') }}"></script>
    <style>
        .pagination{
            margin:0 auto;
        }
        .pagination>li{
            padding: 5px;float: left;
        }
        .pagination>li>a{
            display: inline-block;  vertical-align: top;  margin-right: 4px;  width: 26px;  height: 26px;  line-height: 26px;
            color: #333;  text-align: center;  background: #f5f5f5;  border: 1px solid #dcdcdc;
        }
        .pagination>li.active>span{
            display: inline-block;  vertical-align: top;  margin-right: 4px;  width: 26px;  height: 26px;  line-height: 26px;
            color: #333;  text-align: center;  background: #ff6c70;  border: 1px solid #dcdcdc;
        }
        .tk-list-cont .tk-list-title {
            padding-bottom: 10px;
            margin: 0 0 15px;
            line-height: 20px;
            font-size: 18px;
            font-weight: 700;
            color: #3b3b3b;
            border-bottom: 1px solid #d7d7d7;
        }
        .tk-list-cont .tk-list-title .icon-jian{
            display: inline-block;
            vertical-align: top;
            margin-right: 5px;
            width: 24px;
            height: 24px;
            background: url(/images/title_jian.png) center center no-repeat;
        }
        .tk-list-cont .tk-list-title .icon-miao{
            display: inline-block;
            vertical-align: top;
            margin-right: 5px;
            width: 24px;
            height: 24px;
            background: url(/images/title_miao.png) center center no-repeat;
        }
        .lingquan{
            position: absolute;right: 0;top: 0;background: url(/images/lingquan.png);display: inline;width: 75px;height: 75px;
        }
        .lingquan>span{
            color: #fff;font-size: 13px;display: inline-block;margin-left: 34%;margin-top: 30px;
        }
        #toast {
            background: #337ccb;
            opacity: .9;
            display: none;
            color: #fff;
            padding: 12px;
            position: fixed;
            margin: auto;
            box-sizing: border-box;
            transform: translateY(-50%);
            top: 50%;
            left: 0;
            right: 0;
            max-width: 200px;
            line-height: 20px;
            z-index: 999;
            text-align: center;
            border-radius: 5px;
            -webkit-transition: all .3s ease-in;
        }
    </style>
    <script type="text/javascript">
        $(function() {
            $("img.lazy").lazyload();
        });
    </script>
</head>
<body>
<div class="tk-header">
    <div class="tk-header-top">
        <div class="page-all">
            <div class="fl">专注单品、极致转化！
                <span id="userInfo">
                    <a href="" class="reg">[登陆]</a><a href="" class="reg">[注册]</a>
                </span>
            </div>
            <a href="http://shang.qq.com/wpa/qunwpa?idkey=96ff58f916630c9d6e6bff5e35bc574e8624c8c3617226f0c58f13e1e33800f3"
               target="_blank" rel="nofollow" class="fr">
                <img border="0" src="https://img.alicdn.com/imgextra/i1/2508158775/TB2SfmWqFXXXXb4XpXXXXXXXXXX_!!2508158775.png" _hover-ignore="1">
                亲爱的，来加天猫内部福利QQ群
            </a>
            {{--<a href="" class="fr">商家合作</a>--}}
        </div>
    </div>
    <div class="tk-header-cont">
        <div class="page-all">
            <a class="tk-logo fl" href=""><img src="/images/juanzhuzhu.gif" style="margin-top: 12px"></a>
            <div class="fr"  style="float: left;margin-left: 50px;">
                <form class="inline-block" action="/home/index/quan" id="search_form">
                    <div class="form-group">
                        <label for="search"></label>
                        <i class="tk-icon icon-fangdaj"></i>
                        <input type="text" name="search" placeholder="请输入您要搜索的商品名称或链接" value="{{ $_GET['search'] ? $_GET['search'] : '' }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="sub-btn">搜索</button>
                    </div>
                </form>
                <div class="form-group right-ad">
                    <img src="/images/right.gif" style="margin-top: 9px;height:30px;">
                </div>
            </div>
        </div>
    </div>
</div>


<div class="tk-main-nav mb15">
    {{--<div class="page-all">
        <ul class="clearfix">
            <ul class="clearfix">
                <li class="nav-active"><a href="/home/index/quan/">领券直播<i class="tk-icon icon-hot"></i></a></li>
                <li><a href="/home/index/quan/">实时排行榜</a></li>
                <li onclick="alert('正在开发中，敬请期待')"><a href="/home/index/quan/">CMS网站</a></li>
            </ul>
        </ul>
    </div>--}}
</div>
<div class="tk-container clearfix mb20">
    <div class="page-all clearfix">
        {{--<div class="tk-top-banner">--}}
            {{--<img src="/images/quan_big.png">--}}
        {{--</div>--}}

        <div class="tk-list-choice">
            <div class="list-choice-first clearfix" style="border-top: 1px solid #e4e4e4">
                <a href="/home/index/quan"><span @if( !isset($_GET['cid']) ) class="red" @endif>全部优惠<em>({{$goods_total}})</em></span></a>

                @if( $cate )
                    @foreach( $cate as $val )
                        <a href="/home/index/quan?cid={{$val['cid']}}">
                            <span @if( isset($_GET['cid']) && $_GET['cid'] == $val['cid'] ) class="red" @endif >{{ $val['c_name'] }}<em>({{ $val['total'] }})</em></span>
                        </a>
                    @endforeach
                @endif
            </div>
            <div class="list-choice-two clearfix">
                <div class="fl">
                    <span class="option"><a href="/home/index/quan?cid={{ intval($_GET['cid']) }}" @if( !$_GET['order'] ) class="red" @endif>默认排序</a></span>|
                    <span class="option price"><a href="/home/index/quan?cid={{ intval($_GET['cid']) }}&order={{ $_GET['order'] == 'price_down' ? 'price_up' : 'price_down' }}" @if( in_array($_GET['order'], ['price_up','price_down']) ) class="red" @endif>价格</a></span>|
                    <span class="option"><a href="/home/index/quan?cid={{ intval($_GET['cid']) }}&order=sale" @if( isset($_GET['order']) && $_GET['order'] == 'sale' ) class="red" @endif>销量优先</a></span>|
                    <span class="option"><a href="/home/index/quan?cid={{ intval($_GET['cid']) }}&order=save" @if( isset($_GET['order']) && $_GET['order'] == 'save' ) class="red" @endif>优惠度</a></span>|
                    <form handle="filterForm" action="/home/index/quan">
                        <input type="hidden" name="cid" value="{{ intval($_GET['cid']) }}">
                        <input type="hidden" name="order" value="{{ $_GET['order'] }}">
							<span class="option">
								价格<input type="text" name="p_min" class="text" value="{{ $_GET['p_min'] ? $_GET['p_min'] : '' }}">
                                到<input type="text" class="text" name="p_max" value="{{ $_GET['p_max'] ? $_GET['p_max'] : '' }}">
							</span>
                        <span class="option nopad">
								佣金率<input type="text" name="cr_min" class="text" value="{{ $_GET['cr_min'] ? $_GET['cr_min'] : '' }}">
                                到<input type="text" class="text" name="cr_max" value="{{ $_GET['cr_max'] ? $_GET['cr_max'] : '' }}">
								<button type="submit">确定</button>
							</span>
                    </form>
                    <input type="checkbox" name="tag" id="jiukuaijiu" value="/home/index/quan?cid={{ intval($_GET['cid']) }}&order={{ $_GET['order'] }}&c_check=1"
                           onchange="location.href=this.value" @if( 1 == $_GET['c_check']) checked="" @endif>
                    <label for="jiukuaijiu">九块九</label>
                    <input type="checkbox" name="tag" id="bianhot" value="/home/index/quan?cid={{ intval($_GET['cid']) }}&order={{ $_GET['order'] }}&c_check=2"
                           onchange="location.href=this.value" @if( 2 == $_GET['c_check']) checked="" @endif>
                    <label for="bianhot">小编精选</label>
                    <input type="checkbox" name="tag" id="istmall" value="/home/index/quan?cid={{ intval($_GET['cid']) }}&order={{ $_GET['order'] }}&c_check=3"
                           onchange="location.href=this.value" @if( 3 == $_GET['c_check']) checked="" @endif>
                    <label for="istmall">天猫</label>
                    <input type="checkbox" name="tag" id="isbrand" value="/home/index/quan?cid={{ intval($_GET['cid']) }}&order={{ $_GET['order'] }}&c_check=4"
                           onchange="location.href=this.value" @if( 4 == $_GET['c_check']) checked="" @endif>
                    <label for="isbrand">品牌</label>
                </div>
                <div class="fr">
                    <div><span><i class="tk-icon"></i></span><span class="num"><em></em>/</span><span>
                            <a class="title-btn fl title-next" href="/home/index/quan/?p=">
                                >
                            </a><i class="tk-icon"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="tk-list-cont" id="listArea" style="margin-top: 30px;">

        @if($recom)
            <div class="tk-list-title clearfix">
                {{--<span class="fr refresh" id="refreshRecommend"><i class="tk-icon icon-refresh"></i> 换一批</span>--}}
                <i class="icon-jian"></i>
                小编推荐
                <span></span>
                {{--<a href="/home/index/quan/" class="fr">查看更多>></a>--}}
            </div>

                <div class="user-cont-list">
                    <ul class="clearfix" id="recommentItems">

                        @foreach($recom as $val)
                            <li class="user-list-item today-new">
                                <div class="item-img img-hot">
                                    <a href="{{ $val->getQuanUrl($val) }}" target="_blank" class="lingquan"><span>{{$val['Quan_price']}}
                                            元</span></a>
                                    <a href="{{ $val->getQuanUrl($val) }}" target="_blank">
                                        <img class="lazy" src="/images/loading.gif" data-original="{{$val['Pic']}}"
                                             alt=""></a></div>
                                <div class="item-cont">
                                    <p class="item-cont-title">
                                        <span class="inline-block title-img">
                                    @if($val['IsTmall'])
                                                <img src="/images/iconTaobao.png">
                                            @else
                                                <img src="/images/iconTmall.png">
                                            @endif
								</span>
                                        <a href="{{ $val->getQuanUrl($val) }}" target="_blank">{{$val['Title']}}</a>
                                    </p>
                                    <p class="coupon-surplus">优惠券剩余
                                        <em>{{ $val['Quan_surplus'] }}</em>/{{ $val['Quan_surplus']+$val['Quan_receive'] }}
                                    </p>
                                    <p class="item-cont-price clearfix">
                                        <span class="commission">优惠卷：<em>{{$val['Quan_price']}}元</em></span>
                                        <span class="label-block">通用</span>
                                        <span class="fr">销量<em>{{$val['Sales_num']}}</em></span>
                                    </p>
                                    <div class="item-title-block clearfix">
                                        <span>券后价￥<em>{{$val['Price']}}</em><del>￥{{$val['Org_Price']}}</del></span>
                                        <a class="btncopy add-spread fr" data-clipboard-target="#copy_data"
                                           data-item-info="<img src='http://opd1706yr.bkt.clouddn.com/htk_{{$val['GoodsID']}}.jpg'><br>{{ $val['Title'] }}<br>{{ $val['IsTmall'] ? '天猫' : '淘宝' }}原价{{ $val['Org_Price'] }}元，券后{{ $val['Price'] }}元包邮<br>领券下单：{{ $val->getQuanUrl($val, 'detail') }}<br>{{ $val['Introduce'] }}<br>{{ $val['taokouling'] ? '复制这条信息，打开[手机淘宝]，即可领券购买!'.$val['taokouling'] : '' }}<br>优惠卷直播:http://juanzhuzhu.com">
                                            复制文案</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
        @endif
            <div class="tk-list-title mb15 clearfix">
                <i class="icon-miao"></i>
                领券秒杀
            </div>

            <div class="user-cont-list">
                <ul class="clearfix">
                    @if($data['list'])
                        @foreach($data['list'] as $val)
                            <li class="user-list-item today-new">
                                <div class="item-img">
                                    <a href="{{ $val->getQuanUrl($val) }}" target="_blank" class="lingquan"><span>{{$val['Quan_price']}}
                                            元</span></a>
                                    <a href="{{ $val->getQuanUrl($val) }}" target="_blank">
                                        <img class="lazy" src="/images/loading.gif" data-original="{{$val['Pic']}}"
                                             alt="">
                                    </a></div>
                                <div class="item-cont">
                                    <p class="item-cont-title">
                                        <!-- <i class="tk-icon icon-taobao"></i> -->
                                        <span class="inline-block title-img">
                                    @if($val['IsTmall'])
                                                <img src="/images/iconTmall.png">
                                            @else
                                                <img src="/images/iconTaobao.png">
                                            @endif
								</span>
                                        <a href="{{ $val->getQuanUrl($val) }}" target="_blank">{{$val['Title']}}</a>
                                    </p>
                                    <p class="coupon-surplus">优惠券剩余
                                        <em>{{ $val['Quan_surplus'] }}</em>/{{ $val['Quan_surplus']+$val['Quan_receive'] }}
                                    </p>
                                    <p class="item-cont-price clearfix">
                                        <span class="commission">优惠卷：<em>{{$val['Quan_price']}}元</em></span>
                                        <span class="label-block">通用</span>
                                        <span class="fr">销量<em>{{$val['Sales_num']}}</em></span>
                                    </p>
                                    <div class="item-title-block clearfix">
                                        <span>券后价￥<em>{{$val['Price']}}</em><del>￥{{$val['Org_Price']}}</del></span>
                                        <a class="btncopy add-spread fr" data-clipboard-target="#copy_data"
                                           data-item-info="<img src='http://opd1706yr.bkt.clouddn.com/htk_{{$val['GoodsID']}}.jpg'><br>{{ $val['Title'] }}<br>{{ $val['IsTmall'] ? '天猫' : '淘宝' }}原价{{ $val['Org_Price'] }}元，券后{{ $val['Price'] }}元包邮<br>领券下单：{{ $val->getQuanUrl($val, 'detail') }}<br>{{ $val['Introduce'] }}<br>{{ $val['taokouling'] ? '复制这条信息，打开[手机淘宝]，即可领券购买!'.$val['taokouling'] : '' }}<br>优惠卷直播:http://juanzhuzhu.com">
                                            复制文案</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif

                </ul>
                <div class="preview-list-footer" style="padding: 50px;margin-left: 20%">
                    <div class="pagination-warp">
                        {{$data->render()}}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<a href="javascript:scroll(0,0);" style="position:fixed;right:3%;bottom:5%;">
    <img style="width:40px;height:40px;" src="/images/top.png">
</a>
<div style="position:fixed;margin-left:-9999px;" id="copy_data"></div>
<div id="toast" style="display: none;">已成功复制推广文案</div>

<div class="tk-footer">
    <div class="page-all">
        <div class="footer-cont clearfix">
            <dl>
                <dt>帮助中心</dt>
                <dd><a href="">淘宝助手安装指南</a></dd>
            </dl>
            <dl>
                <dt>常见问题</dt>
                <dd><a href="">招商规则</a></dd>
                <dd><a href="">违规商家处罚</a></dd>
                <dd><a href="">商家如何报名</a></dd>
            </dl>
            <dl>
                <dt>投诉意见</dt>
                <dd><a href="">招商违规投诉</a></dd>
                <dd><a href="">应用建议</a></dd>
            </dl>
            <dl>
                <dt>关于我们</dt>
                <dd><a href="">关于我们</a></dd>
                <dd><a href="">联系我们</a></dd>
            </dl>
            <!--            <dl>
                          <!--   <dt class="Code-dt">关注我们</dt> -->
            <!-- <dd><img src="http://g.ligoucdn.cn/taokemishu/1.0/img/erwei_03.jpg"></dd>
            <dd><img src="http://g.ligoucdn.cn/taokemishu/1.0/img/news/erwei_06.png"></dd> -->
            </dl>-->
        </div>
    </div>
    <div class="icp-no">
        <span>© 2017 JUANZHUZHU.COM <a href="http://www.miitbeian.gov.cn/" target="_blank">粤ICP备16100236号</a></span>
        <!--<a href="http://www.anquan.org/authenticate/cert/?site=www.taokemishu.com&at=realname" rel="nofollow" target="_blank"><img src="http://g.ligoucdn.cn/taokemishu/1.0/img/reg/login_11.png" alt="" style="" /></a>-->
    </div>
    <script>
        var _hmt = _hmt || [];
        (function () {
            var hm = document.createElement("script");
            hm.src = "//hm.baidu.com/hm.js?dc95aa8b47d7f35ed5010d3ae94f2382";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
        $('.btncopy').on('click', function() {
            var info = $(this).attr('data-item-info');
            $('#copy_data').html(info);
        });

        var clipboard = new Clipboard('.btncopy');
        clipboard.on('success', function(e) {
            $('#toast').show(0);
            $('#toast').delay(1000).hide(200);
            e.clearSelection();
        });
        clipboard.on('error', function(e) {
            alert("由于您的浏览器不兼容或当前网速较慢，复制失败，请手动复制或更换主流浏览器！");
        });

    </script>
</div>
</body>
</html>