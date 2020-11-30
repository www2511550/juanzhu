@include('home.center.header')

	<header class="self-header">
		<figure><img src="/wap/center/self-tou.png"></figure>
		<dl>
			<dt>{{ $_COOKIE['username'] ? $_COOKIE['username'] : '未登陆' }}</dt>
			<dd>
				<img src="/wap/center/self-header.png">
				<span>5684</span>
				<span>购物大湿</span>
			</dd>
		</dl>
		<button>签到</button>
	</header>
	
	<div class="contaniner fixed-contb">
		<section class="self">
			<dl>
				<dt>
					{{--<a href="/home/center/order">--}}
					<a href="#">
						<img src="/wap/center/self-icon.png">
						<b>全部订单</b>
						<span><img src="/wap/center/right.png"></span>
					</a>
				</dt>
				{{--<dd>--}}
						{{--<ul>--}}
							{{--<li>--}}
								{{--<a href="./go-order.html">--}}
									{{--<img src="/wap/center/order-icon01.png">--}}
									{{--<p>待发货</p>--}}
								{{--</a>--}}
							{{--</li>--}}
							{{--<li>--}}
								{{--<a href="./go-order.html">--}}
									{{--<img src="/wap/center/order-icon03.png">--}}
									{{--<p>待付款</p>--}}
								{{--</a>--}}
							{{--</li>--}}
							{{--<li>--}}
								{{--<a href="./go-order.html">--}}
									{{--<img src="/wap/center/order-icon02.png">--}}
									{{--<p>待收货</p>--}}
								{{--</a>--}}
							{{--</li>--}}
							{{--<li>--}}
								{{--<a href="./go-assess.html">--}}
									{{--<img src="/wap/center/order-icon04.png">--}}
									{{--<p>待评价</p>--}}
								{{--</a>--}}
							{{--</li>--}}
						{{--</ul>--}}
				{{--</dd>--}}
			</dl>
			
			<ul class="self-icon">
				<li>
					<a href="/home/center/score">
						<img src="/wap/center/self-icon03.png">
						<p>我的积分</p>
						<span><img src="/wap/center/right.png"></span>
					</a>
				</li>
				<li>
					<a href="/home/center/info">
						<img src="/wap/center/self-icon01.png">
						<p>个人信息</p>
						<span><img src="/wap/center/right.png"></span>
					</a>
				</li>
				<li>
					<a href="/home/wap/shop?uid={{ getUserId() }}">
						<img src="/wap/center/self-icon02.png">
						<p>积分商城</p>
						<span><img src="/wap/center/right.png"></span>
					</a>
				</li>
				{{--<li>--}}
					{{--<a href="./addres.html">--}}
						{{--<img src="/wap/center/self-icon04.png">--}}
						{{--<p>地址管理</p>--}}
						{{--<span><img src="/wap/center/right.png"></span>--}}
					{{--</a>--}}
				{{--</li>--}}
			</ul>
			<ul class="self-icon">
				{{--<li>--}}
					{{--<a href="./none.html">--}}
						{{--<img src="/wap/center/self-icon05.png">--}}
						{{--<p>我的分销</p>--}}
						{{--<span><img src="/wap/center/right.png"></span>--}}
					{{--</a>--}}
				{{--</li>--}}
				<li>
					<a href="#">
						<img src="/wap/center/self-icon06.png">
						<p>邀请好友</p>
						<span><img src="/wap/center/right.png"></span>
					</a>
				</li>
				
			</ul>
			<a href="/home/out"><input type="button" value="退出"></a>
			
		</section>
		
		
	</div>

	@include('home.wap.footer')
	<link rel="stylesheet" href="{{ asset('wap/css/index.css') }}">

	{{--<footer class="page-footer fixed-footer">--}}
		{{--<ul>--}}
			{{--<li>--}}
				{{--<a href="./index.html">--}}
					{{--<img src="/wap/center/footer001.png">--}}
					{{--<p>首页</p>--}}
				{{--</a>--}}
			{{--</li>--}}
			{{--<li>--}}
				{{--<a href="./assort.html">--}}
					{{--<img src="/wap/center/footer002.png">--}}
					{{--<p>分类</p>--}}
				{{--</a>--}}
			{{--</li>--}}
			{{--<li>--}}
				{{--<a href="./shopcar.html">--}}
					{{--<img src="/wap/center/footer003.png">--}}
					{{--<p>购物车</p>--}}
				{{--</a>--}}
			{{--</li>--}}
			{{--<li class="active">--}}
				{{--<a href="/wap/center/个人中心.html">--}}
					{{--<img src="/wap/center/footer04.png">--}}
					{{--<p>个人中心</p>--}}
				{{--</a>--}}
			{{--</li>--}}
		{{--</ul>--}}
	{{--</footer>--}}
	
	

</body></html>