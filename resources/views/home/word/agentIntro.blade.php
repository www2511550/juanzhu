<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="Keywords" content="淘宝优惠券，天猫优惠券，优惠券折扣,9块9包邮,限时特卖,优品折扣,卷猪猪"/>
    <meta name="Description" content="优惠券折扣直播第一站！每天更新千款，纯人工筛选验货，限时限量特卖，全场1折包邮！"/>
    <title>
        代理权益
    </title>
    <style>
        *{padding: 0;margin: 0}
        .reward{
            width: 120px;height: 70px;position: absolute;right: 0px;bottom: 4%;
        }
        .bg{
            position: absolute;left: 0;top:0;right: 0;bottom: 0;background: #000000;opacity: 0.6;display: none;
        }
        .reward_into{
            width: 300px;height:530px;position: absolute;left: 50%;top: 50px;background: #fff;margin-left: -150px;
            border-radius: 3%;overflow: hidden;font-size: 14px;display: none;
        }
        .reward_into>h2{
            width: 100%;height: 50px;line-height: 50px;text-align: center;background: #ff6600;font-size: 18px;color: #fff;
        }
        .p_title{
            height: 40px;line-height: 40px;text-align: center;font-family: 'Microsoft YaHei', Tahoma, Helvetica, '\5B8B\4F53', sans-serif, \5b8b\4f53;
            font-weight: 700px;color: #ff6600;
        }
        .intro_ul{
            padding: 0 30px;
        }
        .intro_ul>li{
            list-style: none;tab-index: 2em;line-height: 22px;
        }
        .addAgent{
            position: absolute;bottom: 0px;left: 0px;height: 150px;width:100%;background: #fff;border-radius: 5px 5px 0 0;display: none;
        }
        .addAgent>p{
            text-align: center;
        }
        .p_199{
            display: inline-block;width: 80%;height: 40px;line-height: 40px;background: red;color: #fff;border: none;border-radius: 3%;margin-top: 10px;
        }
        .p_txt{
            width: 80%;height: 40px;line-height: 40px;border: 1px solid #d0c4c0;border-radius: 3%;margin-top: 10px;text-align: center;
        }
        p.add_ipt{
            width: 100%;height: 40px;line-height: 40px;color:#fff;background: red;position: absolute;bottom: 0;left: 0;font-size: 14px;
            text-align: center;
        }
    </style>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/clipboard.min.js') }}"></script>
</head>
<body>

<img src="/images/agentIntro.jpg" alt="代理权益" style="width: 100%;height: 95%;">


{{--奖励规则--}}
<sapn class="reward" onclick="rewardInfo()"></sapn>

{{--弹窗和说明--}}
<div class="bg" onclick="hideBg()"></div>
<div class="reward_into">
    <h2>奖励规则</h2>
    <p class="p_title">1、消费佣金</p>
    <ul class="intro_ul">
        <li>
            (1)、用卷猪APP分享商品给粉丝购买，
            <span style="color: #f60">微信，QQ，朋友圈，新浪微博等等</span>
        </li>
        <li>
            (2)、通过邀请码，让粉丝注册下载，
            <span style="color: #f60">粉丝在卷猪APP内省钱购物，你可以获取分享赚对应的佣金。</span>
            举例说明：如果分享的商品是<span style="color: #f60">100元</span>，
            APP内显示的佣金为30元，粉丝购买后，你可以获得
            <span style="color: #f60">30元</span>佣金奖励。
        </li>
    </ul>

    <p class="p_title">2、代理佣金</p>
    <ul class="intro_ul">
        <li>
            (1)、你直接发展一个付费代理【199元】，
            <span style="color: #f60">你获得【A级奖励】：</span>
            <span style="font-size: 18px;color: blue;font-weight: 700">90元</span>
            额外奖励：代理【A】+下级粉丝购物消费佣金的<span style="color: #f60">30%</span>。
        </li>
        <li>
            (2)、你的下级代理【A】发展代理【B】
            <span style="color: #f60">你获得【B级奖励】：</span>
            <span style="font-size: 18px;color: blue;font-weight: 700">30元</span>
        </li>
        <li style="margin-top: 15px;">
            <span style="color: #f60;font-size: 12px;">注：代理佣金：秒提秒到，消费佣金：每月23日提现（上月结算收入），奖励无封顶，多劳多得！</span>
        </li>
    </ul>
</div>

{{--加入代理--}}
<div class="addAgent">

    <p>
        <a class="p_199" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=2102576362&site=qq&menu=yes">199元年版会员</a>
    </p>
    {{--<p><input type="button" value="199元年版会员" class="p_199" href=""/></p>--}}
    <p><input type="text" placeholder="输入激活码试用3天会员" class="p_txt"></p>
</div>
<p class="add_ipt" onclick="addAgent(this)" user_id="{{intval($_GET['user_id'])}}">申 请</p>

<script>
    function rewardInfo(){
        $('.bg').stop().show();
        $('.reward_into').stop().show();
    }

    function hideBg(){
        $('.reward_into').stop().hide();
        $('.bg').stop().hide();
    }
    // 申请为代理
    function addAgent(obj) {
        var code = $('.p_txt').val();
        var user_id = $(obj).attr('user_id');
        if(code){
            if(!user_id){
                alert('请登录后在申请！');
            }else{
                $.post('/api/user/addAgent',{user_id:user_id,code:code},function (data) {
                    if(0==data.status){
                        alert(data.info);
                    }else{
                        $('.addAgent').hide();
                    }
                });
            }

        }else{
            $('.addAgent').stop().slideToggle();
        }

    }
</script>
</body>
</html>