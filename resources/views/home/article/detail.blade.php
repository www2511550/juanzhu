@include('home.article.public.header')

<body>
<div class="placeholder-height"></div>
<div class="article-section-wrap">
    <div class="article-section" data-aid="197460">
        <div class="container" id="article197460">
            <div class="nrtj-wrap" id="nrtj-wrap197460"></div>
            <div class="wrap-left pull-left">
                <!--文章内容页-->
                <div class="article-left-btn-group is-sticky" id="article-left-btn-group197460">
                    <ul>
                        <!--普通文章分享微博-->
                        <li><a href=""><i class="icon icon-article icon-article-wb js-weibo js-share-article"
                                          data-location="article" data-f="pc-weibo-article" aid="197460"></i></a></li>
                        <!--普通文章分享微信-->
                        <li class="weixin">
                            <div class="weixin-Qr-code "></div>
                            <a class="js-weixin" data-f="pc-friends-article"><i
                                        class="icon icon-article icon-article-pyq"></i></a>
                        </li>
                        <!--普通文章分享支付宝 -->
                        <li class="zhifubao">
                            <div class="zhifubao-Qr-code"></div>
                            <a class="js-zhifubao" data-f="pc_alipay_article"><i
                                        class="icon icon-article icon-article-zfb"></i></a>
                        </li>
                        <!--普通文章分享qq空间 -->
                        <li><a href=""><i class="icon icon-article icon-article-qzone js-qzone js-share-article"
                                          data-location="article" data-f="pc-qzone-article" aid="197460"></i></a></li>
                        <li><a class="js-article-pl-anchor"><i class="icon icon-article icon-article-pl">评论</i></a></li>
                        <!--普通文章收藏-->
                        <li><a class="js-collection-article"><i class="icon icon-article icon-article-col">收藏</i></a>
                        </li>
                    </ul>
                </div>
                <div class="article-wrap">
                    <h1 class="t-h1">{{$detail->title}}</h1>
                    <div class="article-author">
                        {{--<span class="author-name"><a href="/member/1373658.html" target="_blank">判官</a></span>--}}
                        <div class="column-link-box">
                            <span class="article-time pull-left">{{ date('Y-m-d H:i', strtotime($detail->created_at)) }}</span>
                            <span class="article-share pull-left">收藏{{ rand(50, 200) }}</span>
                            <span class="article-pl pull-left">评论{{ rand(10, 100) }}</span>
                            <a href="#" class="column-link" target="_blank"></a> <i></i>
                        </div>
                    </div>
                    <!--文章头图-->
                    <div class="article-img-box">
                        <div class="article-content-wrap">
                            <div class="neirong-shouquan">
                                <span><b style="font-size: 16px;">{{$detail->daodu}}</b></span>
                            </div>
                            <p><br/></p>
                        </div>

                        <a href="{{ $detail->toUrl }}" target="_blank"><img src="{{$detail->cover}}" alt="{{$detail->title}}"></a>
                    </div>

                    <div class="article-content-wrap">
                        <p style="text-indent: 2em">{{$detail->intro}}</p>


                        <!--作者认证-->
                        {{--<div class="neirong-shouquan">--}}
                            {{--<span class="c2">*文章为作者独立观点，不代表虎嗅网立场<br></span>--}}
                            {{--<span>本文由 <a href="#" target="_blank">判官</a> 授权 <a href="/">虎嗅网</a> 发表，并经虎嗅网编辑。转载此文请于文首标明作者姓名，保持文章完整性（包括虎嗅注及其余作者身份信息），并请附上出处</span>--}}
                            {{--<br/>--}}
                            {{--<span><b>未按照规范转载者，虎嗅保留追究相应责任的权利</b></span>--}}
                        {{--</div>--}}
                        {{--<div class="neirong-shouquan-public">--}}
                            {{--<span><b>未来面前，你我还都是孩子，还不去下载 <a href="#" target="_blank">虎嗅App </a>猛嗅创新！</b></span>--}}
                        {{--</div>--}}

                    </div>

                    <div class="Qr-code">
                        <!--普通文章点赞-->
                        <div class="praise-box transition js-like-article pull-right " data-type="like">
                            <div class="praise-box-add"><i class="icon icon-article-zan-add"></i><span>+1</span></div>
                            <i class="icon icon-article-zan"></i><span class="num">32</span>
                        </div>
                        <span class="btn tool-tip  btn-exceptional js-qr-ds transition">打赏</span>
                        <div class="js-qr-img transition info-false">
                            <div class="article-zfb-wx-box" onmouseover="isOut=false" onmouseout="isOut=true">
                                <ul>
                                    <li class="zhifb-mouseover">
                                        <i class="icon icon-zhifb"></i>
                                        <div class="j-btm zfbdashang-wrap"><img
                                                    src="https://mobilecodec.alipay.com/show.htm?code=rex021253evapgmoq9smla8"
                                                    alt=""/><i class="c2">给 Ta打个赏</i></div>
                                    </li>
                                    <li class="weix-mouseover"><i class="icon icon-weix"></i>
                                        <div class="j-btm wxdashang-wrap"><img
                                                    src="https://img.huxiucdn.com/author_qr/8/1373658_1496668398_weixin.jpg"
                                                    alt=""/><i class="c2">给 Ta 打个赏</i></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--管理员底部按钮-->
                    {{--<div class="article-manage-bar article-bottom-manage-bar"
                         id="article-bottom-manage-bar197460"></div>
                    <div class="tag-box ">
                        <ul class="transition">
                            <a href="#" target="_blank">
                                <li class="transition">投稿</li>
                            </a>
                            <a href="#" target="_blank">
                                <li class="transition">创业</li>
                            </a>
                            <a href="#" target="_blank">
                                <li class="transition">商业模式</li>
                            </a>
                        </ul>
                    </div>
                    <!--公共评论-->
                    <div class="pl-wrap" id="pl-wrap-article197460" name="pl-wrap-article">
                        <div class="pl-form-wrap">
                            <span class="span-mark-author active">发表评论</span>
                            <div class="pl-form-box pl-article-wrap">
                                <div class="no-login-box "><a class="js-login">登录</a>后参与评论</div>
                                <textarea class="form-control hide" id="saytext197460" name="saytext"
                                          placeholder="客官，8个字起评，不讲价哟"></textarea>
                                <!--普通文章评论发表-->
                                <button class="btn btn-article js-login transition ">发表</button>
                            </div>
                        </div>
                        <div id="pl-wrap197460" name="pl-wrap"></div>
                        <div class="pl-list-wrap">
                            <div class="pl-loading hide"><img src="/static_2015/img/pl-loading.gif"></div>
                            <a href="javascript:void(0)" class="span-mark-author active js-default-new-pl"
                               data-type="agree">默认评论</a>
                            <i class="icon icon-line-pl"></i>
                            <a href="javascript:void(0)" class="span-mark-author new js-default-new-pl"
                               data-type="dateline">最新评论</a>
                            <div class="pl-box-wrap">
                                <div class="pl-box-top">
                                    <div class="dropdown pull-right">
                                        <button class="btn btn-default dropdown-toggle" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <span class="caret"></span>
                                        </button>
                                    </div>
                                    <div class="author-info">
                                        <div class="author-face"><img
                                                    src="https://img.huxiucdn.com/auth/data/avatar/001/54/60/18_1479690318.jpg?|imageMogr2/strip/interlace/1/quality/85/format/jpg">
                                        </div>
                                        <span class="author-name"><a href="#">请叫我__宝器</a><a href="/vip"
                                                                                            target="_blank"></a></span>
                                        <span class="time">6天前</span>
                                    </div>
                                    <div class="pl-content">三个这么浅显的例子和分析就能让作者得出结论，这"一叶知秋"的本事我也是服的。</div>
                                </div>
                                <div class="pl-box-btm">
                                    <div class="article-type pull-right">
                                        <div class="icon-like-prompt">
                                            <i class="icon icon-like active"></i><span class="c1">+1</span>
                                        </div>
                                        <div class="icon-no-like-prompt">
                                            <i class="icon icon-no-like active"></i><span class="c1">+1</span>
                                        </div>
                                        <ul>
                                            <li class="js-icon-like" data-type="like"><i
                                                        class="icon icon-like "></i><span class="like">2</span></li>
                                            <li class="js-no-icon-like" data-type="no-like"><i
                                                        class="icon icon-no-like "></i><span class="like">1</span></li>
                                        </ul>
                                    </div>
                                    <div class="btn-dp transition js-add-dp-box"><i class="icon icon-dp"></i>我要点评</div>
                                    <div class="pl-form-box dp-article-box">
                                        <textarea class="form-control" placeholder="客官，8个字起评，不讲价哟"></textarea>
                                        <button class="btn btn-article js-article-dp">发表</button>
                                    </div>
                                </div>

                            </div>
                            <div class="pl-box-wrap  " data-pid="644658" id="g_pid644658">
                                <div class="pl-box-top">
                                    <div class="dropdown pull-right">
                                        <button class="btn btn-default dropdown-toggle" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li class="pl-report js-report-pl" aid="197460" pid="644658">举报</li>
                                        </ul>
                                    </div>
                                    <div class="author-info">
                                        <div class="author-face"><img
                                                    src="https://img.huxiucdn.com/auth/data/avatar/001/68/30/86_1496144520.jpg?|imageMogr2/strip/interlace/1/quality/85/format/jpg">
                                        </div>
                                        <span class="author-name">
                    					<a href="#">lingboxiu</a>
                    					<a href="#" target="_blank"></a>
                					</span>
                                        <span class="time">6天前</span>
                                    </div>
                                    <div class="pl-content">小罐茶，记得是非常非常贵</div>
                                    <div class="dp-box">
                                        <span class="span-mark-author">点评</span>
                                        <div class="dl-user dl-user-list  " data-type="dl-user" style="display:block">
                                            <ul>
                                                <li class="del-pl108924"><a href="#" target="_blank"><img
                                                                src="https://img.huxiucdn.com/auth/data/avatar/3.jpg?|imageMogr2/strip/interlace/1/quality/85/format/jpg"></a>
                                                </li>
                                            </ul>
                                            <!--只有一条点评时显示-->
                                            <div class="one-pl-content one-pl-content-box">
                                                <div class="pull-right time">6天前</div>
                                                <p class="content">
                                                    <span class="name">寂地_</span>
                                                    <a href="#" target="_blank"></a>&nbsp;&nbsp;
                                                    <span class="author-content">@lingboxiu 马云家有，对我尔等来说确实是灰常贵</span>
                                                </p>
                                                <div class="js-hf-article-pl"><span>回复</span></div>
                                                <div class="hu-pl-box">
                                                    <textarea class="form-control"
                                                              placeholder="客官，8个字起评，不讲价哟"></textarea>
                                                    <button class="btn btn-article js-article-dp" data-type="hf">发表
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dp-list-box" style="display:none">
                                            <div class="dl-user del-pl108924">
                                                <ul>
                                                    <li><a href="#" target="_blank"><img
                                                                    src="https://img.huxiucdn.com/auth/data/avatar/3.jpg?|imageMogr2/strip/interlace/1/quality/85/format/jpg"></a>
                                                    </li>
                                                </ul>
                                                <div class="one-pl-content">
                                                    <div class="pull-right time">6天前</div>
                                                    <p class="content">
                                                        <span class="name">寂地_</span>
                                                        <a href="#" target="_blank"></a>&nbsp;&nbsp;
                                                        <span class="author-content"><a href="#"
                                                                                        target="_blank">@lingboxiu</a> 马云家有，对我尔等来说确实是灰常贵</span>
                                                    </p>
                                                    <div class="js-hf-article-pl"><span>回复</span></div>
                                                    <div class="hu-pl-box">
                                                        <textarea class="form-control"
                                                                  placeholder="客官，8个字起评，不讲价哟"></textarea>
                                                        <button class="btn btn-article js-article-dp" data-type="hf">
                                                            发表
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="close-dp-list-box js-show-hide-dp-box" data-buttom="true">收起
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pl-box-btm">
                                    <div class="article-type pull-right">
                                        <div class="icon-like-prompt">
                                            <i class="icon icon-like active"></i><span class="c1">+1</span>
                                        </div>
                                        <div class="icon-no-like-prompt">
                                            <i class="icon icon-no-like active"></i><span class="c1">+1</span>
                                        </div>
                                        <ul>
                                            <li class="js-icon-like" data-type="like"><i
                                                        class="icon icon-like "></i><span class="like">2</span></li>
                                            <li class="js-no-icon-like" data-type="no-like"><i
                                                        class="icon icon-no-like "></i><span class="like">1</span></li>
                                        </ul>
                                    </div>
                                    <div class="btn-dp transition js-add-dp-box"><i class="icon icon-dp"></i>我要点评</div>
                                    <div class="pl-form-box dp-article-box">
                                        <textarea class="form-control" placeholder="客官，8个字起评，不讲价哟"></textarea>
                                        <button class="btn btn-article js-article-dp">发表</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--相关文章位置-->
                    <div id="related-article-wrap197460"></div>--}}
                </div>
            </div>
            <div class="wrap-right pull-right">
                {{--<div class="box-moder hot-tag">--}}
                    {{--<h3>热门标签</h3>--}}
                    {{--<span class="pull-right project-more"><a href="#" class="transition" target="_blank">全部</a></span>--}}
                    {{--<span class="span-mark"></span>--}}
                    {{--<div class="search-history search-hot">--}}
                        {{--<ul>--}}
                            {{--<li class="transition"><a href="#" target="_blank">阿里巴巴</a></li>--}}
                            {{--<li class="transition"><a href="#" target="_blank">投稿</a></li>--}}
                            {{--<li class="transition"><a href="#" target="_blank">创业</a></li>--}}
                            {{--<li class="transition"><a href="#" target="_blank">头条</a></li>--}}
                            {{--<li class="transition"><a href="#" target="_blank">马云</a></li>--}}
                            {{--<li class="transition"><a href="#" target="_blank">大数据</a></li>--}}
                            {{--<li class="transition"><a href="#" target="_blank">移动互联网</a></li>--}}
                            {{--<li class="transition"><a href="#" target="_blank">电子商务</a></li>--}}
                            {{--<li class="transition"><a href="#" target="_blank">微信</a></li>--}}
                            {{--<li class="transition"><a href="#" target="_blank">Facebook</a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="placeholder"></div>
                <div class="box-moder hot-article">
                    <h3>热文</h3>
                    <span class="span-mark"></span>
                    <ul>

                        @if($hotArticle)
                            @foreach($hotArticle as $article)
                                <li>
                                    <div class="hot-article-img">
                                        <a href="{{ route('article.detail', ['id'=>$article->id]) }}" target="_blank"><img src="{{$article->cover}}"></a>
                                    </div>
                                    <a href="{{ route('article.detail', ['id'=>$article->id]) }}" class="transition" target="_blank">{{$article->title}}</a>
                                </li>
                            @endforeach
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="article-section article-section-last"></div>
</div>


@include('home.article.public.footer')

<script>
    $(document).ready(function () {
        $(".dp-article-box").fadeOut(0);
        $(".js-add-dp-box").click(function () {
            $(".dp-article-box").not($(this).next()).slideUp('fast');
            $(this).next().slideToggle(400);
        });
    });
</script>
</body>
</html>