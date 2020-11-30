<!DOCTYPE html>
<!-- saved from url=(0080)./shopcar.html -->
<html class="hb-loaded"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>购物车</title>
    <link rel="stylesheet" type="text/css" href="./css/base.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
      <script src="./css/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
    	$(window).load(function(){
    		$(".loading").addClass("loader-chanage")
    		$(".loading").fadeOut(300)
    	})
    </script>
</head>

	<header class="page-header">
		<h3>购物车</h3>
	</header>
	
	<div class="contaniner fixed-contb">
		<section class="shopcar">
			<div class="shopcar-checkbox">
				<label for="shopcar" onselectstart="return false"></label>
				<input type="checkbox" id="shopcar">
			</div>
			<figure><img src="./css/shopcar-ph01.png"></figure>
			<dl>
				<dt>超级大品牌服装，现在买只要998</dt>
				<dd>颜色：经典绮丽款</dd>
				<dd>尺寸：L</dd>
				<div class="add">
					<span>-</span>
					<input type="text" value="3">
					<span>+</span>
				</div>
				<h3>￥653.00</h3>
				<small><img src="./css/shopcar-icon01.png"></small>
			</dl>
		</section>
		<!--去结算-->
		<div style="margin-bottom: 16%;"></div>
		
	</div>
	<script type="text/javascript">
		$(".shopcar-checkbox label").on('touchstart',function(){
			if($(this).hasClass('shopcar-checkd')){
				$(".shopcar-checkbox label").removeClass("shopcar-checkd")
			}else{
				$(".shopcar-checkbox label").addClass("shopcar-checkd")
			}
		})
	</script>
	<footer class="page-footer fixed-footer">
		<div class="shop-go">
			<b>合计：￥108.90</b>
			<span><a href="./buy.html">去结算（2）</a></span>
		</div>
		<ul>
			<li>
				<a href="./index.html">
					<img src="./css/footer001.png">
					<p>首页</p>
				</a>
			</li>
			<li>
				<a href="./assort.html">
					<img src="./css/footer002.png">
					<p>分类</p>
				</a>
			</li>
			<li class="active">
				<a href="./css/购物车.html">
					<img src="./css/footer03.png">
					<p>购物车</p>
				</a>
			</li>
			<li>
				<a href="./self.html">
					<img src="./css/footer004.png">
					<p>个人中心</p>
				</a>
			</li>
		</ul>
	</footer>
	
	

</body></html>