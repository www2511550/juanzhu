@include('home.center.header')

	<header class="top-header fixed-header">
		<a class="icona" href="javascript:history.go(-1)">
				<img src="/wap/center/left.png">
			</a>
		<h3>我的积分</h3>
			
			<a class="iconb" href="http://www.17sucai.com/preview/420849/2016-03-17/%E5%95%86%E5%9F%8E/shopcar.html">
			</a>
	</header>
	
	<div class="contaniner fixed-conta">
		<section class="integral">
			<h3>{{ $total_score }}</h3>

		@foreach($data as $vo)
			<dl>
				<dd>
					<p>{{ $vo['title'] }}</p>
					<time>{{ $vo['time'] }}</time>
				</dd>
				<dt>{{ $vo['score'] }}</dt>
			</dl>
		@endforeach

		</section>
	</div>
	
	
	
	


</body></html>