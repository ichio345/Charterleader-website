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
<!-- 图片预览 -->
	<link rel="stylesheet" type="text/css" href="<?php echo C('HTStyle');?>/webuploader/webuploader.css">
<link rel="stylesheet" type="text/css" href="<?php echo C('HTStyle');?>/webuploader/webup-demo.css">
<script type="text/javascript" src="<?php echo C('HTStyle');?>/webuploader/webuploader.min.js"></script>

<!-- 如果要单独的修改配置  需再次引入 upcon.js 文件 -->
<script type="text/javascript">
    // 添加全局站点信息
    var BASE_URL = "<?php echo C('HTStyle');?>/webuploader";
    //var SERVER_URL="www.baidu.com";
    var SERVER_URL="<?php echo U('Common/uploadImg');?>";
    //总共可以上传几张图片
    var PICNUM=5;
    //还可以上传几张图片
    var CanPicnum=PICNUM;
    //设置单个图片大小
    var PicSize=300*1024;
</script>
<script type="text/javascript" src="<?php echo C('HTStyle');?>/webuploader/upcon.js"></script>
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
		<div class="title"><span class="add"></span><strong>修改分类</strong></div>
		<div class="mrclass jz">
			<form action="<?php echo U("Product/update_product_class_from");?>" method="post" enctype="multipart/form-data" >
				<div class="mrlist">
					<ul>
						<li>
							<input type="hidden" name="cid" value="<?php echo ($_GET['cid']); ?>">
							<span class="mrtitle fl">分类名称：</span>
							<input type="text" name='name' class='mrinput' value="<?php echo ($proclass["Name"]); ?>" />
						</li>

						<li>
							<span class="mrtitle fl">所属分类：</span>
							<select name="classid" class="mrselect" >
                           	 <?php if(is_array($djclass)): $i = 0; $__LIST__ = $djclass;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["ID"]); ?>" <?php if($vo['ID'] == $proclass['PID']): ?>selected<?php endif; ?>>&nbsp;<?php echo ($vo["Name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
								<?php if(is_array($Pclass)): $i = 0; $__LIST__ = $Pclass;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["ID"]); ?>" <?php if($vo['ID'] == $proclass['PID']): ?>selected<?php endif; ?>>&nbsp;<?php echo ($vo["html"]); echo ($vo["Name"]); ?>
									</option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</li>
						
						<li>
							<span class="mrtitle fl">是否前台显示：</span>
							<input type="radio" name='Status' value="1" <?php if($proclass['Status'] == 1): ?>checked="checked"<?php endif; ?> />&nbsp;是&nbsp;&nbsp;
							<input type="radio" name='Status' <?php if($proclass['Status'] == 0): ?>checked="checked"<?php endif; ?> value="0" />&nbsp;否
						</li>
						<li>
							<span class="mrtitle fl">栏目图片：</span>
<div class="uploader">
	<div id="uploader">
		<div id="filePicker">点击上传图片</div>
	    <div id="fileList" class="uploader-list">
			<?php if(is_array($Thumbnail_list)): foreach($Thumbnail_list as $key=>$tlist): if(!empty($tlist)): ?><div class="tlist fl">
						<img src="/Upload<?php echo ($tlist); ?>" width="120" height="100">
						<input type="hidden" name="filepath[]" value="<?php echo ($tlist); ?>">
					</div><?php endif; endforeach; endif; ?>
	    </div>
	</div>	
</div>

<script type="text/javascript">	
	var PICNUM=1;
   // 添加全局站点信息
    var tlist=$(".tlist").find("img").length
    CanPicnum=PICNUM-tlist;
    if(CanPicnum==0){
    	CanPicnum=-1;
    }
    //删除图片的路径
    var PRO_DEL_PIC="<?php echo U('Product/del_pic');?>";
    //分类ID
    var PID="<?php echo ($_GET['cid']); ?>";
</script>
<script type="text/javascript" src="<?php echo C('HTStyle');?>/webuploader/upcon.js"></script>		

						</li>

												
						<li>
							<input type="submit" name="dosubmit" class="but" value="修改" />
							<a href="#" class="ret" OnClick='history.back();'>返回</a>
						</li>
					</ul>	
				</div>
			</form>
		</div>
	</div>
	<div class="cl"></div>	
</div>

</body>
</html>