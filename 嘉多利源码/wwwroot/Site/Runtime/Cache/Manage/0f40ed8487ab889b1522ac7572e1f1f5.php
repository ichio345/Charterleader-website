<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>跳转提示</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo C('HTStyle');?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo C('HTStyle');?>/css/Common.css" type="text/css" />
	<script type="text/javascript" src="<?php echo C('HTStyle');?>/js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="<?php echo C('HTStyle');?>/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo C('HTStyle');?>/js/jquery-1.4.2.min.js"></script>
	<title>跳转提示</title>
</head>
<body>
<div class="system-message">
<?php
$html=<<<THINK
<h3 class="error"><span class="glyphicon glyphicon-remove"></span>{$error}</h3>
<div class="jump">
页面自动 <a id="href" href="{$jumpUrl}">跳转</a> 
等待时间： <b id="wait">{$waitSecond}</b>
</div>
THINK;
 echo $html; ?>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
</html>