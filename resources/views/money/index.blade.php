<!doctype html>
<html>
<head>

    @include('money.public.meta')

    <link href="{{ asset('blog/css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('blog/css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('blog/css/m.css') }}" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="{{ asset('blog/js/modernizr.js')}}"></script>
    <![endif]-->
    <script>
        window.onload = function () {
            var oH2 = document.getElementsByTagName("h2")[0];
            var oUl = document.getElementsByTagName("ul")[0];
            oH2.onclick = function () {
                var style = oUl.style;
                style.display = style.display == "block" ? "none" : "block";
                oH2.className = style.display == "block" ? "open" : ""
            }
        }
    </script>
</head>
<body>


@include('money.public.menu')

{{--<div class="picshow">--}}
{{--<ul>--}}
{{--@for($i=0;$i<5;$i++)--}}
{{--<li><a href="/"><i><img src="https://gd4.alicdn.com/imgextra/i1/1899112318/TB27JIVacLJ8KJjy0FnXXcFDpXa_!!1899112318.jpg"></i>--}}
{{--<div class="font">--}}
{{--<h3>个人博客模板《早安》</h3>--}}
{{--</div>--}}
{{--</a>--}}
{{--</li>--}}
{{--@endfor--}}
{{--</ul>--}}
{{--</div>--}}

<article>
    <div class="blogs">

        @if($data)
            @foreach($data as $vo)
                <li>
                    @if($vo->cover)
                        <span class="blogpic">
                            <a target="_blank" href="{{ route('yangmao' == $vo->type ? 'yangmao.detail' : 'b.detail', ['id'=>$vo->id]) }}">
                                <img src="{{ $vo->cover }}">
                            </a>
                        </span>
                    @endif
                    <h3 class="blogtitle">
                        <a target="_blank" href="{{ route('yangmao' == $vo->type ? 'yangmao.detail' : 'b.detail', ['id'=>$vo->id]) }}">{{ $vo->title }}</a>
                    </h3>
                    <div class="bloginfo">
                        <p>{{ $vo->intro }}</p>
                    </div>
                    <div class="autor">
                        <span class="lm">
                            {{--<a href="/" title="CSS3|Html5" target="_blank" class="classname"></a>--}}
                        </span>
                        <span class="dtime">{{date('Y-m-d', strtotime($vo->created_at))}}</span>
                        @if($vo->browse_num)
                        <span class="viewnum">浏览（<a target="_blank" href="{{ route(('yangmao' == $vo->type ? 'yangmao.detail' : 'b.detail'), ['id'=>$vo->id]) }}">{{ $vo->browse_num }}</a>）</span>
                        @endif
                        <span class="readmore">
                            <a target="_blank" href="{{ route('yangmao' == $vo->type ? 'yangmao.detail' : 'b.detail', ['id'=>$vo->id]) }}">阅读原文</a>
                        </span>
                    </div>
                </li>
            @endforeach
        @endif
        <style>
            .pagination {
                display: block;
                margin: 0 auto;
                margin-left: 10%;
            }

            .pagination > li {
                display: inline-block;
                float: left;
            }
        </style>
        <div class="page">
            {{$data->links()}}
        </div>
    </div>


    <div class="sidebar">
        <div class="about">
            <div class="avatar"><img src="images/avatar.jpg" alt=""></div>
            <p class="abname">网赚博客</p>
            <p class="abposition">网赚，网上赚钱，网赚项目</p>
            <div class="abtext"> 网赚博客，一个收集和讲解网上赚钱方法的平台，网赚博客上所有分享的网赚方法均为免费！</div>
        </div>
        <div class="search">
            <form action="/">
            <input name="keyword"  id="bdcs"  class="input_text" placeholder="请输入关键字"
                   style="color: rgb(153, 153, 153);"
                   onfocus="if(value=='请输入关键字'){this.style.color='#000';value=''}"
                   onblur="if(value==''){this.style.color='#999';value='请输入关键字'}" type="text">
            <input class="input_submit"  type="submit">
            </form>
        </div>
        <div class="cloud">
            <h2 class="hometitle">标签云</h2>
            <ul>
                <a href="/">我要网赚</a>
                <a href="/?kw=网赚">网赚</a>
                <a href="/?kw=网上赚钱">网上赚钱</a>
                <a href="/xiangmu">网赚项目</a>
                <a href="/yangmao">薅羊毛</a>
            </ul>
        </div>
        <div class="paihang">
            <h2 class="hometitle">点击排行</h2>

            @include('money.public.recom', ['common'=>$hot])

        </div>
        <div class="paihang">
            <h2 class="hometitle">站长推荐</h2>

            @include('money.public.recom', ['common'=>$recom])

        </div>
        <div class="links">
            <h2 class="hometitle">友情链接</h2>
            <ul>
                <li><a href="http://www.juxiangyou.com/" target="_blank" title="游戏赚钱">游戏赚钱</a></li>
                <li><a href="http://www.49395.com/" target="_blank" title="手赚网">手赚网</a></li>
                <li><a href="http://www.cash28.com.cn/" target="_blank" title="网络赚钱">网络赚钱</a></li>
                <li><a href="http://www.cash28.com.cn/" target="_blank" title="网上赚钱">网上赚钱</a></li>
                <li><a href="http://www.43626.cn/" target="_blank" title="玩游戏赚钱">玩游戏赚钱</a></li>
                <li><a href="http://www.nbegame.com/" target="_blank" title="游戏工作室">游戏工作室</a></li>
                <li><a href="http://www.jianzhiwang.com.cn/" target="_blank">网上兼职</a></li>
                <li><a href="http://www.jianzhiwangzhan.com/" target="_blank">网上兼职网</a></li>
                <li><a href="http://vzhuan.cn/" target="_blank">网上赚钱</a></li>
                <li><a href="http://www.zywjw.com/" target="_blank">专业玩家</a></li>
                <li><a href="http://www.cashptc.cn/" target="_blank">网赚</a></li>
            </ul>
        </div>
        <div class="weixin">
            <h2 class="hometitle">官方微信</h2>
            <ul>
                <img src="/weizhuan.jpg">
            </ul>
        </div>
    </div>
</article>
<div class="blank"></div>

@include('money.public.footer')
</body>
</html>
