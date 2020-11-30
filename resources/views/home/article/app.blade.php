<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>虎嗅网</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta name="renderer" content="webkit">
    <meta name="baidu-site-verification" content="R9XA5lWxu2" />
    <meta name="author" content="虎嗅网">
    <meta name="keywords" content="科技资讯,商业评论,明星公司,动态,宏观,趋势,创业,精选,有料,干货,有用,细节,内幕">
    <meta name="description" content="聚合优质的创新信息与人群，捕获精选|深度|犀利的商业科技资讯。在虎嗅，不错过互联网的每个重要时刻。">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/build.css">
    <link rel="stylesheet" type="text/css" href="css/ground.css">
    <link href="css/login.css" rel="stylesheet" type="text/css"/>
    <link href="css/zzsc.css" rel="stylesheet" type="text/css"/>
    <link href="css/dlzc.css" rel="stylesheet" type="text/css"/>
    <script language="javascript" type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script language="javascript" type="text/javascript" src="js/main.js"></script>
    <script language="javascript" type="text/javascript" src="js/popwin.js"></script> 
</head>

<body>
<header id="top" role="banner" class="transition">
<!--搜索弹窗 开始-->
<div class="box">
	<div class="box2">
		<div class="icon icon-search-close js-show-search-box"><a class="close"></a></div>
   	 	<div class="search-content overlay-dialog-animate">
        	<div class="search-input">
            	<form role="search" method="get" action="/search.html" onsubmit="return checkinput()">
                	<button type="submit"></button>
                	<input placeholder="请输入关键字" name="s" id="search-input">
                </form>
        	</div>
        	<div class="search-history hide" id="history">
            	<span>我的搜索历史</span>
            	<ul class="transition" id="history_ul">
                	<li class="transition"><a href="#">数码</a></li>
                	<li class="transition"><a href="#">科技</a></li>
                	<li class="transition"><a href="#">科技</a></li>
                	<li class="transition"><a href="#">互联网</a></li>
                	<li class="transition"><a href="#">汽车之家</a></li>
           	 	</ul>
            	<div class="pull-right empty-history js-empty-history">清空历史</div>
        	</div>
        	<div class="search-history search-hot">
            	<strong>热搜词</strong>
            	<div class="dh-seach">
					<a href="#">数码</a>
                	<a href="#">科技</a>
                	<a href="#">互联网</a>
                	<a href="#">汽车之家</a>
                	<a href="#">Uber</a>
                	<a href="#">支付宝</a>
                	<a href="#">大数据</a>
                	<a href="#">创业</a>
                	<a href="#">旅游</a>
                	<a href="#">美团</a>
                	<a href="#">社交</a>
                    </ul>
                </div>
        	</div>
    	</div>
	</div>
</div>
<!--搜索弹窗 结束-->
<script>
    function checkinput(){
        var input = $("#search-input").val();
        if(input ==  null || input == ''){
            return false;
        }
        return true;
    }
</script>
    <div class="container">
        <div class="navbar-header transition">
            <a href="#" title="首页"><img src="images/logo.jpg" alt="虎嗅网" title="首页" /></a>
        </div>
        <ul class="nav navbar-nav navbar-left" id="jsddm">
            <li class="nav-news js-show-menu">
               <a href="#">资讯 <span class="caret"></span></a>
				<ul>
					<li><a href="#" target="_blank">电商消费</a></li>
                    <li><a href="#" target="_blank">娱乐淘金</a></li>
                    <li><a href="#" target="_blank">雪花一代</a></li>
                    <li><a href="#" target="_blank">人工智能</a></li>
                    <li><a href="#" target="_blank">车与出行</a></li>
                    <li><a href="#" target="_blank">智能终端</a></li>
                    <li><a href="#" target="_blank">医疗健康</a></li>
                    <li><a href="#" target="_blank">金融地产</a></li>
                    <li><a href="#" target="_blank">企业服务</a></li>
                    <li><a href="#" target="_blank">创业维艰</a></li>
                    <li><a href="#" target="_blank">社交通讯</a></li>
                    <li><a href="#" target="_blank">全球热点</a></li>
                    <li><a href="#" target="_blank">生活腔调</a></li>
				</ul>
            </li>
            <style>
#jsddm ul{position: absolute; visibility: hidden; background:#fff; width:250px;  top:60px; left:-50px; z-index:9999; box-shadow:0 1px 15px rgba(18,21,21,.2);padding:10px 5px; }
#jsddm ul li{ float:left; width:105px; padding-left:20px; line-height:40px; background:#fff;}
</style>
            <li class="nav-news"><a href="#" target="_blank">热议<span class="nums-prompt nums-prompt-topic"></span></a></li>
            <li class="nav-news"><a href="#" target="_blank">活动</a></li>
            <li class="nav-news"><a href="#" target="_blank">创业白板<span class="nums-prompt"></span></a></li>
            <li class="nav-news"><a href="#" target="_blank">会员专享<em class="nums-prompt"></em></a></li>
            <li class="nav-news"><a href="#" target="_blank">官方Blog</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right transition  xiala main_nav">
            <li class="app-guide js-app-guide" >
                <div class="app-guide-box">
                    <img src="images/1448211685.png">
                    <div class="app-guide-title">
                        <span>微信扫一扫</span><br>
                        <span>下载虎嗅APP</span>
                    </div>
                </div>
                <i class="icon icon-sm-phone"></i>APP下载<em class="guide-prompt"></em>
            </li>
            <li class="search-li js-show-search-box"><a><i class="icon icon-search "></i></a><span>搜索</span></li>
            <li class="login-link-box"><a class="cd-signin">登录</a></li>
            <li ><a class="cd-signup" >注册</a></li>
            <li><a class="cd-tougao">投稿</a></li>
        </ul>
    </div>
<div class="cd-user-modal"> 
	<div class="cd-user-modal-container">
		<div id="cd-login"> <!-- 登录表单 -->
			<div class="modal-alert-title">登录虎嗅</div>
            <div class="register" >
				<div class="register-top" id="reg-top"><i><a id="qrcode" href="#"></a></i></div>
				<div class="register-con" id="rc">
                	<div class="login-form username-box " style="margin-top:52px;">
           				<a class="js-open-sms-login sms-text">短信快捷登录</a>
            			<label class="login-label transition" >
                			<input id="login_username" class="login-input" placeholder="手机号／邮箱／虎嗅账号">
            			</label>
            			<label class="login-label">
                			<input id="login_password" class="login-input password" type="password" placeholder="输入6～24位密码">
            			</label>
            			<a class="js-label-select label-select-box hide login-label-select text-center"><span class="js-country-user">+86</span><i class="icon-modal icon-l-caret"></i></a>
						<div class="login-operation">
                			<label><input id="autologin" type="checkbox">&nbsp;2周内自动登录</label>
               				<a href="/user/reset_password" class="js-forget-passward pull-right">忘记密码</a>
            			</div>
            			<button class="js-btn-login btn-login">登&nbsp;录</button>
        			</div>
        			<div class="js-open-register register-text">极速注册</div>
        			<div class="third-box">
            			<div class="title"><span>第三方登录</span></div>
            			<a href="#"><i class="icon-modal icon-login-qq"></i></a>
            			<a class="js-login-switch"><i class="icon-modal icon-login-wx"></i></a>
            			<a href="#"><i class="icon-modal icon-login-wb"></i></a>
            			<a href="#"><i class="icon-modal icon-login-zfb"></i></a>
        			</div>
    			</div>
            </div>
			<div class="saoma" id="sm">
				<div class="qr-code" style="text-align:center">
                    <div class="title">微信登录</div>
					<div class="waiting panelContent">
						<div class="wrp_code"><img class="qrcode lightBorder" src="images/150943753529.png"></div>
						<div class="info">
							<div class="status status_browser js_status" id="wx_default_tip">
			                	<p>请使用微信扫描二维码登录</p>
                            	<p>"虎嗅网"</p>
			           		 </div>
						</div>
					</div>
                 </div>
        		<div class="screen-tu" id="screen"></div>
			</div>
		</div>
    	<div id="cd-signup"> <!-- 注册表单 -->
			<div class="modal-alert-title">极速注册</div>
       	    <div class="user-register-box">
				<div class="login-form sms-box">
					<label class="login-label col-xs-label transition"><input id="sms_username" class="login-input username" placeholder="手机号"></label>
					<div class="geetest_login_sms_box" >
						<div id="geetest_1496454436837" class="gt_holder gt_float" style="touch-action: none;">
							<div class="gt_slider">
								<div class="gt_guide_tip gt_show">按住左边滑块，拖动完成上方拼图</div>
								<div class="gt_slider_knob gt_show" style="left: 0px;"></div>
								<div class="gt_curtain_knob gt_hide">移动到此开始验证</div>
								<div class="gt_ajax_tip gt_ready"></div>
							</div>
						</div>
					</div>
					<label class="login-label captcha"><input id="sms_captcha" class="login-input" placeholder="输入6位验证码" maxlength="6">
					<span class="js-btn-captcha btn-captcha">获取验证码</span></label>
					<a class="js-label-select label-select-box text-center"><span class="js-country-sms">+86</span><i class="icon-modal icon-l-caret"></i></a>
					<button class="js-btn-sms-login btn-login">注&nbsp;册</button>
				</div>
				<div class="js-user-login register-text">已有账号，立即登录</div></div>
    		</div>
			<a href="#0" class="cd-close-form ">关闭</a>
	</div>
</div>

<script src="js/d-login.js"></script>
<div id="cd-signup"> <!-- 注册表单 -->
	<div class="modal-alert-title">极速注册</div>
    <div class="user-register-box">
		<div class="login-form sms-box">
			<label class="login-label col-xs-label transition"><input id="sms_username" class="login-input username" placeholder="手机号"></label>
			<div class="geetest_login_sms_box" >
				<div id="geetest_1496454436837" class="gt_holder gt_float" style="touch-action: none;">
					<div class="gt_slider">
						<div class="gt_guide_tip gt_show">按住左边滑块，拖动完成上方拼图</div>
						<div class="gt_slider_knob gt_show" style="left: 0px;"></div>
						<div class="gt_curtain_knob gt_hide">移动到此开始验证</div>
						<div class="gt_ajax_tip gt_ready"></div>
					</div>
				</div>
			</div>
			<label class="login-label captcha"><input id="sms_captcha" class="login-input" placeholder="输入6位验证码" maxlength="6">
			<span class="js-btn-captcha btn-captcha">获取验证码</span></label>
			<a class="js-label-select label-select-box text-center"><span class="js-country-sms">+86</span><i class="icon-modal icon-l-caret"></i></a>
			<button class="js-btn-sms-login btn-login">注&nbsp;册</button>
		</div>
		<div class="js-user-login register-text">已有账号，立即登录</div>
    </div>
</div>
</header>
<div class="placeholder-height"></div>
<div class="ground-banner">
    <div class="container ground-container">
        <div class="app-vip-logo-box">
            <img class="app-vip-logo" src="images/v_logo.png">
            <div class="app-vip-title app-vip-title1">聚合优质的</div>
            <div class="app-vip-title app-vip-title2">创新信息和人群</div>
        </div>
        <img class="pic-ground-box" src="images/vip_bg_pic.png">
        <div class="left-info">
            <div class="qr-pic-box">
                <a href="#" target="_blank" class="ios"><i class="app_icon app_ios"></i><br>iOS版</a>
                <a href="#" target="_blank" class="android"><i class="app_icon app_android"></i><br>Android版</a>
                <img class="app-qr-pic" src="images/150943753529.png">
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="product-introduce">
        <ul class="introduce-ul">
            <li>
                <a href="#" target="_blank" class="transition">
                    <i class="g_icon icon-article "></i>
                    <div class="name">资讯</div>
                    <p>有视角，个性化商业资讯<br>给你有价值的内容</p>
                </a>
            </li>
            <li>
                <a class="transition">
                    <i class="g_icon icon-hy"></i>
					<div class="name">视频</div>
                    <p>移动化短视频时代，虎嗅打造<br>全新形态的商业资讯</p>
                </a>
            </li>
            <li>
                <a href="#" target="_blank" class="transition">
                    <i class="g_icon icon-activity"></i>
					<div class="name">会员</div>
                    <p>专属内容服务，早知道一点<br>多知道一点</p>
                </a>
            </li>
            <li>
                <a href="#" target="_blank" class="transition">
                    <i class="g_icon icon-topic"></i>
                    <div class="name">活动</div>
                    <p>虎嗅网打造的品牌活动<br>&nbsp;聚合创新创业人群</p>
                </a>
            </li>
        </ul>
    </div>
</div>

<footer class="footer">
    <div class="modal-backdrop fade in js-modal-backdrop"></div>
    <div class="container copy-right">
        <div class="footer-tag-list">
            <a href="#" target="_blank" class="transition">关于我们</a>
            <a href="#" target="_blank" class="transition">加入我们</a>
            <a href="#" target="_blank" class="transition">合作伙伴</a>
            <a href="#" target="_blank" class="transition">广告及服务</a>
            <a href="#" target="_blank" class="transition">常见问题解答</a>
            <a href="#" target="_blank" class="transition">防网络诈骗专题</a>
        </div>
        <span>Copyright © <a href="#">虎嗅网</a> <a href="#" target="_blank">京ICP备12013432号-1</a>
            &nbsp;<a href="#" target="_blank"><i class="i-wj"></i>京公网安备 11010102001402号</a>&nbsp;&nbsp;&nbsp;<em class="bull-right">本站由</em><i class="icon-aliyun" style="width: 70px;background-size: 100%;left: 7px;"></i><em class="bull-em">提供计算与安全服务</em>
        </span>
        <div class="footer-icon-list pull-right">
            <ul class="Qr-codee">
                <a><li class="Qr-code-footer">
                    <div class="app-qrcode"><img src="images/weixin_erweima.png"></div>
                    <i class="icon icon-footer icon-footer-wx"></i>
                </li>
                </a>
                <a><li class="Qr-code-footer">
                	<div class="app-qrcode"><img src="images/app_erweima.png"></div>
                    <i class="icon icon-footer icon-footer-ios"></i>
                </li>
                </a>
                <a><li class="Qr-code-footer">
                    <div class="app-qrcode"><img src="images/app_erweima.png"></div>
                    <i class="icon icon-footer icon-footer-android"></i>
                </li>
                </a>
                <a href="#" target="_blank" title="虎嗅英文版">
                    <li><i class="icon icon-footer icon-footer-inter"></i></li>
                </a>
                <a href="#" target="_blank" title="虎嗅RSS订阅中心">
                    <li><i class="icon icon-footer icon-footer-rss"></i></li>
                </a>
            </ul>
        </div>
    </div>
<div id="moquu_wxin" class="moquu_wxin"><a href="javascript:void(0)"><div class="moquu_wxinh"></div></a></div>
<div id="moquu_wshare" class="moquu_wshare"><a href="javascript:void(0)"><div class="moquu_wshareh"></div></a></div>
</footer>
<script type="text/javascript" src="js/mouse.js"></script>
</body>
</html>