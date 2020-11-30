<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>{{ $info['Title']? $info['Title'].'-淘宝天猫优惠券':'天猫优惠券|淘宝优惠券|天猫超市优惠券领取网站' }}</title>
    <meta name="keywords" content="天猫优惠券,淘宝优惠券,天猫超市优惠券,淘宝优惠券领取,淘宝领券,九块九包邮"/>
    <meta name="description" content="{{ ($info['Introduce']?$info['Introduce'].',' : '').'汇集独家特约【淘宝网2-5折优惠券】，以天天有九块九包邮超值宝贝著名。价格足够低，天猫优惠券天天有，先到先得。找独家淘宝天猫优惠券，请到卷猪折扣网。' }}
"/>
    <link rel="shortcut icon" type="image/ico" href="/images/favicon.ico">
    <link rel="bookmark" href="/images/favicon.ico"/>
    <link href="{{ asset('shop/common.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('shop/js/common.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.lazyload.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $("img.lazy").lazyload();
        });
    </script>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-1794081598161984",
            enable_page_level_ads: true
        });
    </script>
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?ed644c8dba9d7c42b3902ff7c0fcabb3";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</head>
<body>
<div class="header" id="header">
    <div class="header-bar">
        <i class="close"></i>
        <div class="wrapper">
            <p class="coll-desc">按<strong>Ctrl&nbsp;+&nbsp;D</strong>,
                将卷猪扣网放入收藏夹，优惠券信息一手掌握！
                <a href="http://shang.qq.com/wpa/qunwpa?idkey=96ff58f916630c9d6e6bff5e35bc574e8624c8c3617226f0c58f13e1e33800f3"
                   target="_blank" rel="nofollow" style="display: inline-block;float: right">
                    <img border="0" src="https://img.alicdn.com/imgextra/i1/2508158775/TB2SfmWqFXXXXb4XpXXXXXXXXXX_!!2508158775.png" _hover-ignore="1"
                         style="display: inline;margin-top: 6px;">
                    亲爱的，来加天猫内部福利QQ群
                </a>
            </p>
        </div>
    </div>
    <div class="header-top">
        <div class="wrapper">
            <a href="/" class="logo-area">
                <img class="logo" alt="卷猪折扣网"
                     src="/images/juanzhuzhu.gif">
            </a>
            <div class="slogan-area">
                <i class="slogan-icon cate-icon">&#xe608;</i>
                <p>正品好货</p>
                <i class="slogan-icon cate-icon">&#xe65f;</i>
                <p>人工精选</p>
                <i class="slogan-icon cate-icon">&#xe62a;</i>
                <p>内部领券</p>
                <i class="slogan-icon cate-icon">&#xe606;</i>
                <p>全场包邮</p>
            </div>
            <div class="search-area">
                <form name='soForm' action="/?" method="get">
                    <div class="input-area">
                        <i></i>
                        <input type="text" id="keyword" autocomplete="off"
                               onblur="this.value==''?this.value=this.title:null"
                               onfocus="this.value==this.title?this.value='':null"
                               placeholder="输入关键词" value="{{ $_GET['kw']?:'' }}" class="search-input" name="kw">
                    </div>
                    <a href="javascript:;" class="search-btn">搜索</a>
                </form>
            </div>
            <div id="suggest" class="suggest"></div>
        </div>
    </div>

    <div class="tab-area-plh">
        <div class="tab-area">
            <div class="wrapper">
                <div class="cate-area">
                    <a class="cate-item jxtj @if(!$mid) active @endif" href="/">
                        <span class="cate-rec">精选推荐</span>
                    </a>
                    <a href="/?mid=9.9" class="cate-item @if(9.9 == $mid) active @endif">
                        9块9包邮 </a>
                    <a href="/?mid=20" class="cate-item @if(20 == $mid) active @endif">
                        20元封顶 </a>
                    {{--<a href="?mid=history" class="cate-item @if('history' == $mid) active @endif">--}}
                    {{--我的足迹 </a>--}}
                    <a href="https://s.click.taobao.com/t?e=m%3D2%26s%3DsGgoG4KhcPwcQipKwQzePCperVdZeJviEViQ0P1Vf2kguMN8XjClAlYRAfdb0CFC6gUq%2Fu52mlsUdZLIHZkFnHDbvEPDBkeuKT3rxIdXzOhEx1%2BsBo2PHlW00662PG2K8Cm%2FwUl4ESHO54LQ%2FVw1L7SqdkxH6LRFnaYpFBIfC%2F2GLDgzy5xB4vAAWK8DkbyicBTsyoO7n4zT1Daj7d9z8OoPXyFbMSxd"
                       class="cate-item" target="_blank">支付抽免单 </a>
                    {{--<a href="/home/index/quan" class="cate-item " target="_blank">优惠直播 </a>--}}
                    <a href="//2dapei.com.cn" class="cate-item " target="_blank">爱搭配 </a>
                </div>
            </div>
        </div>
    </div>
</div>