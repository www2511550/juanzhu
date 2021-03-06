
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>找回密码|嘿淘</title>
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/reg.css">
</head>
<body>
<div class="tk-header">
	<div class="tk-header-top">
		<div class="page-all clearfix">
			专注单品、极致转化！ 
			<a href="http://user.taokemishu.com/Login" class="reg">[登陆]</a>
			<a href="http://user.taokemishu.com/Register" class="reg">[注册]</a>
			<a href="" class="fr">加入淘客秘书QQ群></a>
		</div>
	</div>
	<div class="page-all">
		<a class="tk-logo" href="http://www.taokemishu.com"><img src="http://g.ligoucdn.cn/taokemishu/1.0/img/reg/login_03.png"></a>
	</div>
</div>

<div class="change-pass page-all">
    <div class="pass-step">
        <ul class="clearfix">
            <li class="active"><span class="ico">1</span><div class="t">填写账户信息</div></li>
            <li class=""><span class="ico">2</span><div class="t">邮箱验证</div></li>
            <li class=""><span class="ico">3</span><div class="t">更改密码</div></li>
            <li class=""><span class="ico">4</span><div class="t">完成</div></li>
        </ul>
    </div>
    <form action="/Retrieve/checkaccount" method="post">
        <div class="form-group">
            <input required type="email" name="mail" placeholder="请输入您的注册邮箱"></input>
        </div>
        <div class="form-group verify">
            <input required name="verifyCode" placeholder="请输入右侧验证码"></input>
            <img id="verify_img" src="/Retrieve/findpassverify" />
            <a href="" id="verify_refresh" class="blue">换一张</a>
        </div>
        <div class="form-group">
            <button type="submit" class="login-sub">下一步</button>
        </div>
    </form>

</div>

<div class="tk-footer">
    <div class="page-all">
        <div class="footer-cont clearfix">
            <dl>
                <dt>帮助中心</dt>
                <dd><a href="">淘宝助手安装指南</a></dd>
            </dl>
            <dl>
                <dt>常见问题</dt>
                <dd><a href="">招商规则</a></dd>
                <dd><a href="">违规商家处罚</a></dd>
                <dd><a href="">商家如何报名</a></dd>
            </dl>
            <dl>
                <dt>投诉意见</dt>
                <dd><a href="">招商违规投诉</a></dd>
                <dd><a href="">应用建议</a></dd>
            </dl>
            <dl>
                <dt>关于我们</dt>
                <dd><a href="">关于我们</a></dd>
                <dd><a href="">联系我们</a></dd>
            </dl>
<!--            <dl>
              <!--   <dt class="Code-dt">关注我们</dt> -->
                <!-- <dd><img src="http://g.ligoucdn.cn/taokemishu/1.0/img/erwei_03.jpg"></dd>
                <dd><img src="http://g.ligoucdn.cn/taokemishu/1.0/img/news/erwei_06.png"></dd> -->
            </dl>-->
        </div>
    </div>
    <div class="icp-no">
        <span>© 2016 TAOKEMISHU.COM 渝ICP备14004621号-6</span>
		<!--<a href="http://www.anquan.org/authenticate/cert/?site=www.taokemishu.com&at=realname" rel="nofollow" target="_blank"><img src="http://g.ligoucdn.cn/taokemishu/1.0/img/reg/login_11.png" alt="" style="" /></a>-->
    </div>
	<script>
	var _hmt = _hmt || [];
	(function() {
	  var hm = document.createElement("script");
	  hm.src = "//hm.baidu.com/hm.js?dc95aa8b47d7f35ed5010d3ae94f2382";
	  var s = document.getElementsByTagName("script")[0]; 
	  s.parentNode.insertBefore(hm, s);
	})(); 
	</script>
</div>
</body>
</html>