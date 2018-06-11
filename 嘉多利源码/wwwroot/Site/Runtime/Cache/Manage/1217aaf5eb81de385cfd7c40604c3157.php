<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>会员登录</title>	
	<link rel="stylesheet" href="<?php echo C('HTStyle');?>/css/Layout.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo C('HTStyle');?>/css/bootstrap.min.css">
	<script type="text/javascript" src="<?php echo C('HTStyle');?>/js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="<?php echo C('HTStyle');?>/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/Site/Common/Plug/layer/layer.js"></script>
	 <!--[if lt IE 9]>
      <script src="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/Common/Js/js/html5shiv.min.js"></script>
      <script src="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/Common/Js/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login_bg">
	<div id="lg">
		<div class="login" >
			<div class="login_title">
				网站后台管理系统
				<span>
					<?php echo C('SYS_VERSION');?>
				</span>
			</div> 
			<form action="<?php echo U('User/login_form');?>" method="post" id="login">
				<ul>
					<li>
						<span>账　号：</span>
						<input type="text" name='username' placeholder="请输入用户名..." class='username text' />
					</li>
					<li>
						<span>密　码：</span>
						<input type="password" name="password" placeholder="请输入密码..." class='password text' />
					</li>
					<li>
						<span>验证码：</span>
						<input type="text" name="code" class='code text' placeholder="请输入验证码..." style="width:145px" />
						<img src="<?php echo U('code');?>" class='codeimg' >
					</li>
					<li style="padding-top:10px;"><input type="button" class="login-but" value="登录" /></li>
					<li><div class="ts"></div></li>
				</ul>
			</form>
			<script type="text/javascript">	
				var formsub=$('input.login-but')
				$(document).bind('keydown',function(e){
		   			var curKey = e.which; 
					if(curKey == 13){
						formsub.click();
					} 
		   		})
				formsub.bind('click',function(){
					var username=$('input.username').val();
					var password=$('input.password').val();
					var code=$('input.code').val();
					$.ajax({
					   type: "POST",
					   url: "<?php echo U('User/yzlogin');?>",
					   data: {'username':username,'password':password,'code':code},
					   success: function(msg){
					   	if(msg==1){
					   		$('form#login').submit();
					   	}else{
					   		$('div.ts').text(msg);
					   	}					   		
					   }
					});
				})
				
				

				// 点击随机产生验证码
				$(function(){
					var verifyimg = $(".codeimg").attr("src");
		            $(".codeimg").click(function(){
		                if( verifyimg.indexOf('?')>0){
		                    $(".codeimg").attr("src", verifyimg+'&random='+Math.random());
		                }else{
		                    $(".codeimg").attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
		                }
		            });
				});
				

				
			</script>
		</div>
		
	</div>

	<script type="text/javascript">
		//页面层-自定义
		layer.open({
			shade: false,
			title: false,
			closeBtn: false,
			type:1,
			area: ['580px'],
			skin:'skinbg',
		    content: $('#lg')
		});
	</script>
	<div class="copy">
		<p></p>
	</div>
</body>
</html>