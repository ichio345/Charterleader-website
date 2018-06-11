<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo C('HTStyle');?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo C('HTStyle');?>/css/Layout.css" type="text/css" />
	<script type="text/javascript" src="<?php echo C('HTStyle');?>/js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="<?php echo C('HTStyle');?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo C('HTStyle');?>/js/jquery-1.4.2.min.js"></script>
<script>
  var $jq= jQuery.noConflict(true);  
</script>
<script type="text/javascript" src="<?php echo C('HTStyle');?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo C('HTStyle');?>/js/default.js"></script>
	 <!--[if lt IE 9]>
      <script src="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/Common/Js/html5shiv.min.js"></script>
      <script src="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/Common/Js/respond.min.js"></script>
    <![endif]-->
     <script type="text/javascript" src="/Site/Common/Plug/layer/layer.js"></script>
	<title><?php echo ($htname); ?>-后台首页</title>
</head>
<body>
<div class="head">
	<div class="logo fl">
		<p style="padding-left:25px;margin:20px 0 5px;font-size:18px;color:#f8f8f8"><?php echo ($htname); ?>
		
		</p>
		<span style='padding-left:25px;font-size:15px;color:#999'><span class='glyphicon glyphicon-leaf' style='color:#7bc955'></span>&nbsp;&nbsp;网站管理系统</span>
	</div>
	<div class="userinfo fl">
		<div class="inlogin">
			<ul>
				<li>
					<span style="color:#c1bfbf">欢迎，</span>
					<font color="#fb9319"><?php echo (session('Uname')); ?></font> 
				</li>
				<li>
					<span style="color:#666464"><?php echo (session('Ustatus')); ?></span>  <?php if(session('Uname') !== "jsydl"){ ?><a href="<?php echo U('User/updata_admin',array('ID'=>$vo['ID']));?>"><font color="#fb9319">修改密码</font></a><?php }?>
				 	<a href="<?php echo U('User/userout');?>" style="margin-left:5px;color:#e4d207">退出</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="head_right fr">
		<div class="admin fl">
			<ul>
				<li><span class="h_ico" style="background-position:-5px -5px"></span><a href="<?php echo U("Index/index");?>">后台首页</a></li>
				<li>
					<span class="h_ico" style="background-position:-5px -30px"></span>
					<div class="btn-group admin_btn">
					    <?php echo ($_SESSION['lngname']); ?>
					    <span style="color:#ffea00" class="dropdown-toggle"  data-toggle="dropdown" aria-expanded="false"> 
					    	<span class="glyphicon glyphicon-triangle-bottom" style="margin-left:3px;cursor:pointer"></span>
					    </span>
					  <dl class="dropdown-menu btn_menu" role="menu">
					  <?php if(is_array($lang)): foreach($lang as $key=>$vo): ?><dd><a href="<?php echo U("Common/lang",array("edition"=>$vo['id']));?>"><?php echo ($vo["name"]); ?></a></dd><?php endforeach; endif; ?>
					  </dl>
					</div>
				</li>
			</ul>
		</div>
		<div class="home fl">
			<span></span><a href="<?php echo U('Home/Index/index');?>" target="_blank">网站首页</a>
		</div>			
	</div>		
</div>
<script type="text/javascript" src="<?php echo C('HTStyle');?>/js/jquery.SuperSlide.2.1.1.js"></script>
<div class="main">
	<div class="main_left fl" id="firstpane">
	<dl>
	<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(is_array($vo["child"])): foreach($vo["child"] as $key=>$kzq): ?><dt class="title menu_head">
					<span class="<?php echo ($kzq["name"]); ?>"></span><b><?php echo ($kzq["title"]); ?></b>
				</dt>
				<dd class="menu_body <?php if($kzq["name"] == $Think.CONTROLLER_NAME): ?>on<?php endif; ?>">
					<ul>
					<?php if(is_array($kzq["child"])): foreach($kzq["child"] as $key=>$ff): ?><li>
						<span class="list_ico"></span>
						<a <?php if($kzq["name"] == $Think.CONTROLLER_NAME): if($ff["name"] == $Think.ACTION_NAME): ?>class="on"<?php endif; endif; ?> href="/index.php/<?php echo ($vo["name"]); ?>/<?php echo ($kzq["name"]); ?>/<?php echo ($ff["name"]); ?>" ><?php echo ($ff["title"]); ?>
						</a>

						</li><?php endforeach; endif; ?>	
					</ul>
				</dd><?php endforeach; endif; endforeach; endif; else: echo "" ;endif; ?>
	</dl>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#firstpane dd.on").show();
	$("#firstpane .menu_head").click(function(){		
		$(this).addClass("current").next(".menu_body").slideToggle(50).siblings(".menu_body").slideUp("slow");
		$(this).siblings().removeClass("current");		
	});
});
</script>
	<div class="main_right">
	<div class="title"><span class="add"></span><strong>核心设置</strong></div>
		<div class="mrclass">		
			<div class="mrlist">
				<div class="slideTxtBox">
				<div class="hd">
					<ul>
						<li>核心设置</li>
					</ul>
				</div>
				<div class="bd">
					<ul>
						<form action="<?php echo U('System/hxset_form');?>" method="post">
						<li>
							<span class="mrtitle fl">语言版本：</span>
							<?php if(is_array($edition)): foreach($edition as $key=>$vo): ?><input type="checkbox"  <?php if($vo['start'] == 1): ?>checked="checked"<?php endif; ?> value="1" name="edition[<?php echo ($vo["id"]); ?>]">
							<?php echo ($vo["name"]); ?> &nbsp;<?php endforeach; endif; ?>	
						</li>
						<li>
							<span class="mrtitle fl">后台名:</span>
							<input type="text" class="mrinput" name="htname" value="<?php echo ($hxset["htname"]); ?>">
						</li>
						<li>
							<span class="mrtitle fl">网站地址:</span>
							<input type="text" class="mrinput" name="siteUrl" value="<?php echo ($hxset["siteUrl"]); ?>">
						</li>
						<li>
							<span class="mrtitle fl">模板风格：</span>
							<select name="systemp" class="mrselect">
								<?php if(is_array($filelist)): foreach($filelist as $key=>$file): ?><option value="<?php echo ($file); ?>" <?php if($file == $hxset['systemp']): ?>selected<?php endif; ?> >&nbsp;<?php echo ($file); ?></option><?php endforeach; endif; ?>
							</select>
						</li>
						
						<li>
							<span class="mrtitle fl">验证码字符：</span>
							<input type="text" class="mrinput" name="VLENTH" value="<?php echo C('VLENTH');?>">
						</li>
						<li>
							<span class="mrtitle fl">URL模式: </span>
							<input type="text" class="mrinput" name="URL_MODEL" value="<?php echo C('URL_MODEL');?>">
						</li>
						<li>
							<span class="mrtitle fl">产品分类深度:</span>
							<input type="text" class="mrinput" name="depth" value="<?php echo C('ClumnPath');?> ">
						</li>

						<li>
							<span class="mrtitle fl">水印:</span>
							
							开启&nbsp;&nbsp;<input type="radio" value="1" <?php if(C('IS_WATER')): ?>checked="checked"<?php endif; ?> name="is_water">&nbsp;&nbsp;
							关闭&nbsp;&nbsp;<input type="radio" <?php if( !C('IS_WATER')): ?>checked="checked"<?php endif; ?> value="0" name="is_water">
						</li>
						<input type="submit" value="提交" class="but">
						</form>
					</ul>
					

					
				</div>
				</div>

				<style type="text/css">
					/* 本例子css */
		.slideTxtBox{  border:1px solid #ddd; text-align:left; margin:40px; }
		.slideTxtBox .hd{ height:35px; line-height:35px; background:#f4f4f4; padding:0 10px 0 20px;   border-bottom:1px solid #ddd;  position:relative; }
		.slideTxtBox .hd ul{ float:left;  position:absolute; left:20px; top:-1px; height:32px; padding:0 !important;   }
		.slideTxtBox .hd ul li{ float:left; padding:0 15px; cursor:pointer;  }
		.slideTxtBox .hd ul li.on{ height:35px;  background:#fff; border:1px solid #ddd; border-bottom:2px solid #fff; }
		.slideTxtBox .bd ul{padding:20px 15px 10px;}

				</style>
				<script type="text/javascript">jQuery(".slideTxtBox").slide({trigger:"click"});</script>
			</div>
			
		</div>		
	</div>
	<div class="cl"></div>
</div>

</body>
</html>