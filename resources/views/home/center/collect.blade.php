<!DOCTYPE html>
<!-- saved from url=(0082)./mycollect.html -->
<html class="hb-loaded"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>男装专区</title>
    <link rel="stylesheet" type="text/css" href="./css/base.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
      <script src="./css/jquery.min.js" type="text/javascript" charset="utf-8"></script>
      <script type="text/javascript" src="./css/jaliswall.js"></script>
    <script type="text/javascript">
    	$(window).load(function(){
    		$(".loading").addClass("loader-chanage")
    		$(".loading").fadeOut(300);
    		$('.wall').jaliswall({ item: '.pic' });
    		
    		$(".text-top").on("touchstart",function(){
    			$(".collectbar").fadeToggle(500);
    		});
    		
    	})
    	
    	
    	function mycheck(val)
		{
			if($("#collect"+val).is(':checked'))
			{
				$(".label"+val).addClass("collectd");
				$(".collectbox").fadeIn(300)
				$(".kong").fadeIn()
			}
			else
			{
				$(".label"+val).removeClass("collectd");
				$(".collectbox").fadeOut(300)
				$(".kong").fadeOut()
			}
		}
    	
    </script>
</head>
<!--loading页开始-->
<body huaban_collector_injected="true"><div class="loading loader-chanage" style="display: none;">
	<div class="loader">
        <div class="loader-inner pacman">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
	</div>
</div>
<!--loading页结束-->

	<header class="top-header fixed-header">
		<a class="icona" href="javascript:history.go(-1)">
				<img src="./css/left.png">
			</a>
		<h3>我的收藏</h3>
			
			<a class="text-top">
				编辑
			</a>
	</header>
	
	<div class="contaniner fixed-conta">
		<div style="margin-top: 3%;"></div>
		<section class="list">
			<ul class="wall"><div class="wall-column"><div class="pic" id="">
					<a href="./detail.html">
						<img src="./css/list-ph01.png">
						<p>韩版青少年休闲修身长袖紧身衬衫</p>
						<b>￥58</b><del>￥538</del>
						<div class="collectbar">
							<label for="collect1" onselectstart="return false" class="label1"></label>
							<input type="checkbox" onclick="mycheck(1)" id="collect1">
						</div>
					</a>
				</div><div class="pic" id="">
					<a href="./detail.html">
						<img src="./css/list-ph01.png">
						<p>韩版青少年休闲修身长袖紧身衬衫</p>
						<b>￥58</b><del>￥538</del>
						<div class="collectbar">
							<label class="label3" for="collect3" onclick="mycheck(3)" onselectstart="return false"></label>
							<input type="checkbox" id="collect3">
						</div>
					</a>
				</div></div><div class="wall-column"><div class="pic" id="">
					<a href="./detail.html">
						<img src="./css/list-ph02.png">
						<p>韩版青少年休闲修身长袖紧身衬衫</p>
						<b>￥58</b><del>￥538</del>
						<div class="collectbar">
							<label for="collect2" onselectstart="return false" class="label2"></label>
							<input type="checkbox" onclick="mycheck(2)" id="collect2">
						</div>
					</a>
				</div><div class="pic" id="">
					<a href="./detail.html">
						<img src="./css/list-ph02.png">
						<p>韩版青少年休闲修身长袖紧身衬衫</p>
						<b>￥58</b><del>￥538</del>
						<div class="collectbar">
							<label class="label4" for="collect4" onselectstart="return false"></label>
							<input type="checkbox" id="collect4" onclick="mycheck(4)">
						</div>
					</a>
				</div></div></ul>
		</section>
		<div class="kong" style="margin-bottom: 16%;"></div>
	</div>
	
<footer class="collectbox fixed-footer">
	
	<input type="button" value="确认删除">
</footer>

	
	

</body></html>