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
	<div class="title"><span></span><strong>栏目列表</strong><a href="<?php echo U('add_class');?>" class="op">添加栏目</a></div>
		<div class="list">
			<form action="<?php echo U('Column/sort_column');?>" method="post">
			<table cellpadding="0" cellspacing="0" class="table-hover ">
				<tr>
					<th width="6%">编号</th>
					<th width="25%">栏目名称</th>
					<th width="6%">级别</th>
					<th width="8%">模型名称</th>
					<th width="5%">排序</th>
					<th width="8%">内容数量</th>
					<th width="8%">前台显示</th>
					<th align="right" style="text-align:right;border:none;">操作</th>
				</tr>	
				<?php if(is_array($column)): $i = 0; $__LIST__ = $column;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td width="6%"><?php echo ($vo["ID"]); ?></td>
					<td width="25%"><?php echo ($vo["html"]); ?><a href="<?php echo ($vo["curl"]); ?>" class="fontlan"><?php echo ($vo["Name"]); ?></a></td>
					<td width="6%"><?php echo ($vo["level"]); ?></td>
					<td width="8%"><?php echo ($vo["Title"]); ?></td>
					<td width="5%">
						<input type="text" class="csort" name="<?php echo ($vo["ID"]); ?>" value="<?php echo ($vo["Sort"]); ?>">
					</td>
					<td align="center"><?php echo ($vo["contentNum"]); ?></td>
					<td align="center">
						<?php if($vo['Status'] == 1): ?><span onclick="ajax_click(this,<?php echo ($vo["ID"]); ?>)" class='glyphicon glyphicon-ok ico_yes'></span> 
						<?php else: ?>
						<span onclick="ajax_click(this,<?php echo ($vo["ID"]); ?>)" class='glyphicon glyphicon-remove ico_no'></span><?php endif; ?>
					</td>
					
					<td align="right" style="border-right:0">
						<?php if(C(ClumnPath) < $vo['depth']): ?><a href="" style="color:#999">[添加子栏目]</a>
						<?php else: ?>
						<a href="<?php echo U('add_class',array('cid'=>$vo["ID"],'mid'=>$vo['ModelID']));?>">[添加子栏目]</a><?php endif; ?>
						<a href="<?php echo U('updata_class',array('cid'=>$vo['ID']));?>" >[修改]</a> 
						<?php if($vo['Child'] == 0): ?><a href="<?php echo U('del_class',array('cid'=>$vo['ID']));?>" onclick="return confirm('你确定要删除吗?')" >[删除]</a>
						<?php else: ?>
							<a href="javascript:void(0)" onclick="alert('对不起！此栏目下已有子栏目，请先删除子栏目再删除！')" style="color:#ccc" >[删除]</a><?php endif; ?>
					</td>	
				</tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
				<script type="text/javascript">
					function ajax_click(obj,a){
						$.post('<?php echo U("ajax_click_column");?>',{
							cid:a,
						},function(data,status){
							if(data==1){
								if($(obj).hasClass('glyphicon-ok')){
									$(obj).removeClass('glyphicon-ok ico_yes').addClass('glyphicon-remove ico_no');
									return;
								}
								if($(obj).hasClass('glyphicon-remove')){
									$(obj).removeClass('glyphicon-remove ico_no').addClass('glyphicon-ok ico_yes');
								}							
							}
						})
					}
				</script>
			</table>
			<br>
			<input type="submit" style="margin:0" class="but" value="更新排序">
			</form>
		</div>		
	</div>
	<div class="cl"></div>
	
</div>

</body>
</html>