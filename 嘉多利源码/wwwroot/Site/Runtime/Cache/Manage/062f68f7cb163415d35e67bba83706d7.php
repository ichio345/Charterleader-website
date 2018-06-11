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
	<div class="title"><span></span><strong>图片列表</strong><a href="<?php echo U('add_pic');?>" class="op">添加图片</a></div>
		<div class="list">
			<div class="search">
				<div class="btn-group">
				  <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    查看分类 <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  		<li><a href="<?php echo U('Pic/index');?>">显示全部</a></li>
				    <?php if(is_array($current)): foreach($current as $key=>$cl): ?><li><a href="<?php echo U('Pic/index',array('classid'=>$cl['ID']));?>"><?php echo ($cl["html"]); echo ($cl["Name"]); ?></a></li><?php endforeach; endif; ?>
				  </ul>
				</div>
				<button type="button" class="btn btn-sm btn-success ml10 move">移动 
					<span class="glyphicon glyphicon-share-alt"></span>
				</button>
				<div class="search_list">
					<form action="<?php echo U('Pic/index');?>" class="so" method="post">
						<input type="text" name="so" <?php if(empty($_POST['so'])): ?>placeholder="输入关键词..." <?php else: ?>   placeholder="<?php echo I('so');?>"<?php endif; ?> >
						<button type="button" class="btn btn-sm btn-warning search_but fr">搜索 <span class="glyphicon glyphicon-search"></span>
						</button>
						<script type="text/javascript">
							$('.search_but').click(function(){
								$('.so').submit();
							});
						</script>
					</form>
				</div>
				<script type="text/javascript">
					$jq(".move").click(function(){
		            	if( $jq("input:checked").length<1){
		            		alert('请选择要移动的项！')
					     	return false
					    }else{
					     	var pd=confirm('你确定要移动吗?')
			            	if(pd){
			            		var sfruit=''
			            		var sjchecked=$jq('#form').find(".sj:checked")
			            		var len=sjchecked.length;
			            		var dian=""
			            		sjchecked.each(function(i){
			            			i<(len-1)?dian=',':dian=''
			            			sfruit=sfruit+$(this).val()+dian
			            		})
			            		var str="<form action='<?php echo U(CONTROLLER_NAME.'/move_pic');?>' method='post' style='display:none' class='moveform'>";
			            			str+="<input type='text' name='moveid'>";
			            			str+="</form>";
			            		$(this).append(str);
			            		$('input[name=moveid]').attr('value',sfruit)
			            		$('.moveform').submit();
			            	}
					    }			    
		            });	
				</script>
			</div>

		<!-- 提交选定要删除的列表 -->
		<form action="<?php echo U('Pic/delete_pic');?>" id='form' method="post">
			<table id='playList' cellpadding="0" cellspacing="0">
				<tr>
					<th width="8%">图片ID</th>
					<th>图片标题</th>
					<th width="5%">排序</th>
					<th width="8%">首页显示</th>
					<th width="15%">所属分类</th>
					<th width="15%" style="text-align:right;border:none;">操作</th>
				</tr>	
				<?php if(is_array($art_list)): $i = 0; $__LIST__ = $art_list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td width="7%">
						<input type="checkbox" class="sj" name="del[]" value="<?php echo ($vo["ID"]); ?>" />&nbsp;&nbsp;<?php echo ($vo["ID"]); ?>
						</td>
						<td ><?php echo ($vo["Title"]); ?></td>
						<td style="position:relative">
							<input type="text" class="csort" onclick="ajax_sort(this,<?php echo ($vo["ID"]); ?>)" value="<?php echo ($vo["Sort"]); ?>">
							<div class="ajax_act fr">
								<span class='glyphicon glyphicon-ok-circle ok_click'></span>
								<span class='glyphicon glyphicon-remove-circle remove_click'></span>
							</div>
						</td>
						<td  align="center">
						<?php if($vo['is_index'] == 1): ?><span onclick="ajax_click(this,<?php echo ($vo["ID"]); ?>)" class='glyphicon glyphicon-ok ico_yes'></span> 
						<?php else: ?>
							<span onclick="ajax_click(this,<?php echo ($vo["ID"]); ?>)" class='glyphicon glyphicon-remove ico_no'></span><?php endif; ?>
						</td>
						<td ><font color="#989898"><?php echo ($vo["cname"]); ?></font></td>
						<td width="15%" align="right" style="border-right:0" >
							<a href="<?php echo U('update_pic',array('aid'=>$vo['ID'],'ysclassid' =>$_GET['classid'],'p'=>$_GET['p']));?>">[修改]</a>
							<a href="<?php echo U('delete_pic',array('aid'=>$vo['ID'],'ysclassid' =>$_GET['classid'],'p'=>$_GET['p'],'bz' =>1));?>" onclick="return confirm('你确定要删除吗?')"><font color="#ff7200">[删除]</font></a>
						</td>	
					</tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
				<tr class="bottom">
					<td colspan="6">
						<input type="hidden" name="ysclassid" value="<?php echo ($_GET['classid']); ?>">
						<input type="hidden" name="p" value="<?php echo ($_GET['p']); ?>">
						<input type="button" value="全选/全不选" id="selectAll" /> 
						<input type="button" value="反选" id="reverse" />
						<input type="button" value="删除选定" class="list_del">
					<?php echo ($show); ?>
					</td>
				</tr>
			</table>
			<script type="text/javascript">
				function ajax_click(obj,a){
					$.post('<?php echo U("ajax_click_pic");?>',{
						id:a,
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
				function ajax_sort(obj,a){
					var value=obj.value;
					$(obj).css({
						'position':'absolute',
						top:6,left:0,right:0,
						margin:'auto',textAlign:'left'
					}).animate({width:80,paddingLeft:5},function(){
						$(this).next('.ajax_act').show()
					})

					$(obj).next('.ajax_act').find('.ok_click').click(function(){
						$.post('<?php echo U("ajax_sort_pic");?>',{
							id:a,
							Sort:obj.value
						},function(data,status){
							if(data==1){ 
								history.go(0)					
							}
							$(obj).next('.ajax_act').hide();
							$(obj).removeAttr('style');
						})
					})

					$(obj).next('.ajax_act').find('.remove_click').click(function(){
						$(this).parent().hide();
						$(obj).removeAttr('style');
						$(obj).val(value)
					})	
				}
			</script>
		</form>
		</div>		
	</div>
	<div class="cl"></div>	
</div>
<script type="text/javascript">
	$jq(function () {
            $jq("#selectAll").click(function () {//全选 /全不选 
                if($jq("#playList :checkbox").is(':checked')){
                    $jq("#playList :checkbox").attr("checked", false);
                }else{
                     $jq("#playList :checkbox").attr("checked", true); 
                }
                
            });   
            $jq("#reverse").click(function () {//反选  
                $jq("#playList :checkbox").each(function () {  
                    $jq(this).attr("checked", !$jq(this).attr("checked"));  
                });  
            });
            $jq(".list_del").click(function(){
            	if( $jq("input:checked").length<1){
            		alert('请选择要删除的项！')
			     	return false
			    }else{
			     	var pd=confirm('你确定要删除吗?')
	            	if(pd){
	            		$jq('#form').submit();	
	            	}
			    }			    
            });
        });  
		
</script>

</body>
</html>