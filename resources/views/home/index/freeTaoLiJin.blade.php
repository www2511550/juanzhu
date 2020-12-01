
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

<title>淘礼金免单采集网-首发0元购免单采集平台</title>
<meta name="keywords" content="淘礼金,淘礼金免单,0元购,免单采集网,免单采集平台,免单网,淘礼金采集软件,淘礼金领取平台,首单礼金红包,首单抵扣商品" />
<meta name="description" content="淘礼金免单采集网汇集全网QQ、微信群免单商品，首发0元购商品千万淘礼金免单商品每天更新,关注本网站获取更多优惠福利！" />

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
    .layui-timeline-item{
        border-bottom: 1px solid #e6e6e6;
        margin: 10px 0;
    }
</style>

<div class="page_title">淘礼金免单采集网-首发0元购免单</div>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
    <blockquote class="site-text layui-elem-quote">
        淘礼金免单采集网汇集全网QQ、微信群免单商品，首发0元购商品千万淘礼金免单商品每天更新,关注本网站获取更多优惠福利！
        <br>
    </blockquote>
    <blockquote class="site-text layui-elem-quote">
        1、按文案教程下单,领券后显示非0-0.2元请勿下单!
        <br>
        2、商家亏本贴钱,收货后请及时确认收货并五星好评!
        <br>
        3、恶意差评者提交全网黑名单,严重者提交公安机关.
        <!--        <br>-->
        <!--        4、<font style=" color:#0000FF">淘礼金官方采集群：</font><a href="https://jq.qq.com/?_wv=1027&k=B0zkNrcf" target="_blank">3066310<img src="https://ae01.alicdn.com/kf/Hc951ac31f3144dba9d3287f7ac17da49O.png" alt="淘礼金免单采集群"></a></font>-->
        <br>
        4、<font style=" color:#0000FF">官方优惠券网站：</font><a href="http://juanzhuzhu.com" target="_blank">juanzhuzhu.com<alt="官方优惠券网站"></a></font>
        <br>
        5、复制淘口令可以转发文案和口令给朋友.
        <br>
    </blockquote>
</fieldset>


<div id="app">
    <ul class="layui-timeline">
        <li class="layui-timeline-item" v-for="(item,index) in data"><i class="layui-icon layui-timeline-axis"></i>
            <div class="layui-timeline-content layui-text"><i class="layui-icon"></i> 发布时间：item.uploadtime*1000|dataFormat("yyyy-MM-dd hh:mm:ss")<br />
            <!--                <i class="layui-icon"></i> 礼金内容： <a target="_blank" v-bind:href="item.url">淘礼金首发Q群：3066310>>>>>item.text</a><br />-->
                <i class="layui-icon"></i> 礼金内容： <a target="_blank" v-bind:href="item.url">>>>item.tkl</a><br />
                <i class="layui-icon"></i> 淘口令：item.tkl<br />
                <a class="copycontent" href="javascript:;" style="color:#FF0000" v-bind:data-clipboard-text="item.tkl"><i class="layui-icon"></i> 点击复制淘口令 </a><br />
                <a class="copycontent" href="javascript:;" style="color:#0000FF" v-bind:data-clipboard-text="item.url"><i class="layui-icon"></i> 点击复制淘礼金链接 </a></div>
        </li>
    </ul>
</div>

</body>
<script>
    var vm = new Vue({
        el: '#app',
        data: {
            data: [1]
        },
        computed: {},
        methods: {
            getdata() {
                var vm = this
                $.get("http://dwz.2xb.cn/web_api/yuyuzhe/getdata.php", function(evt) {
                    var received_msg = evt.data;
                    // thedata = (new Function("", "return " + received_msg))().data;
                    vm.data = received_msg;
                }, 'json');
            },
        },
        mounted() {
            setInterval(this.getdata, 1000);
        }
    })

    var clipboard = new ClipboardJS('.copycontent');
    clipboard.on('success',
        function (e) {
            layui.use('layer', function () {
                var layer = layui.layer;
                layer.msg('复制成功,直接打开淘宝即可领取');
            });
            $('#clickGotaobao>p').trigger('click');
        });
    clipboard.on('error', function (e) {
        console.log(e);
    });

    Vue.filter('dataFormat', function(value, fmt) {
        let getDate = new Date(value);
        let o = {
            'M+': getDate.getMonth() + 1,
            'd+': getDate.getDate(),
            'h+': getDate.getHours(),
            'm+': getDate.getMinutes(),
            's+': getDate.getSeconds(),
            'q+': Math.floor((getDate.getMonth() + 3) / 3),
            'S': getDate.getMilliseconds()
        };
        if (/(y+)/.test(fmt)) {
            fmt = fmt.replace(RegExp.$1, (getDate.getFullYear() + '').substr(4 - RegExp.$1.length))
        }
        for (let k in o) {
            if (new RegExp('(' + k + ')').test(fmt)) {
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length === 1) ? (o[k]) : (('00' + o[k]).substr(('' + o[k]).length)))
            }
        }
        return fmt;
    });

    //alert('本网站自动监控全网淘礼金\r有新淘礼金页面自动刷新\r【下单价格大于1元请勿拍下】');
</script>
<center>
    <a href="" title="©淘礼金免单采集网" >©淘礼金免单采集网</a>
</center>
</html>