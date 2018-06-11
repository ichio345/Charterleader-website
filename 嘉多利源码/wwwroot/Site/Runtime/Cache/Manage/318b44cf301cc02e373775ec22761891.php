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
	<!-- 配置上传图片js -->
	<script type="text/javascript">
	    var PICNUM=1;
	    //还可以上传几张图片
	    var CanPicnum=PICNUM;
	    //设置单个图片大小
	    var PicSize=500*1024;
	</script>
	<script type="text/javascript" src="<?php echo C('HTStyle');?>/webuploader/upcon.js"></script>
	<!-- 配置上传图片js end -->

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
		<div class="title"><span class="add"></span><strong>添加栏目</strong></div>
		<div class="mrclass jz">
			<form action="<?php echo U("Column/add_class_from");?>" method="post" enctype="multipart/form-data" >
				<div class="mrlist">
					<ul>
						<li>
							<input type="hidden" name="depth" value="<?php echo ($depth["depth"]); ?>">
							
							<span class="mrtitle fl">所属栏目：</span>
							<select name="classid" class="mrselect" >
								<option value="0" selected="selected">&nbsp;顶级栏目</option>
								<?php if(is_array($class)): $i = 0; $__LIST__ = $class;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["cid"]); ?>" <?php if($vo["cid"] == $_GET['cid']): ?>selected<?php endif; ?>>&nbsp;<?php echo ($vo["html"]); echo ($vo["cname"]); ?>
									</option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</li>
						<li>
							<span class="mrtitle fl">栏目名称：</span>
							<input type="text" name='name' class='mrinput' />
						</li>
						<li>
							<span class="mrtitle fl">副标题：</span>
							<input type="text" name='remark' class='mrinput' />
						</li>
						<li>
							<span class="mrtitle fl">是否前台显示：</span>
							<input type="radio" name='Status' checked="checked" value="1" />&nbsp;是&nbsp;&nbsp;
							<input type="radio" name='Status' value="0" />&nbsp;否
						</li>
						<li>
							<span class="mrtitle fl">栏目属性：</span>
							<?php if(is_array($bltype)): foreach($bltype as $key=>$vo): ?><input type="hidden" name="class_type[id][]" value="<?php echo ($vo["id"]); ?>">
								<input type="hidden" name="class_type[key][<?php echo ($vo["id"]); ?>]" value="<?php echo ($vo["name"]); ?>" >
								<?php echo ($vo["name"]); ?>&nbsp;&nbsp;<input name="class_type[value][<?php echo ($vo["id"]); ?>]" type="<?php echo ($vo["type"]); ?>" <?php if($vo['type'] == text): ?>class='mrinput'<?php endif; ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php endforeach; endif; ?>
						</li>
						<li>
							<span class="mrtitle fl">系统模型：</span>
							<select name="ModelID" id="" class="mrselect">
								<option value="0">&nbsp;请选择</option>
								<?php if(is_array($mlist)): $i = 0; $__LIST__ = $mlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["ID"]); ?>" <?php if($vo["ID"] == $_GET['mid']): ?>selected<?php endif; ?>>&nbsp;<?php echo ($vo["Title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
							<span class="mrtitle " style="text-align:center;margin-left:15px;">列表模板：</span>
							<select class="mrselect" name="systemplist">
								<option value="">&nbsp;默认</option>
								<?php if(is_array($systemplist)): foreach($systemplist as $key=>$list): ?><option value="<?php echo ($list); ?>">&nbsp;<?php echo ($list); ?></option><?php endforeach; endif; ?>
							</select>
							<span class="mrtitle " style="text-align:center;margin-left:15px;">内容页模板：</span>
							<select class="mrselect" name="systempshow">
								<option value="">&nbsp;默认</option>
								<?php if(is_array($systempshow)): foreach($systempshow as $key=>$show): ?><option value="<?php echo ($show); ?>">&nbsp;<?php echo ($show); ?></option><?php endforeach; endif; ?>
							</select>
						</li>
						<li>
							<span class="mrtitle fl">栏目图片：</span>
							<div class="uploader">
								<div id="uploader">
									<div id="filePicker"></div>
								    <div id="fileList" class="uploader-list"></div>
								</div>	
							</div>
						</li>
						<li>
							<span class="mrtitle fl">栏目简介：</span>
							<textarea name='Class_info' class="mrtext"></textarea>
						</li>
						<li>
							<input type="submit" name="dosubmit" class="but" value="添加" />
							<a href="<?php echo U("Column/index");?>" class="ret">返回</a>
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