<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>新浪微博V2接口演示程序-Powered by Sina App Engine</title>
</head>

<body>
<?=$user_message['screen_name']?>,您好！
<h2 align="left">发送新微博</h2>
<form action="" >
    <input type="text" name="text" style="width:300px" />
    <input type="submit" />
</form>

<?php if( is_array( $ms['statuses'] ) ): ?>
<?php foreach( $ms['statuses'] as $item ): ?>
<div style="padding:10px;margin:5px;border:1px solid #ccc">
    <?=$item['text'];?>
</div>
<?php endforeach; ?>
<?php endif; ?>

</body>
</html>