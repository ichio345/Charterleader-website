<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8">
	<title><?php $fgf="-";$db=M('class'); $data=$db->where(array('ID'=>I('get.cid')))->find(); $posid=array_reverse(array_filter(explode(',',$data['path']))); $count=count($posid); if(!myempty($content['Title'])){ echo $content['Title'],$fgf; } if(!myempty($data['Name'])){ echo $data['Name'],$fgf; } foreach ($posid as $k=>$v) { $where=array('ID'=>$v); $posdata=$db->where($where)->find(); if($count>$k){ echo $posdata['Name'].$fgf; }else{ echo $posdata['Name']; } } echo ($title); ?></title>
	<meta name="Author" content="苏州易动力" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<meta name="Keywords" content="<?php echo ($keywords); ?>" />
	<meta name="Description" content="<?php echo ($description); ?>" />
	<link rel="stylesheet" href="<?php echo C('TMURL');?>/css/Layout.css" type="text/css" />
	<script type="text/javascript" src="<?php echo C('TMURL');?>/js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="<?php echo C('TMURL');?>/js/slide.js"></script>
	<script type="text/javascript" src="<?php echo C('TMURL');?>/js/jquery.SuperSlide.2.1.1.js"></script>
</head>
<body>

<!--head begin-->
<div class="head">
	<div class="ty_w jz">
		<div class="logo fl">
			<a href="<?php echo U('/index');?>"><h1><img src="<?php echo C('TMURL');?>/images/logo.jpg" height="138" width="434" alt="<?php echo ($sitename); ?>" ></h1></a>
		</div>
		<div class="right fr">
			<div class="tb fl">
				<a href="https://szjs325.1688.com/?spm=a261y.7663282.0.0.HfA3Fg" class="fl" target="_blank"><img src="<?php echo C('TMURL');?>/images/ali.png" height="21" width="21"></a>
				<a href="https://shop104210450.taobao.com/?qq-pf-to=pcqq.c2c" class="fl" target="_blank"><img src="<?php echo C('TMURL');?>/images/tb.png" height="18" width="24"></a>
			</div>
			<div class="search fl">
				<?php $action=U("List/product"); $name='title';echo "<form action=\"$action\" method=\"post\">";?><input type="text" name="title" class="search_text fl" value="请输入产品关键词"  onclick="this.value=''" />
					<input class='search_btn fl' type="submit"  value="" /><?php echo"</form>";?>
			</div>
			<div class="tel fl">
				<p>让测量更加精准和简单</p>
				<a href="javascript:;">0512-65733433</a>
			</div>
			<div class="cl"></div>
		</div>
		<div class="cl"></div>
	</div>
</div>
<!--head end->

<!--nav begin-->
<div class="nav">
	<div class="ty_w jz">
    	<ul id="nav" class="fl">    
            <li class="mainlevel"><a href="<?php echo U('/index');?>">首页</a></li>
            <?php
 $nav=blnav(); import("Class.expand",APP_PATH); $object = new \Expand(); $_navlist=$object->menu_arr($nav); $towpath=M("class")->field('path')->where('ID='.$_GET['cid'].'')->find(); $towpath['path']=explode(',',$towpath['path']); foreach($_navlist as $menulist): $pos=in_array($menulist['ID'],$towpath['path']); $menulist['current']=''; if($menulist['ID']==$_GET['cid'] || $pos !==false){ $menulist['current']="class='on'"; } ?><li class="mainlevel"><a href="<?php echo ($menulist["link"]); ?>"  <?php echo ($menulist["current"]); ?> <?php echo ($menulist["target"]); ?>><?php echo ($menulist["name"]); ?></a>
				<?php if($menulist["find"] != null): ?><ul class="hide">
						<?php if(is_array($menulist["find"])): foreach($menulist["find"] as $key=>$vo): ?><li><a href="<?php echo ($vo["link"]); ?>"><?php echo ($vo["name"]); ?></a></li><?php endforeach; endif; ?>
					</ul><?php endif; ?>
			</li><?php endforeach;?>	
        </ul>
        <div class="cl"></div>
    </div>	
</div>
<!--nav end-->



<!-- 判断首页锁定 -->
<script type="text/javascript">
if(!$(".nav").find("li a").hasClass('on')){
$(".nav").find("li:first").find("a").addClass("on");
}
</script>	

<div class="ny_main ty_w jz">
	<div class="mleft fl">	
		<div class="mleft_title">
		<!-- 调用顶级栏目 -->
		<?php $isid="1"; $id=!empty($isid)?$isid:I("get.cid");$data=M("class")->where("ID=".$id)->find();$cname["name"]=!myempty($data["Name"])?$data["Name"]:"产品展示";$cname["remark"]=$data["Remark"]; echo ($cname["name"]); ?>
		</div>
		<!-- 栏目列表 -->
		<div class="mleft_list">
			<?php $show="all";$id="";$type="about";$db=M("class"); $isid=!myempty($id)?$id:I('cid'); $ModelID=M("model")->field("ID")->where("Name='about'")->find(); $column=blnav(); if(!empty($type)){ $where=array('ModelID'=>$ModelID['ID'],'Child'=>array('neq',0),'Status'=>1,'Edition'=>C('edition')); }else{ $where=array('Child'=>array('neq',0),'Status'=>1,'Edition'=>C('edition')); } if($show=="all"){ !empty($id)?$where['ID']=$id:''; }else if($show=="now"){ $where['ID']=$isid; }else if($show=='now_all'){ $gid=$_GET['cid']; $data=$db->field('path')->where('ID='.$gid.'')->find(); !empty($data['path'])?$path=explode(',', $data['path'])[0]:$gid; $where['ID']=$path; } $pid=$db->where($where)->order('depth')->find(); empty($pid['ID'])?$pid['ID']=I('cid'):$pid['ID']; import("Class.expand",APP_PATH); $object = new \Expand(); $column=$object->erwei2($column,'',$pid['ID']); echo classNav($column); ?>		
		</div>
	</div>
	<div class="mright fr">
		<div class="mright_title">
			<!-- 调用当前栏目标签 -->
			<h1 class="fl"><?php $isid=""; $id=!empty($isid)?$isid:I("get.cid");$data=M("class")->where("ID=".$id)->find();$cname["name"]=!myempty($data["Name"])?$data["Name"]:"产品展示";$cname["remark"]=$data["Remark"]; echo ($cname["name"]); ?></h1>
			<div class="position fr">
			<!-- 面包屑导航 -->
				<?php echo L('position');?>:<a href="<?php echo U('Index/index');?>"><?php echo L('home');?></a> > <?php $db=M("class");$id=I("get.cid");$fgf=" > ";$data=$db->where(array("ID"=>$id))->find();$posid=explode(",",$data["path"]); foreach ($posid as $v) { $where=array('ID'=>$v); $posdata=D('ColumnView')->where($where)->find(); if($posdata['typeid']==2 && !myempty($posdata['typevalue'])){ $posurl=$posdata['typevalue']; if(!myempty($v)){ $newurl="<a href='".$posurl."'>".$posdata['Name']."</a>".$fgf; }else{ $newurl="<a href='".$posurl."'>".$data['Name']."</a>"; } echo $newurl; continue; } if(!empty($v)){ if($posdata['PID']!=0){ echo "<a href='".get_url($posdata['PID'])."'>".$posdata['Name']."</a>".$fgf; }else{ echo "<a href='".get_url($posdata['ID'])."'>".$posdata['Name']."</a>".$fgf; } }else{ if(empty($data['Name'])){ echo "<a href='".get_url($id)."'>".L('sea_empty')."</a>"; }else{ echo "<a href='".get_url($id)."'>".$data['Name']."</a>"; } } } ?>		
			</div>
			<div class="cl"></div>
		</div>
		<div class="content">
			
	
<link rel="stylesheet" type="text/css" href="<?php echo C('TMURL');?>/common-style/style.css">
<script type="text/javascript" src="<?php echo C('TMURL');?>/common-style/jquery-1.4.2.min.js"></script>
<script>
  // var $jq= jQuery.noConflict(true);  
  </script>

  <script type="text/javascript">
<!--
function CheckForm(theForm)
{
	var pattern = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;   //验证邮箱正则
	var sjyz = /^1[34578]\d{9}$/;    //验证手机号码正则
	var  qqyz = /^[0-9]*$/ ;              //验证QQ    
	var flag ;
	if (theForm.title.value=="")
	{
		alert("标题不能为空！");
		theForm.title.focus();
		return false;
	}
	if (theForm.content.value=="")
	{
		alert("内容不能为空！");
		theForm.content.focus();
		return false;
	}
	if (theForm.name.value=="")
	{
		alert("联系人不能为空！");
		theForm.name.focus();
		return false;
	}
	if (theForm.tel.value=="")
	{
		alert("电话不能为空！");
		theForm.tel.focus();
		return false;
	}

	

	if (theForm.qq.value!=="")
	{
		flag = qqyz.test(theForm.qq.value) ;
		if (!(flag))
		{
			alert("请输入正确的QQ！");
			theForm.qq.focus();
			return false;
		}
	}

	if (theForm.phone.value!=="")
	{
		flag = sjyz.test(theForm.phone.value) ;
		if (!(flag))
		{
			alert("请输入正确的手机号码！");
			theForm.phone.focus();
			return false;
		}
	}

	if (theForm.email.value!=="")
	{
		flag = pattern.test(theForm.email.value) ;
		if (!(flag))
		{
			alert("请输入正确的邮箱！");
			theForm.email.focus();
			return false;
		}
	}
	
	if (theForm.code.value=="")
	{
		alert("请输入验证码！");
		theForm.code.focus();
		return false;
	}

	return true;

}
//-->
  </script>
<script type="text/javascript" src="<?php echo C('TMURL');?>/common-style/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo C('TMURL');?>/common-style/default.js"></script>
<div id="nr-container">
	<div class="nr-content">
		<form action="<?php echo U('feedback_from');?>" class="feedback" id="yzform" method="post"  OnSubmit="return CheckForm(this)">
			<dl>
				<dt class="fdtitle"><?php echo L('ftitle');?>:</dt>
				<dd><input type="text" name="title" class="fdinput">&nbsp;&nbsp;<font color="#f30">*</font></dd>
			</dl>
			<dl>
				<dt  class="fdtitle"><?php echo L('fcontent');?>:</dt>
				<dd><textarea name="content" class="fdtext"></textarea>&nbsp;&nbsp;<font color="#f30">*</font></dd>
			</dl>
			<dl>
				<dt  class="fdtitle"><?php echo L('fname');?>:</dt>
				<dd><input type="text" name="name" class="fdinput">&nbsp;&nbsp;<font color="#f30">*</font></dd>
			</dl>
			<dl>
				<dt class="fdtitle"><?php echo L('fCompanyname');?>:</dt>
				<dd><input type="text" name="company" class="fdinput"></dd>
			</dl>
			<dl>
				<dt class="fdtitle"><?php echo L('ftel');?>:</dt>
				<dd><input type="text" name="tel" class="fdinput">&nbsp;&nbsp;<font color="#f30">*</font></dd>
			</dl>
			<dl>
				<dt class="fdtitle"><?php echo L('fqq');?>:</dt>
				<dd><input type="text" name="qq" class="fdinput"></dd>
			</dl>
			<dl>
				<dt class="fdtitle"><?php echo L('fphone');?>:</dt>
				<dd><input type="text" name="phone" class="fdinput"></dd>
			</dl>
			<dl>
				<dt class="fdtitle"><?php echo L('femail');?>:</dt>
				<dd><input type="text" name="email" class="fdinput"></dd>
			</dl>
			<dl>
				<dt class="fdtitle"><?php echo L('faddress');?>:</dt>
				<dd><input type="text" name="address" class="fdinput"  style="width:350px;"></dd>
			</dl>
			<dl>
				<dt class="fdtitle"><?php echo L('fyzm');?>:</dt>
				<dd><input type="text" name="code" class="fdinput"  style="width:80px;">
				<img src="Home/Index/verify" id="verify_img" alt="verify_code" onclick="refreshVerify()" class="codeimg">
				</dd>
			</dl>
			<dl>
				<dd>
					<input type="hidden" name="jsemail"  value="<?php echo ($email); ?>">
					<input type="submit" value="<?php echo L('fsubmit');?>" class="fdsub">
					<input type="reset" value="<?php echo L('freset');?>" class="fdres">
				</dd>
			</dl>
		</form>
		<script>
		    function refreshVerify() {
		        var ts = Date.parse(new Date())/1000;
		        var img = document.getElementById('verify_img');
		        img.src = "Home/Index/verify?id="+ts;

		    }
		</script>
	</div>
</div>


		</div>
		
	</div>
	<div class="cl"></div>
</div>
<!--foot_nav begin-->
<div class="foot_nav">
	<div class=" jz ty_w">
		<ul>
			<li class="mainlevel"><a href="<?php echo U('/index');?>">首页</a></li>
		    <?php
 $nav=blnav(); import("Class.expand",APP_PATH); $object = new \Expand(); $_navlist=$object->menu_arr($nav); $towpath=M("class")->field('path')->where('ID='.$_GET['cid'].'')->find(); $towpath['path']=explode(',',$towpath['path']); foreach($_navlist as $menulist): $pos=in_array($menulist['ID'],$towpath['path']); $menulist['current']=''; if($menulist['ID']==$_GET['cid'] || $pos !==false){ $menulist['current']="class='on'"; } ?><li class="mainlevel"><a href="<?php echo ($menulist["link"]); ?>"  <?php echo ($menulist["current"]); ?> <?php echo ($menulist["target"]); ?>><?php echo ($menulist["name"]); ?></a></li><?php endforeach;?>    
		</ul>
	</div>
</div>
<!--foot_nav end-->

<!--footer begin-->
<div class="footer">
	<div class="ty_w jz">
		<div class="infor fl">
			<p>版权所有：<?php echo ($sitename); ?>&nbsp;&nbsp;&nbsp;地址：<?php echo ($address); ?> </p>
			<p>电话：<?php echo ($tel); ?>&nbsp;&nbsp;&nbsp;传真：0512-66352846&nbsp;&nbsp;联系人：郭浩雁&nbsp;&nbsp;&nbsp;13390886325&nbsp;&nbsp;&nbsp;Email:jinson@vip.163.com   13390886325@189.cn</p>
			<p>
				苏ICP备16011280号&nbsp;&nbsp;&nbsp;
				<a href="http://www.jsydl.com" target="_blank">技术支持：易动力网络</a>
			</p>
		</div>
		<img src="<?php echo C('TMURL');?>/images/wx.jpg" height="95" width="95" alt="" class="wx fr" />
	</div>
</div>
<!--footer end-->




<!-- 调用客服QQ -->
<script type="text/javascript">
$("body").append("<div class='qq'></div>")
$('.qq').load("<?php echo U(MODULE_NAME.'/Common/qq') ?>");
</script>
</body>
</html>