@include('home.center.header')

	<header class="top-header">
			<a class="icona" href="javascript:history.go(-1)">
					<img src="/wap/center/left.png">
				</a>
			<h3>我的资料</h3>
			<a class="iconb" href="./shopcar.html">
			</a>
	</header>
	
	<div class="contaniner">
		<ul class="self-data">
			<li>
				<a href="./datum.html#">
					<p>头像</p>
					<span><img src="/wap/center/right.png"></span>					
					<figure><img src="/wap/center/detail-tou.png"></figure>
				</a>
			</li>
			<li>
				<a href="./namechange.html">
					<p>昵称</p>
					<span><img src="/wap/center/right.png"></span>
					<small>{{ $_SESSION['username'] ? $_SESSION['username'] : '未登陆' }}</small>
					
				</a>
			</li>
			{{--<li>--}}
				{{--<a href="./datum.html#">--}}
					{{--<p>性别</p>--}}
					{{--<span><img src="/wap/center/right.png"></span>--}}
					{{--<select>--}}
						{{--<option>男</option>--}}
						{{--<option>女</option>--}}
					{{--</select>--}}
					{{----}}
				{{--</a>--}}
			{{--</li>--}}
		</ul>
	</div>
	
	
	
	


</body></html>