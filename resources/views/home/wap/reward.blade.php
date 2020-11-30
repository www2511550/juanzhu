<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我要中奖</title>

    <link href="{{ asset('reward_wap/style.css') }}" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="{{ asset('reward_wap/js/jquery-1.10.2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('reward_wap/js/awardRotate.js') }}"></script>

    <script type="text/javascript">
        var turnplate={
            restaraunts:[],				//大转盘奖品名称
            colors:[],					//大转盘奖品区块对应背景颜色
            outsideRadius:192,			//大转盘外圆的半径
            textRadius:155,				//大转盘奖品位置距离圆心的距离
            insideRadius:68,			//大转盘内圆的半径
            startAngle:0,				//开始角度

            bRotate:false				//false:停止;ture:旋转
        };

        $(document).ready(function(){
            //动态添加大转盘的奖品与奖品区域背景颜色
            turnplate.restaraunts = ["谢谢参与", "0.88|好运奖", "1.66|幸运奖", "6.6|参与奖", "8.8|安慰奖 ", "10圆|免单", "168|免单礼包", "666|脱非包"];
//	turnplate.restaraunts = ["50M免费流量包", "10闪币", "谢谢参与", "5闪币", "10M免费流量包", "20M免费流量包", "20闪币 ", "30M免费流量包", "100M免费流量包", "2闪币"];
//	turnplate.colors = ["#FFF4D6", "#FFFFFF", "#FFF4D6", "#FFFFFF","#FFF4D6", "#FFFFFF", "#FFF4D6", "#FFFFFF","#FFF4D6", "#FFFFFF"];
            turnplate.colors = ["#FFF4D6", "#FFFFFF","#FFF4D6", "#FFFFFF", "#FFF4D6", "#FFFFFF","#FFF4D6", "#FFFFFF"];


            var rotateTimeOut = function (){
                $('#wheelcanvas').rotate({
                    angle:0,
                    animateTo:2160,
                    duration:8000,
                    callback:function (){
                        alert('网络超时，请检查您的网络设置！');
                    }
                });
            };

            //旋转转盘 item:奖品位置; txt：提示语;
            var rotateFn = function (item, txt){
                var angles = item * (360 / turnplate.restaraunts.length) - (360 / (turnplate.restaraunts.length*2));
                if(angles<270){
                    angles = 270 - angles;
                }else{
                    angles = 360 - angles + 270;
                }
                $('#wheelcanvas').stopRotate();
                $('#wheelcanvas').rotate({
                    angle:0,
                    animateTo:angles+1800,
                    duration:8000,
                    callback:function (){
                        alert(txt);
                        turnplate.bRotate = !turnplate.bRotate;
                    }
                });
            };

            $('#pointer').click(function (){
                if(turnplate.bRotate)return;
                // 查看是否输入订单号
                var order_num = $('.order_num').val();
                if ( !$.trim(order_num) ) {
                    alert('订单号不能为空！');return;
                };
                $.post("/home/wap/toReward",{order_num:order_num},function(data){
                    if ( data.status == 0 ) {
                        alert(data.msg);return;
                    }else{
                        turnplate.bRotate = !turnplate.bRotate;
                        var item = data.yes_num;
                        //奖品数量等于10,指针落在对应奖品区域的中心角度[252, 216, 180, 144, 108, 72, 36, 360, 324, 288]
                        rotateFn(item, turnplate.restaraunts[item-1]);
//		switch (item) {
//			case 1:
//				rotateFn(252, turnplate.restaraunts[0]);
//				break;
//			case 2:
//				rotateFn(216, turnplate.restaraunts[1]);
//				break;
//			case 3:
//				rotateFn(180, turnplate.restaraunts[2]);
//				break;
//			case 4:
//				rotateFn(144, turnplate.restaraunts[3]);
//				break;
//			case 5:
//				rotateFn(108, turnplate.restaraunts[4]);
//				break;
//			case 6:
//				rotateFn(72, turnplate.restaraunts[5]);
//				break;
//			case 7:
//				rotateFn(36, turnplate.restaraunts[6]);
//				break;
//			case 8:
//				rotateFn(360, turnplate.restaraunts[7]);
//				break;
//			case 9:
//				rotateFn(324, turnplate.restaraunts[8]);
//				break;
//			case 10:
//				rotateFn(288, turnplate.restaraunts[9]);
//				break;
//		}

                    }
                })

            });
        });


        //页面所有元素加载完毕后执行drawRouletteWheel()方法对转盘进行渲染
        window.onload=function(){
            drawRouletteWheel();
        };

        function drawRouletteWheel() {
            var canvas = document.getElementById("wheelcanvas");
            if (canvas.getContext) {
                //根据奖品个数计算圆周角度
                var arc = Math.PI / (turnplate.restaraunts.length/2);
                var ctx = canvas.getContext("2d");
                //在给定矩形内清空一个矩形
                ctx.clearRect(0,0,422,422);
                //strokeStyle 属性设置或返回用于笔触的颜色、渐变或模式
                ctx.strokeStyle = "#FFBE04";
                //font 属性设置或返回画布上文本内容的当前字体属性
                ctx.font = '16px Microsoft YaHei';
                for(var i = 0; i < turnplate.restaraunts.length; i++) {
                    var angle = turnplate.startAngle + i * arc;
                    ctx.fillStyle = turnplate.colors[i];
                    ctx.beginPath();
                    //arc(x,y,r,起始角,结束角,绘制方向) 方法创建弧/曲线（用于创建圆或部分圆）
                    ctx.arc(211, 211, turnplate.outsideRadius, angle, angle + arc, false);
                    ctx.arc(211, 211, turnplate.insideRadius, angle + arc, angle, true);
                    ctx.stroke();
                    ctx.fill();
                    //锁画布(为了保存之前的画布状态)
                    ctx.save();

                    //----绘制奖品开始----
                    ctx.fillStyle = "#E5302F";
                    var text = turnplate.restaraunts[i];
                    var line_height = 17;
                    //translate方法重新映射画布上的 (0,0) 位置
                    ctx.translate(211 + Math.cos(angle + arc / 2) * turnplate.textRadius, 211 + Math.sin(angle + arc / 2) * turnplate.textRadius);

                    //rotate方法旋转当前的绘图
                    ctx.rotate(angle + arc / 2 + Math.PI / 2);

                    /** 下面代码根据奖品类型、奖品名称长度渲染不同效果，如字体、颜色、图片效果。(具体根据实际情况改变) **/
                    if(text.indexOf("|")>0){
                        //流量
                        var texts = text.split("|");
                        for(var j = 0; j<texts.length; j++){
                            ctx.font = j == 0?'bold 20px Microsoft YaHei':'16px Microsoft YaHei';
                            if(j == 0){
                                ctx.fillText(texts[j]+"", -ctx.measureText(texts[j]+"|").width / 2, j * line_height);
                            }else{
                                ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, j * line_height);
                            }
                        }
                    }else if(text.indexOf("|") == -1 && text.length>6){
                        //奖品名称长度超过一定范围
                        text = text.substring(0,6)+"||"+text.substring(6);
                        var texts = text.split("||");
                        for(var j = 0; j<texts.length; j++){
                            ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, j * line_height);
                        }
                    }else{
                        //在画布上绘制填色的文本。文本的默认颜色是黑色
                        //measureText()方法返回包含一个对象，该对象包含以像素计的指定字体宽度
                        ctx.fillText(text, -ctx.measureText(text).width / 2, 0);
                    }

                    //添加对应图标
                    if(text.indexOf("闪币")>0){
                        var img= document.getElementById("shan-img");
                        img.onload=function(){
                            ctx.drawImage(img,-15,10);
                        };
                        ctx.drawImage(img,-15,10);
                    }else if(text.indexOf("谢谢参与")>=0){
                        var img= document.getElementById("sorry-img");
                        img.onload=function(){
                            ctx.drawImage(img,-15,10);
                        };
                        ctx.drawImage(img,-15,10);
                    }
                    //把当前画布返回（调整）到上一个save()状态之前
                    ctx.restore();
                    //----绘制奖品结束----
                }
            }
        }

        function getIntro() {
            $('.intro').stop().slideToggle(300);
        }

    </script>
</head>
<body style="background:#e62d2d;overflow-x:hidden;">
<div class="intro" style="height: 350px;display: none" onclick="getIntro()">
    <img src="/reward_wap/images/step_1.png" alt="" width="47%" height="350" style="float: left;margin:0 2%">
    <img src="/reward_wap/images/step_2.png" alt="" width="47%" height="350" style="float: left">
</div>
<h3 style="text-align: center;margin-top: 20px;font-size: 15px;color: #fff;cursor:pointer;" onclick="getIntro()" >如何获取订单编号!</h3>
<p style="height: 30px;margin: 10px auto 50px;text-align: center">
    <input type="text"  style="width: 180px;line-height: 29px;" class="order_num" placeholder="请输入16位的订单编号!"><input type="button" value="抽奖"
                                                                                                                    style="height:35px;width:60px;background:#faf2cc;border:none;cursor:pointer;color:red;font-size:14px;" id="pointer">
</p>
<img src="/reward_wap/images/1.png" id="shan-img" style="display:none;" />
<img src="/reward_wap/images/2.png" id="sorry-img" style="display:none;" />
<div class="banner" style="max-width: 500px;">
    <div class="turnplate" style="background-image:url(/reward_wap/images/turnplate-bg.png);background-size:100% 100%;">
        <canvas class="item" id="wheelcanvas" width="422px" height="422px"></canvas>
        <img class="pointer" src="/reward_wap/images/turnplate-pointer.png"/>
    </div>
</div>

<div style="display:none">
    <script type="text/javascript">
        var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
        document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F6f798e51a1cd93937ee8293eece39b1a' type='text/javascript'%3E%3C/script%3E"));
    </script>
    <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
        document.write(unescape("%3Cspan id='cnzz_stat_icon_5718743'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s9.cnzz.com/stat.php%3Fid%3D5718743%26show%3Dpic2' type='text/javascript'%3E%3C/script%3E"));</script>
</div>


@include('home.wap.footer')
<link rel="stylesheet" href="{{ asset('wap/css/index.css') }}">
</body>
</html>