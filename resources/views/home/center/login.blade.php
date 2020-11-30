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
		<h3>登录</h3>
		<a class="text" href="/home/register">注册</a>
	</header>
	
	<div class="login">
		<form method="post">
			<ul>
				<li>
					<img src="/wap/center/login.png">
					<label>账号</label>
					<input type="text" placeholder="请输入账号" name="username" required minlength="5">
				</li>
				<li>
					<img src="/wap/center/password.png">
					<label>密码</label>
					<input type="password" placeholder="请输入密码" name="pwd"  required minlength="5">
				</li>
			</ul>
			<input type="submit" value="登录">
		</form>
	</div>

</body></html>