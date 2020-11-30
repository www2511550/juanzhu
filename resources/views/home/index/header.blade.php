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