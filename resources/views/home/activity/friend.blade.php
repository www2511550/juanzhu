@include('home.activity.public._header')

    <style>
        *{padding: 0;margin: 0}
        a{text-decoration: none;}
        li{list-style: none}
        .top_box{width: 100%;height: 160px;}
        .box_out{ width: 100%;height: auto; background: url("/images/activity/friend/f_bg.png") repeat;padding-bottom: 30px;}
        .order_info{width: 100%;height: 420px;position: relative;}
        .p_title{
            position: absolute;top: 15px;left: 50%;margin-left: -80px;font-size: 18px;color: #fff;font-weight: 600;
        }
        .buy_red{
            position: absolute;top: 95px;left: 12%;font-size: 18px;color: #fd670d;font-weight: 600;
        }
        .buy_phone{
            position: absolute;top: 95px;left: 50%;font-size: 18px;color: #fd670d;font-weight: 600;
        }
        .f_num{
            position: absolute;top: 150px;left:50%;margin-left: -150px;font-size: 12px;color: #888;text-align: center;
        }
        .f_num>span{
            margin-right: 35px;
        }
        .button_check{
            width: 280px;height: 50px;position: absolute;top: 175px;left: 50%;margin-left: -140px;font-size: 18px;color: #fff;
        }
        .button_check>a.a_go{
            position: absolute;left: 50%;top: 10px;margin-left: -64px;
        }

        .intro{
            position: absolute;top: 255px;left: 50%;margin-left: -90px;font-size: 14px;color: #444;text-align: center;
        }
        .intro>p{line-height:25px;}
        .intro>p>a{color: #ff7e4f;font-size: 14px;}

        .button_get{
            width: 280px;height: 40px;position: absolute;top: 315px;left: 50%;margin-left: -140px;font-size: 14px;color: #fff;
        }
        .button_get>a.a_get{
            position: absolute;left: 50%;top: 10px;margin-left: -44px;
        }
        .bottom_out{
            width: 90%;height: 120px;font-size: 13px;color: #fff;background: url("/images/activity/friend/f_record.png") no-repeat;
            background-size: 100% 120px;margin-left: 5%;
        }
        .bottom_title{
            text-align: center;font-size: 14px;line-height: 35px;
        }
        .f_list{
            width: 86%;height: 65px;margin: 0 auto;color: #333333;font-size: 13px;overflow-y: scroll;padding: 5px 15px 0 5px;
        }
        .f_list>li{
            display: block;line-height: 30px;
        }
    </style>
</head>
<body>

<div class="top_box">
    <img src="/images/activity/friend/f_topbg.png" alt="" style="width: 100%;height: 160px;">
</div>


<div class="box_out">
    <div class="order_info">
        <img src="/images/activity/friend/f_info.png" alt="" style="width: 90%;height: 400px;margin-left: 5%">
        <p class="p_title">邀请越多，奖励越多</p>
        <img class="buy_red" src="/images/activity/friend/10.png" alt="" style="width: 60px;height: 50px;">
        <img class="buy_phone" src="/images/activity/friend/30.png" alt="" style="width: 60px;height: 50px;margin-left: -70px;">
        <img class="buy_phone" src="/images/activity/friend/50.png" alt="" style="width: 60px;height: 50px;margin-left: 13px;">
        <img class="buy_phone" src="/images/activity/friend/100.png" alt="" style="width: 60px;height: 50px;margin-left: 100px;">
        <div class="f_num">
            <span>{{ $reward['10'][1] }}个好友</span>
            <span>{{ $reward['30'][1] }}个好友</span>
            <span>{{ $reward['50'][1] }}个好友</span>
            <span>{{ $reward['100'][1] }}个好友</span>
        </div>
        <div class="intro">
            <p>已成功邀请<a href="">{{ intval($num['success']) }}</a>人</p>
            <p>再邀请<a href="">{{ intval($num['shengyu']) }}</a>人，即可获得<a href="">{{ intval($num['money']) }}</a>元话费</p>
        </div>
        <div class="button_check">
            <img src="/images/activity/friend/f_button.png" alt="" style="width: 280px;height: 50px;">
            <a class="a_go">邀请好友赢话费</a>
        </div>
        <div class="button_get">
            <img src="/images/activity/friend/f_get.png" alt="" style="width: 280px;height: 40px;">
            <a class="a_get">领取{{ intval($num['money']) }}元话费</a>
        </div>
    </div>

    <div class="bottom_out">
        <p class="bottom_title">我的邀请记录</p>
        <ul class="f_list">
         @if($friend)
             @foreach($friend as $vo)
                <li>
                    <span style="margin-right: 15px;">{{$vo['time']}}</span>
                    <img src="{{$vo['cover']}}" alt="" style="width: 20px;height: 20px;margin-right: 15px;">
                    <span>{{$vo['username']}}</span>
                    <span style="float: right">{{$vo['status']}}</span>
                </li>
             @endforeach
         @else


         @endif
        </ul>
    </div>

</div>

</body>
</html>