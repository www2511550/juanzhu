<!doctype html>
<html xmlns:wb="http://open.weibo.com/wb">
<head>

    @include('dapei.meta')

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
    <script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>


@include('dapei.menu')

@if(!(request()->route('name') || request()->get('keyword')))
<div class="picshow">
    <ul>
        <li style="width: 33%"><a href="{{ route('dp.detail', ['id'=>8]) }}"><i><img class="lazy" src="{{ asset('loading.png') }}"
                                                                                     data-original="https://img.alicdn.com/imgextra/i4/3584028603/TB29uRxwWmWBuNjy1XaXXXCbXXa_!!3584028603-0-item_pic.jpg"></i>
                <div class="font">
                    <h3>美丽蔻连体短裤女夏季2018新款韩版宽松学生高腰显瘦雪纺连衣裤子</h3>
                </div>
            </a>
        </li>
        <li style="width: 33%"><a href="{{ route('dp.detail', ['id'=>38]) }}"><i><img class="lazy" src="{{ asset('loading.png') }}"
                                                                                      data-original="https://img.alicdn.com/imgextra/i2/3109339571/TB2lVLHgyMnBKNjSZFoXXbOSFXa_!!3109339571-0-item_pic.jpg"></i>
                <div class="font">
                    <h3>优质面料，做工精致，简约时尚，露肩小心机显瘦连衣裙</h3>
                </div>
            </a>
        </li>
        <li style="width: 33%"><a href="{{ route('dp.detail', ['id'=>30]) }}"><i><img class="lazy" src="{{ asset('loading.png') }}"
                        data-original="https://img.alicdn.com/imgextra/i3/3109339571/TB2a6G.tuuSBuNjSsplXXbe8pXa_!!3109339571-0-item_pic.jpg"></i>
                <div class="font">
                    <h3>新款女装连衣裙，简约气质T恤，时尚减龄，提高时尚，随风律动，优雅随性，给您舒适惬意的穿衣感。</h3>
                </div>
            </a>
        </li>
    </ul>
    <wb:share-button appkey="2689312362" addition="simple" type="button" ralateUid="2807983484"></wb:share-button>
</div>
@endif

<article>
    <div class="blogs">

        @if($data)
            @foreach($data as $vo)
                <li>
                    @if($vo->cover)
                        @foreach($vo->getCover($vo, 'arr') as $key => $cover)
                        <span class="blogpic" @if($key==2) style="margin-right: 0;" @endif>
                            <a target="_blank" href="{{ route($_GET['yc'] ? 'dp.yc' : 'dp.detail', ['id'=>$vo->id]) }}">
                                <img class="lazy" src="{{ asset('loading.png') }}" data-original="{{ $cover }}">
                            </a>
                        </span>
                        @endforeach
                    @endif
                    <h3 class="blogtitle" style="display: block;float: left">
                        <a target="_blank" href="{{ route($_GET['yc'] ? 'dp.yc' : 'dp.detail', ['id'=>$vo->id]) }}">{{ $vo->title }}</a>
                    </h3>
                    {{--<div class="bloginfo">--}}
                        {{--<p>{{ $vo->intro }}</p>--}}
                    {{--</div>--}}
                    {{--<div class="autor">--}}
                        {{--<span class="lm">--}}
                            {{--<a href="/" title="CSS3|Html5" target="_blank" class="classname"></a>--}}
                        {{--</span>--}}
                        {{--<span class="dtime">{{date('Y-m-d', strtotime($vo->created_at))}}</span>--}}
                        {{--<span class="viewnum">浏览（<a target="_blank" href="{{ route('b.detail', ['id'=>$vo->id]) }}">{{ $vo->browse_num }}</a>）</span>--}}
                        {{--<span class="readmore">--}}
                            {{--<a target="_blank" href="{{ route('b.detail', ['id'=>$vo->id]) }}">阅读原文</a>--}}
                        {{--</span>--}}
                    {{--</div>--}}
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
            .pagination > li.active{
                background: #dedede;
                color: #fff;
            }
        </style>
        <div class="page">
            {{ $data ? $data->appends($_GET)->render() : ''}}
        </div>
    </div>


    <div class="sidebar">
        <div class="about">
            <div class="avatar"><img src="https://timg01.bdimg.com/timg?pacompress=&imgtype=1&sec=1439619614&autorotate=1&di=e6a72dcb23a4deb4940545d48b7056fa&quality=90&size=b100_100&cut_x=0&cut_y=0&cut_w=870&cut_h=895&src=http%3A%2F%2Ftimg01.bdimg.com%2Ftimg%3Fpacompress%26imgtype%3D1%26sec%3D1439619614%26autorotate%3D1%26di%3Dbff46ef9d18fc04a44f3258d65b4942b%26quality%3D90%26size%3Db870_10000%26src%3Dhttp%253A%252F%252Fpic.rmb.bdstatic.com%252F15310624022ee19c77ce27423e0b42fea129f46d9e.jpeg" alt=""></div>
            <p class="abname">爱搭配</p>
            <p class="abposition">穿衣搭配，搭配技巧，怎么搭配</p>
            <h1 class="abtext" style="font-size: 14px;">爱搭配网是一个收集穿搭衣服，学习穿衣搭配技巧，服装搭配指南的网站。</h1>
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
            @if($arrTag)
                @foreach($arrTag as $name)
                    <a href="{{ route('dp.cname', ['name'=>$name]) }}">{{$name}}</a>
                @endforeach
            @endif
            </ul>
        </div>
        <div class="paihang">
            <h2 class="hometitle">点击排行</h2>

            @include('dapei.recom', ['common'=>$hot])

        </div>
        <div class="paihang">
            <h2 class="hometitle">站长推荐</h2>

            @include('dapei.recom', ['common'=>$recom])

        </div>
        <div class="links">
            <h2 class="hometitle">友情链接</h2>
            <ul>
                <li><a href="http://juanzhuzhu.com" target="_blank" title="伊秀服饰网">卷猪折扣网</a></li>
                <li><a href="http://www.netnoease.com/" target="_blank" title="不新鲜毋宁死,不原创毋宁吃屎">网不易</a></li>
                <li><a href="http://mail.qq.com/" target="_blank" title="QQ邮箱">QQ邮箱</a></li>
                <li><a href="http://www.ladyband.com/" target="_blank" title="女人帮">女人帮</a></li>
                <li><a href="http://fashion.onlylady.com/" target="_blank" title="女人志服饰">女人志服饰</a></li>
                <li><a href="http://www.wmpic.me/" target="_blank" title="唯美图片">唯美图片</a></li>
                <li><a href="http://www.mihuwa.com/" target="_blank" title="迷糊娃">迷糊娃</a></li>
                <li><a href="http://www.71lady.com/" target="_blank" title="奇丽女性网">奇丽女性网</a></li>
                <li><a href="http://www.bianzhirensheng.com/" target="_blank" title="编织人生">编织人生</a></li>
                <li><a href="http://www.hers.com.cn/" target="_blank" title="hers女性网">hers女性网</a></li>
                <li><a href="http://clothing.lady8844.com/" target="_blank" title="爱美网服饰">爱美网服饰</a></li>
                <li><a href="http://www.meyol.com/" target="_blank" title="魅网女性">魅网女性</a></li>
                <li><a href="http://face.39.net/" target="_blank" title="39美容">39美容</a></li>
                <li><a href="http://vogue.moonbasa.com/" target="_blank" title="梦芭莎时尚网">梦芭莎时尚网</a></li>
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

@include('dapei.footer')
</body>
</html>
