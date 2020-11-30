@include('home.center.header')

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

	<header class="top-header">
		<a class="text texta" href="/">取消</a>
		<h3>注册</h3>
		<a class="text" href="/home/login">登录</a>
	</header>
	
	<div class="login">
		<form action="" method="post">
			
			<ul>
				<li>
					<img src="/wap/center/login.png">
					<label>账号</label>
					<input type="text" placeholder="请输入账号" name="username"  required minlength="5">
				</li>
				<li>
					<img src="/wap/center/password.png">
					<label>密码</label>
					<input type="password" placeholder="请输入密码" name="pwd" required minlength="5">
				</li>
				<li>
					<img src="/wap/center/password.png">
					<label>密码</label>
					<input type="password" placeholder="请确认密码" name="password" required minlength="5">
				</li>
			</ul>
			<input type="submit" value="立即注册">
		</form>
	</div>


</body></html>