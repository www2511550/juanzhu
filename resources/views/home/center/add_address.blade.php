<!DOCTYPE html>
<!-- saved from url=(0083)http://www.17sucai.com/preview/420849/2016-03-17/%E5%95%86%E5%9F%8E/go-address.html -->
<html class="hb-loaded"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>男装专区</title>
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
	<header class="top-header fixed-header">
		<a class="icona" href="javascript:history.go(-1)">
				<img src="./css/left.png">
			</a>
		<h3>男装专区</h3>
			
			<a class="text-top">
			</a>
	</header>
	
	<div class="contaniner fixed-conta">
		<form action="" method="post" class="change-address" id="save">
			<ul>
				<li>
					<label class="addd">收货人：</label>
					<input type="text" value="" required="required">
				</li>
				<li>
					<label class="addd">手机号：</label>
					<input type="tel" value="" required="required">
				</li>
				<li>
					<label class="addd">所在地区：</label>
					<select>
						<option>安徽省</option>
						<option>安徽省</option>
						<option>安徽省</option>
					</select>
					<select>
						<option>安徽省</option>
						<option>安徽省</option>
						<option>安徽省</option>
					</select>
					<select>
						<option>安徽省</option>
						<option>安徽省</option>
						<option>安徽省</option>
					</select>
				</li>
				<li>
					<label class="addd">详细地址：</label>
					<textarea required="required"></textarea>
				</li>
			</ul>
			
			<ul>
				<li class="checkboxa">
					<input type="checkbox" id="check">
					<label class="check" for="check" onselectstart="return false">设置为默认地址</label>
				</li>
			</ul>
			<ul>
				<li>
					<h3>删除此地址</h3>
				</li>
			</ul>
			<input type="submit" value="保存">
		</form>
	</div>
	
	<script src="./css/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		$(".checkboxa label").on('touchstart',function(){
			if($(this).hasClass('checkd')){
				$(".checkboxa label").removeClass("checkd");
			}else{
				$(".checkboxa label").addClass("checkd");
			}
		})
	</script>
	

</body></html>