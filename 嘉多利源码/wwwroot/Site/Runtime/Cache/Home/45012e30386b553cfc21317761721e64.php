<?php if (!defined('THINK_PATH')) exit(); if($qq["is_index"] == 1): ?><script type="text/javascript" src="<?php echo C('TMURL');?>/common-style/QQ/js/qq.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo C('TMURL');?>/common-style/QQ/css/layout.css" />

<?php if($qq["display"] == 'block'): ?><div class="float-contact" id="float-contact" style="position: fixed;z-index:1000; <?php echo ($qq["position"]); ?>: 1px; top:<?php echo ($qq["Distance"]); ?>px; display:block ">
<?php else: ?>
 <div class="float-contact" id="float-contact" style="position: fixed;z-index:1000; <?php echo ($qq["position"]); ?>: 1px; top:<?php echo ($qq["Distance"]); ?>px; display:none; "><?php endif; ?>
	<a title="点击收缩" href="javascript:void(0);" onclick="show()" class="qqclose" id="float-contact-close">点击收缩</a>
	<div class="qqcontainer">
		<div class="qq">
			<h3 class="qqtitle">在线客服</h3>
			<ul class="qqbtn">
				<?php if(is_array($qq["qq"])): foreach($qq["qq"] as $k=>$vo): if(!empty($vo)): ?><li>
				<a title="客服" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ($vo); ?>&site=qq&menu=yes"><?php echo ($qq['qqtitle'][$k]); ?></a>
				</li><?php endif; endforeach; endif; ?>		
			</ul>
		</div>
		<div class="qqtel">
			<h3 class="qqtitle">咨询热线</h3>
			<?php if(is_array($qq["qqtel"])): foreach($qq["qqtel"] as $key=>$tel): if(!empty($tel)): ?><div class="qqcontent"><?php echo ($tel); ?></div><?php endif; endforeach; endif; ?>
		</div>
	</div>
	<a href="<?php echo ($qq["qqurl"]); ?>" class="myqqlink"><?php echo ($qq["title"]); ?></a>
	
</div>
<?php if($qq["display"] == 'none'): ?><div class="float-contact-mini" id="float-contact-mini" style="position: fixed; <?php echo ($qq["position"]); ?>: 1px; top:<?php echo ($qq["Distance"]); ?>px ;display:block; ">
<?php else: ?>
<div class="float-contact-mini" id="float-contact-mini" style="position: fixed; <?php echo ($qq["position"]); ?>: 1px; top:<?php echo ($qq["Distance"]); ?>px ; display:none;"><?php endif; ?>
	<a href="javascript:void(0);" onclick="show()" id="float-contact-mini">点击展开</a>
</div><?php endif; ?>