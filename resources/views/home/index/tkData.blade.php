<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://www.layuicdn.com/layui/css/layui.css">
    <script src="https://www.layuicdn.com/layui/layui.js"></script>
    <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.bootcss.com/clipboard.js/2.0.4/clipboard.min.js"></script>
</head>

<title>大淘客、好单库商家列表</title>
<meta name="keywords" content="大淘客、好单库商家列表"/>
<meta name="description" content="大淘客、好单库商家列表"/>

</head>

<body>

<style>
    * {
        padding: 0;
        margin: 0;
    }
    .page_title {
        text-align: center;
        font-size: 34px;
        font-weight: 400;
        color: #009688;
        position: relative;
        top: 10px;
        left: 0px;
    }

    #app {
        margin: 0px 10px 0px 0px;
    }

    .layui-timeline-item {
        border-bottom: 1px solid #e6e6e6;
        margin: 10px 0;
    }
    .page {
        padding: 0 0 45px;
        padding-top:30px;
        *margin-top:50px;
        _margin-top:50px;
        clear: both;
        overflow: hidden;
        text-align: center;
    }
    .page div{margin: 0 auto;}
    .page li {
        display: inline-block;
    }

    .page a,.page span,.page i{
        background: #fff;
        border-right: 1px solid #e4e4e4;
        border-bottom: 1px solid #e4e4e4;
        height: 36px;
        line-height: 36px;
        display: inline-block;
        font-size: 18px;
        padding: 0 15px;
        vertical-align: middle;
        overflow: hidden;
    }
    .page span{color: #BBB;}
    .page a.pg-next{width:60px; border-radius:0 20px 20px 0;box-shadow:1px 1px 3px rgba(204, 204, 204, 0.7);}
    .page a.pg-next:hover{cursor:pointer;}
    .page span.pg-prev{color:#bbb; font-weight:normal; background:#fff;width:60px; border-radius: 20px 0 0 20px;box-shadow:1px 1px 3px rgba(204, 204, 204, 0.7);}
    .page span.pg-next{width:60px; border-radius:0 20px 20px 0;box-shadow: 2px 2px 3px #D0D0CD; background:#fff;  color:#bbb; font-weight:normal;}
    .page a.pg-prev{background:#FFFFFF;width:60px; border-radius: 20px 0 0 20px;box-shadow: 2px 2px 3px #D0D0CD;}
    .page .active span{background:#ff464e;
        color: #fff;
        text-decoration: none;}
    .page .disabled span {

        border: medium none;
        color: #BBB;
        font-weight: bold;
    }

    .page a:hover{
        text-decoration:none;
        color:#fff;
        background:#ff464e;
    }

    .page i{
        color: #919191
    }
</style>

<div class="page_title">大淘客、好单库商家列表</div>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
    <blockquote class="site-text layui-elem-quote">
        每天早上7点定时更新抓取大淘客、好单库商家联系方式
        <br>
    </blockquote>
</fieldset>

<div id="app">
    <ul class="layui-timeline">
        @foreach($data as $val)
        <li class="layui-timeline-item" v-for="(item,index) in data"><i class="layui-icon layui-timeline-axis"></i>
            <div class="layui-timeline-content layui-text">
                <img src="{{ $val->head_img }}" style="width: 35px;height: 35px;" alt="{{ $val->name }}"> <b>{{ $val->name }}</b><br/>
                <i class="layui-icon"></i>  <a target="_blank" v-bind:href="javascript:;">{{ $val->intro }}</a><br />
                <a class="copycontent" href="http://wpa.qq.com/msgrd?v=3&site=qq&menu=yes&uin={{ $val->qq }}" style="color:#0000FF" target="_blank"><i class="layui-icon"></i> 点我qq咨询商家 </a>
            </div>
        </li>
        @endforeach
    </ul>

    <div class="page">
        {{$data->links()}}
    </div>
</div>

</body>

<center>
    <a href="" title="©卷猪猪网">©卷猪猪网</a>
</center>
</html>