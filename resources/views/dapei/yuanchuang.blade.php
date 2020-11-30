<!doctype html>
<html>
<head>

    @include('dapei.meta')

    <link href="{{ asset('blog/css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('blog/css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('blog/css/m.css') }}" rel="stylesheet">
    <script src="{{ asset('blog/js/jquery-2.1.1.min.js') }}"></script>
    <!--[if lt IE 9]>
    <script src="{{ asset('blog/js/modernizr.js') }}"></script>
    <![endif]-->
    <script>
        window.onload = function ()
        {
            var oH2 = document.getElementsByTagName("h2")[0];
            var oUl = document.getElementsByTagName("ul")[0];
            oH2.onclick = function ()
            {
                var style = oUl.style;
                style.display = style.display == "block" ? "none" : "block";
                oH2.className = style.display == "block" ? "open" : ""
            }
        }
    </script>
</head>
<body>

@include('dapei.menu')

<article>
    {{--<h1 class="t_nav"><a class="n1" style="width: 100%;">位置：首页 > {{$data->title}}</a></h1>--}}
    <div class="infos">
        <div class="newsview">
            <h3 class="news_title">{{$data->title}}</h3>
            <div class="news_author" style="margin-bottom: 20px;">
                <span class="au01">
                    {{--<a href="mailto:dancesmiling@qq.com">杨青</a>--}}
                </span>
                <span class="au02">{{date('Y-m-d', strtotime($data->created_at))}}</span><span class="au03">共<b><script
                                src=""></script>{{$data->browse_num}}</b>人围观</span>
            </div>
            {{--<div class="tags"><a href="" target="_blank">个人博客</a> &nbsp; <a href="" target="_blank">小世界</a></div>--}}

            {{--<div class="news_about"><strong>简介</strong>个人博客，用来做什么？我刚开始就把它当做一个我吐槽心情的地方，也就相当于一个网络记事本，写上一些关于自己生活工作中的小情小事，也会放上一些照片，音乐。每天工作回家后就能访问自己的网站，一边听着音乐，一边写写文章。--}}
            {{--</div>--}}

            <div class="news_infos">
                @foreach($data->content as $vo)

                    <p style="line-height: 30px;">{{ $vo['intro'] }}</p>
                    <p><img class="lazy" src="{{ asset('loading.png') }}" data-original="{{ $vo['cover'] }}" alt="{{ $vo['title'] }}"></p>
                    <p style="text-align: center;">
                        {{--<a href="{{ $dapei->quanUrl($vo) }}" style="color: #FF009E;font-size: 1.0rem">点我购买</a>--}}
                    </p>


                @endforeach
            </div>
        </div>
        <script>cambrian.render('tail')</script>
        <div class="share"> </div>
        <div class="nextinfo">
            @if($prePage->id)<p>上一篇：<a href="{{ route('dp.yc', ['id'=>$prePage->id]) }}">{{ $prePage->title }}</a></p>@endif
            @if($nextPage->id)<p>下一篇：<a href="{{ route('dp.yc', ['id'=>$nextPage->id]) }}">{{ $nextPage->title }}</a></p>@endif
        </div>


        {{--<div class="otherlink">--}}
        {{--<h2>相关文章</h2>--}}
        {{--<ul>--}}
        {{--<li><a href="/download/div/2018-04-22/815.html" title="html5个人博客模板《黑色格调》">html5个人博客模板《黑色格调》</a></li>--}}
        {{--</ul>--}}
        {{--</div>--}}

        <div class="news_pl">
            <h2>文章评论</h2>
            <ul>
                <div class="gbko"> </div>
            </ul>
        </div>
    </div>
    <div class="sidebar">
        <div class="search">
            <form action="/" method="get" name="searchform" id="searchform">
                <input name="keyword" id="keyboard" class="input_text" placeholder="请输入关键字" style="color: rgb(153, 153, 153);" onfocus="if(value=='请输入关键字'){this.style.color='#000';value=''}" onblur="if(value==''){this.style.color='#999';value='请输入关键字'}" type="text">
                <input class="input_submit" value="搜索" type="submit">
            </form>
        </div>

        {{--<div class="lmnav">--}}
        {{--<h2 class="hometitle">栏目导航</h2>--}}
        {{--<ul class="navbor">--}}
        {{--<li><a href="#">关于我</a></li>--}}
        {{--<li><a href="share.html">模板分享</a>--}}
        {{--<ul>--}}
        {{--<li><a href="list.html">个人博客模板</a></li>--}}
        {{--<li><a href="#">HTML5模板</a></li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</div>--}}


        <div class="paihang">
            <h2 class="hometitle">点击排行</h2>
            @include('money.public.recom', ['common'=>$hot])
        </div>


        <div class="cloud">
            <h2 class="hometitle">标签云</h2>
            <ul>
                @if($arrTag)
                    @foreach($arrTag as $name)
                        <a href="/cname/{{$name}}">{{$name}}</a>
                    @endforeach
                @endif
            </ul>
        </div>

        <div class="paihang">
            <h2 class="hometitle">站长推荐</h2>
            @include('money.public.recom', ['common'=>$recom])
        </div>

        {{--<div class="weixin">--}}
            {{--<h2 class="hometitle">官方微信</h2>--}}
            {{--<ul>--}}
                {{--<img src="/weizhuan.jpg">--}}
            {{--</ul>--}}
        {{--</div>--}}

        {{--<div class="ad" id="left_flow2">--}}
        {{--<img src="/weizhuan.jpg">--}}
        {{--</div>--}}
    </div>
</article>

@include('dapei.footer')

<script type="text/javascript">
    jQuery.noConflict();
    jQuery(function() {
        var elm = jQuery('#left_flow2');
        var startPos = jQuery(elm).offset().top;
        jQuery.event.add(window, "scroll", function() {
            var p = jQuery(window).scrollTop();
            jQuery(elm).css('position',((p) > startPos) ? 'fixed' : '');

            jQuery(elm).css('top',((p) > startPos) ? '0' : '');
        });
    });
</script>
</body>
</html>
