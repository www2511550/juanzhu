<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>个人中心-红包明细</title>
    <style>
        *{padding:0;margin:0;}
        a{text-decoration: none;}
        li{list-style: none;}
        .header{
            width:100%;height:160px;margin:0 auto;background: url('/wx/view/detail_bg.jpg');background-position: center;
        }
        .h_left{
            width:45%;height:auto;text-align:center;float:left;padding-top:20px;
        }
        .h_left>img{
            width:40%px;height:120px;border-radius:50%;overflow:hidden;border: 2px solid #fff;
        }
        .h_right{
            width:45%;height:auto;text-align:center;float:left;padding-top:20px;padding-right: 10%;
        }

        .box{
            width:100%;height:auto;margin:20px auto;
        }
        .b_title{
            font-size:1rem;line-height: 46px;padding-left: 5%;display: block;background: #fff;
        }
        .b_ul>li{
            height:30px;line-height:40px;font-size:14px;display: block;padding-left: 5%;background: #fff;
        }
        .b_ul>li>span{
            display:inline-block;
        }
        .s_time{
            color:#666;width:40%;text-algin:left;
        }
        .s_money{
            color:#000;font-weight:700;width:30%;text-algin:left;
        }
        .s_desc{
            color:#666;width:30%;text-algin:right;
        }

    </style>
</head>
<body style='background:#f6f6f6'>

<div class="header">

    <div class="h_left">
        <img src="{{ $info->headimgurl }}" alt="{{ $info->nickname }}">
    </div>

    <div class="h_right">
        <p style='margin-top:15px;'><b style="font-size:40px;color:#fff;"><span style='font-size:30px;padding-right:2px;'>¥</span>123.45</b></p>
        <p style='line-height:30px;font-size:14px;c'><a href="javascript:;" onclick="alert('亲，满20元才能提现哦！')" style='color:#f0f0f0;'>我要提现</a></p>
    </div>

</div>

<div class="box">
    <p class="b_title">红包明细</p>
    <ul class="b_ul">
        <li>
            <span class="s_time">{{ date('Y-m-d H:i') }}</span><span class="s_money">+100.10</span><span class="s_desc">新人福利</span>
        </li>
        <li>
            <span class="s_time">{{ date('Y-m-d H:i') }}</span><span class="s_money">+100.10</span><span class="s_desc">新人福利</span>
        </li>
        <li>
            <span class="s_time">{{ date('Y-m-d H:i') }}</span><span class="s_money">+100.10</span><span class="s_desc">新人福利</span>
        </li>
        <li>
            <span class="s_time">{{ date('Y-m-d H:i') }}</span><span class="s_money">+100.10</span><span class="s_desc">新人福利</span>
        </li>
    </ul>

</div>

</body>
</html>