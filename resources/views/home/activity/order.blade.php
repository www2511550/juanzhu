@include('home.activity.public._header')


    <script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js"
            data-appid="appid" data-redirecturi="{{__ROOT__}}/home/activity/order?user_id=12"  charset="utf-8"></script>
    <style>
        *{padding: 0;margin: 0}
        a{text-decoration: none;}
        li{list-style: none}
        .top_box{width: 100%;height: 160px;position: relative}
        .btn_rule{
            position: absolute;right: 5px;top: 10px;width: 80px;height: 30px;
        }
        .rule_info{
            position: absolute;top: 45px;right:20px;width: 330px;height: 330px;background: #fff;z-index: 1000;border-radius: 5%;
            overflow: hidden;display: none;
        }
        .info_title{
            text-align: center;height: 50px;background: #ff6600;line-height: 50px;font-size: 16px;color: #fff;
        }
        .info_one{
            text-align: left;font-size: 14px;line-height: 27px;padding: 0 15px;
        }
        .box_out{width: 100%;height: auto; background: url("/images/activity/order_bg.png") repeat;}
        .order_info{width: 100%;height: 470px;position: relative;}
        .p_title{
            position: absolute;top: 85px;left: 50%;margin-left: -120px;font-size: 18px;color: #fd670d;font-weight: 600;
        }
        .buy_red{
            position: absolute;top: 145px;left: 50%;margin-left: -118px;font-size: 18px;color: #fd670d;font-weight: 600;
        }
        .buy_phone{
            position: absolute;top: 145px;left: 50%;margin-left: 30px;font-size: 18px;color: #fd670d;font-weight: 600;
        }
        .intro{
            position: absolute;top: 265px;left: 50%;margin-left: -90px;font-size: 14px;color: #444;
        }
        .intro>p{line-height:25px;}
        .intro>p>a{color: #ff7e4f;font-size: 14px;}
        .button_check{
            width: 250px;height: 80px;position: absolute;top: 365px;left: 50%;margin-left: -130px;font-size: 18px;color: #fff;text-indent: -15px;
            background: url("/images/activity/order_button.png") no-repeat;background-size: contain;text-align: center;line-height: 50px;
            z-index: 1000;
        }
        .bottom_out{
            width: 70%;height: 200px;font-size: 13px;color: #fff;margin-left: 8%;
        }
        .bottom_out>p{line-height: 25px;}
        .bottom_ul>li{line-height: 22px;}
    </style>
</head>
<body>

<div class="top_box">
    <img src="/images/activity/order_topbg.png" alt="" style="width: 100%;height: 160px;">
    <div class="btn_rule" onclick="showRule()">
        <div class="rule_info">
            <p class="info_title">活动规则</p>
            @if($rule)
                @foreach($rule as $k=>$r)
                    <p class="info_one" @if(0==$k) style="margin-top: 15px;" @endif>{{ $k+1 }}、{{ $r }}</p>
                @endforeach
            @endif
        </div>
    </div>
</div>


<div class="box_out">
    <div class="order_info">
        <img src="/images/activity/order_info.png" alt="" style="width: 90%;height: 450px;margin-left: 5%">
        <p class="p_title">恭喜你！获得现金话费大礼包</p>
        <img class="buy_red" src="/images/activity/buy_red.png" alt="" style="width: 100px;">
        <img class="buy_phone" src="/images/activity/buy_phone.png" alt="" style="width: 100px;">
        <div class="intro">
            <p>礼包已经放入你的QQ账户内。</p>
            <p>下载优劵APP，<a href="">QQ登录</a></p>
            <p><a href="">[首页>新人福利]</a>即可查看</p>
        </div>
        <div class="button_check" onclick="addFriend(this)" is_add="{{ intval($_GET['is_login_qq']) }}" user_id="{{ intval($_GET['user_id']) }}"
         data-code="{{$_GET['code']}}" data-state="{{$_GET['state']}}" down_url="">
            立即领取
        </div>
    </div>

    <div class="bottom_out">
        <p class="bottom_title">领取流程：</p>
        <ul class="bottom_ul">
            <li>1、点击“立即领取”，获得红包话费奖励</li>
            <li>2、进入优劵[APP-我的-登录-微信登录]</li>
            <li>3、按照奖励规则领取对应福利</li>
        </ul>
    </div>

</div>
<script>
    function showRule() {
        $('.rule_info').stop().slideToggle();
    }
    /**
     * 绑定邀请人
     */
    function addFriend(obj) {
        var down_url = $(obj).attr('down_url');
        if(down_url){
            window.location.href=down_url;return;
        }else{
            if (1 == $(obj).attr('is_add')){
                var user_id = $(obj).attr('user_id');
                var code = $(obj).attr('data-code');
                var state = $(obj).attr('data-state');

                $.post('/api/user/addFriend',{user_id:user_id,code:code,state:state}, function (data) {
                    if(0==data.status){
                        alert(data.info);
                    }else{
                        $(obj).text('前往查看');
                        $(obj).attr('is_add', 0);
                        $(obj).attr('down_url', data.down_url);
                    }
                }, 'JSON');
            }
        }
    }
</script>
</body>
</html>