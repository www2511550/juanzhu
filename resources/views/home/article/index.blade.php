
@include('home.article.public.header')


<body>

{{--<header id="top" role="banner" class="transition">
<!--搜索弹窗 开始-->
<div class="box">
	<div class="box2">
		<div class="icon icon-search-close js-show-search-box"><a class="close"></a></div>
   	 	<div class="search-content overlay-dialog-animate">
        	<div class="search-input">
            	<form role="search" method="get" action="/search.html" onsubmit="return checkinput()">
                	<button type="submit"></button>
                	<input placeholder="请输入关键字" name="s" id="search-input">
                </form>
        	</div>
        	<div class="search-history hide" id="history">
            	<span>我的搜索历史</span>
            	<ul class="transition" id="history_ul">
                	<li class="transition"><a href="#">数码</a></li>
                	<li class="transition"><a href="#">科技</a></li>
                	<li class="transition"><a href="#">科技</a></li>
                	<li class="transition"><a href="#">互联网</a></li>
                	<li class="transition"><a href="#">汽车之家</a></li>
           	 	</ul>
            	<div class="pull-right empty-history js-empty-history">清空历史</div>
        	</div>
        	<div class="search-history search-hot">
            	<strong>热搜词</strong>
            	<ul>
                	<li class="transition"><a href="#">数码</a></li>
                	<li class="transition"><a href="#">科技</a></li>
                	<li class="transition"><a href="#">互联网</a></li>
                	<li class="transition"><a href="#">汽车之家</a></li>
                	<li class="transition"><a href="#">Uber</a></li>
                	<li class="transition"><a href="#">支付宝</a></li>
                	<li class="transition"><a href="#">大数据</a></li>
                	<li class="transition"><a href="#">创业</a></li>
                	<li class="transition"><a href="#">旅游</a></li>
                	<li class="transition"><a href="#">美团</a></li>
                	<li class="transition"><a href="#">社交</a></li>
            	</ul>
        	</div>
    	</div>
	</div>
</div>
<!--搜索弹窗 结束-->
<script>
    function checkinput(){
        var input = $("#search-input").val();
        if(input ==  null || input == ''){
            return false;
        }
        return true;
    }
</script>
    <div class="container">
        <div class="navbar-header transition">
            <a href="{{ route('article') }}" title="首页"><img src="/huxiu/images/logo.jpg" alt="虎嗅网" title="首页" /></a>
        </div>
        <ul class="nav navbar-nav navbar-left" id="jsddm">
            <li class="nav-news"><a href="#" target="_blank">热议<span class="nums-prompt nums-prompt-topic"></span></a></li>
            <li class="nav-news"><a href="#" target="_blank">活动</a></li>
            <li class="nav-news"><a href="#" target="_blank">创业白板<span class="nums-prompt"></span></a></li>
            <li class="nav-news"><a href="#" target="_blank">会员专享<em class="nums-prompt"></em></a></li>
            <li class="nav-news"><a href="#" target="_blank">官方Blog</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right transition  xiala main_nav">

            <li class="search-li js-show-search-box"><a><i class="icon icon-search "></i></a><span>搜索</span></li>
            <li><a class="cd-tougao">投稿</a></li>
        </ul>
    </div>

</header>--}}


<div class="placeholder-height"></div>
<div class="container" id="index">
	<div class="wrap-left pull-left">

	@if($topArticle)
        <div class="big-pic-box">
             <div class="big-pic">
                  <a href="{{ route('article.detail', ['id'=>$topArticle[0]->id]) }}" target="_blank" class="transition" title="{{$topArticle[0]->title}}">
                     <div class="back-img"><img src="{{$topArticle[0]->cover}}"  alt="{{$topArticle[0]->title}}" style="width: 533px;"></div>
                     <div class="big-pic-content">
                          <h1 class="t-h1">{{$topArticle[0]->title}}</h1>
                      </div>
                  </a>
             </div>
             <div class="big2-pic big2-pic-index big2-pic-index-top">
                  <a href="{{ route('article.detail', ['id'=>$topArticle[1]->id]) }}" class="back-img transition" target="_blank" title="{{$topArticle[1]->title}}">
                     <img class="lazy" src="{{$topArticle[1]->cover}}" alt="{{$topArticle[1]->title}}" style="width: 257px;">
                  </a>
                  <a href="{{ route('article.detail', ['id'=>$topArticle[1]->id]) }}" target="_blank" title="{{$topArticle[1]->title}}">
                     <div class="big2-pic-content">
                          <h2 class="t-h1">{{$topArticle[1]->title}}</h2>
                     </div>
                  </a>
             </div>
             <div class="big2-pic big2-pic-index big2-pic-index-bottom">
				 <a href="{{ route('article.detail', ['id'=>$topArticle[2]->id]) }}" class="back-img transition" target="_blank" title="{{$topArticle[2]->title}}">
					 <img class="lazy" src="{{$topArticle[2]->cover}}" alt="{{$topArticle[2]->title}}"  style="width: 257px;">
				 </a>
				 <a href="{{ route('article.detail', ['id'=>$topArticle[2]->id]) }}" target="_blank" title="{{$topArticle[2]->title}}">
					 <div class="big2-pic-content">
						 <h2 class="t-h1">{{$topArticle[2]->title}}</h2>
					 </div>
				 </a>
             </div>
       </div>
	@endif

    {{--左侧内容区块--}}
       <div class="mod-info-flow">

           @if($data[0])
               @foreach($data as $vo)

                   <div class="mod-b mod-art" data-aid="213665">
                       <div class="mod-angle">热</div>
                       <div class="mod-thumb ">
                           <a class="transition" title="{{$vo->Title}}" href="{{ route('article.detail', ['id'=>$vo->id]) }}" target="_blank">
                               <img class="lazy" alt="{{$vo->Title}}" data-original="{{$vo->Pic}}" src="{{$vo->Pic}}">
                           </a>
                       </div>
                       <div class="column-link-box">
                           <a href="#" class="column-link" target="_blank"></a>
                       </div>
                       <div class="mob-ctt">
                           <h2><a href="{{ route('article.detail', ['id'=>$vo->id]) }}" class="transition msubstr-row2" target="_blank">{{$vo->Title}}</a></h2>
                           <div class="mob-author">
                               <div class="author-face">
                                   <a href="#" target="_blank"><img src="/huxiu/sy-img/59_1502432173.jpg"></a>
                               </div>
                               <a href="#" target="_blank">
                                   <span class="author-name ">量子位</span>
                               </a>
                               <a href="#" target="_blank" title="购买VIP会员"></a>
                               <span class="time">1小时前</span>
                               <i class="icon icon-cmt"></i><em>0</em>
                               <i class="icon icon-fvr"></i><em>0</em>
                           </div>
                           <div class="mob-sub">{{ mb_substr($vo->Introduce, 0, 40, 'utf8') }}...</div>
                       </div>
                   </div>

               @endforeach
           @endif

{{--            <div class="mod-b mod-art mod-b-push ">
                 <a class="transition" href="#" target="_blank" title="弯道超车的大业，怎么能靠政策呢？">
                    <div class="mod-thumb ">
                         <img class="lazy" src="/huxiu/sy-img/104239030071.jpg" alt="弯道超车的大业，怎么能靠政策呢？">
                    </div>
                 </a>
                 <div class="column-link-box column-link-big-box">
                    <a href="#" class="column-link" target="_blank">车与出行</a>
                 </div>
                 <div class="mob-ctt">
                    <h2><a href="#" class="transition msubstr-row5" target="_blank">弯道超车的大业，怎么能靠政策呢？</a></h2>
                    <div class="mob-author">
                         <div class="author-face">
                              <a href="#" target="_blank"><img class="lazy" src="/huxiu/sy-img/default.jpg"></a>
                         </div>
                         <a href="#" target="_blank">
                              <span class="author-name">autocarweekly</span>
                         </a>
                         <a href="#" target="_blank"></a>
                         <span class="time">5小时前</span>
                    </div>
					<div class="mob-sub">希望变失望、机会变门槛、黄金变铁皮</div>
                </div>
            </div>--}}
            {{--广告标签--}}
            {{--<div class="mod-b mod-art promote">
                 <a href="#" target="_blank" title="">
                    <div class="mod-thumb">
                         <img class="lazy" src="/huxiu/sy-img/233950517521.jpg">
                    </div>
                 </a>
                 <div class="mob-ctt">
                      <a href="#" target="_blank">实体商业转型</a>
                      <span class="point">&bull;</span>
                      <a href="#" target="_blank">实体空间在召唤，他们押宝了零售业态转型升级</a>
                      <span class="span-mark-pro">推广</span>
                 </div>
            </div>--}}

		</div>
        <div class="get-mod-more js-get-mod-more-list transition" id="js-get-mod-more-list" data-cur_page="1" data-last_dateline="1504655833">
            点击加载更多
        </div>
        <script>
            $('#js-get-mod-more-list').click(function (obj) {
                var page = $(obj).atrr('data-cur_page');
                $.get("/article/append",{page:page},function(str) {
                    $('.mod-info-flow').append(str);
                    $("img.lazy").stop().lazyload({});
                },'');
            })
        </script>
	</div>
    <div class="wrap-right pull-right">

    {{--<div class="box-moder moder-project-list">--}}
        {{--<h3>创业白板</h3>--}}
        {{--<span class="pull-right project-more"><a href="#" class="transition" target="_blank">全部</a></span>--}}
        {{--<span class="span-mark"></span>--}}
        {{--<ul>--}}
            {{--<li>--}}
                {{--<div class="project-pic">--}}
                        {{--<img src="/huxiu/sy-img/1503478306719861.png">--}}
                {{--</div>--}}
                {{--<div class="project-content">--}}
                     {{--<div class="project-title">--}}
                         {{--<a href="#" class="transition" target="_blank">车悦宝</a>--}}
                     {{--</div>--}}
                     {{--<p>车载综合音频娱乐服务商</p>--}}
                 {{--</div>--}}
            {{--</li>--}}
         {{--</ul>--}}
        {{--<div class="project-btn-box">--}}
            {{--<a class="js-open-cy btn btn-blue-cy transition">立即报名，获得曝光机会！</a>--}}
        {{--</div>--}}
        {{--<ul class="project-info">--}}
            {{--<li>创业公司立即报名提交信息的好处：</li>--}}
            {{--<li>1.优质的展示和访谈机会</li>--}}
            {{--<li>2.获得投资人的关注</li>--}}
            {{--<li>3.虎嗅提供的创业支持服务</li>--}}
        {{--</ul>--}}
    {{--</div>--}}

<!--研究报告部分开始-->
    {{--<div class="placeholder"></div>--}}
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
    <div class="placeholder"></div>
</div>
</div>


@include('home.article.public.footer')

</body>

</html>
