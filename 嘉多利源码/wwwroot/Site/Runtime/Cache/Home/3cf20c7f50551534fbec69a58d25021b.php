<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta http-equiv = "X-UA-Compatible" content = "IE=edge,chrome=1" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="">
<meta name="format-detection" content="telephone=no">
<title><?php $fgf="-";$db=M('class'); $data=$db->where(array('ID'=>I('get.cid')))->find(); $posid=array_reverse(array_filter(explode(',',$data['path']))); $count=count($posid); if(!myempty($content['Title'])){ echo $content['Title'],$fgf; } if(!myempty($data['Name'])){ echo $data['Name'],$fgf; } foreach ($posid as $k=>$v) { $where=array('ID'=>$v); $posdata=$db->where($where)->find(); if($count>$k){ echo $posdata['Name'].$fgf; }else{ echo $posdata['Name']; } } echo ($title); ?></title>
<script src="<?php echo C('TMURL');?>/js/jquery.min.js"></script>
<script src="<?php echo C('TMURL');?>/js/wapSlide.js"></script>
<script src="<?php echo C('TMURL');?>/js/slide.js"></script>
<script src="<?php echo C('TMURL');?>/js/iscroll.js"></script>
<script src="<?php echo C('TMURL');?>/js/drawer.min.js"></script>
<script src="<?php echo C('TMURL');?>/js/select.js"></script>
<script src="<?php echo C('TMURL');?>/js/jquery.carousel.js"></script>
<script type="text/javascript" src="<?php echo C('TMURL');?>/js/swiper.min.js" ></script>
<!--[if lt IE 9]>
<script src="<?php echo C('TMURL');?>/js/respond.min.js"></script>
<script src="<?php echo C('TMURL');?>/js/html5shiv.min.js"></script>
<![endif]-->
<!--[if IE]><link href="<?php echo C('TMURL');?>/css/ie.css" rel="stylesheet" type="text/css"><![endif]-->
<link href="<?php echo C('TMURL');?>/css/normalize.css" rel="stylesheet" type="text/css">
<link href="<?php echo C('TMURL');?>/css/typo.css" rel="stylesheet" type="text/css">
<link href="<?php echo C('TMURL');?>/css/wapSlide.css" rel="stylesheet" type="text/css">
<link href="<?php echo C('TMURL');?>/css/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo C('TMURL');?>/css/wap.css" rel="stylesheet" type="text/css">
<link href="<?php echo C('TMURL');?>/css/drawer.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo C('TMURL');?>/css/Layout.css" />
<link rel="stylesheet" href="<?php echo C('TMURL');?>/css/swiper.min.css" />
<link rel="stylesheet" href="<?php echo C('TMURL');?>/css/media.css" />
</head>
<body class="drawer drawer--right">

<!--头部 begin-->
<div class="header">
	<div class="wrap">
    	
        <!--logo begin-->
        <div class="logo pc ">
        	<span class="pic">
            	<a href="<?php echo U('/index');?>"><h1><img src="<?php echo C('TMURL');?>/images/logo.png" alt="<?php echo ($sitename); ?>" /></h1></a>
            </span>
        </div>
        <!--logo end-->

        <!-- wap logo begin-->
        <div class="logo wap">
            <span class="pic">
                <img src="<?php echo C('TMURL');?>/images/logo1.png" />
            </span>
        </div>
        <!-- wap logo end -->
                <!-- 语言版本 begin -->
        <div class="lang-ver">
            <ul class="ver">
                <li><a href="<?php echo U('Common/lang',array('lng'=>'cn'));?>">中文</a></li>
                <li><a href="">|</a></li>
                <li class="on"><a href="<?php echo U('/index');?>">ENGLISH</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <!-- 语言版本 end -->

    </div>

</div>
        <!-- 手机语言版本 begin -->
    <div class="lang-ver1">
            <ul class="ver">
                <li><a href="<?php echo U('Common/lang',array('lng'=>'cn'));?>"><img src="<?php echo C('TMURL');?>/images/cn.png"  alt="中文版">中文</a></li>
                <li  class="on"><a href=""><img src="<?php echo C('TMURL');?>/images/en.png"  alt="English">EN</a></li>
            </ul>
            <div class="clear"></div>
            <img src="images/ver-pic.png"  alt="精准服务，客户满意" class="ver-pic pc">
        </div>
    <!-- 语言版本 end -->
<!--头部 end-->
<script type="text/javascript">    
function funcInitSel(e){        
    var objUL = e.getElementsByTagName("ul")[0];
    document.onclick = function(){                
        if(e.getAttribute("state")=="0")
        objUL.style.display = "none";
    }
    
    var objTxt = e.getElementsByTagName("input")[0];
    var arrLi = objUL.getElementsByTagName("li");

    for(var i=0;i<arrLi.length;i++){
        arrLi[i].onmouseover = function(){
            this.className = "on";                
        }
        arrLi[i].onmouseout = function(){
            this.className = "";
        }
        
        arrLi[i].onclick = function(){
            objTxt.value = this.innerHTML;                
            e.setAttribute("state",0);
            objUL.style.display = "none";  
        }
    }
}

function funcSel(e){                 
    var objUL = e.getElementsByTagName("ul")[0];         
    if(objUL.style.display == "none" && e.getAttribute("state") == "1"){
        objUL.style.display = "";                 
    }if(e.offsetWidth > objUL.offsetWidth){
        objUL.style.width=e.offsetWidth-2 + "px";            
    }         
}

function funcSetOn(e,v){  
    if(e.getAttribute("state") == ""){
        funcInitSel(e);                                   
    }
    e.setAttribute("state",v);     
}

</script>


<div class="clear"></div>

<!--导航 -->
<div class="nav pc">
	<div class="wrap">
    	<ul>
            <li><em><a href="<?php echo U('/index');?>" <?php if($_GET['cid']==""){ ?>class="now"<?php } ?>>Home</a></em></li>
            <?php
 $nav=blnav(); import("Class.expand",APP_PATH); $object = new \Expand(); $_navlist=$object->menu_arr($nav); $towpath=M("class")->field('path')->where('ID='.$_GET['cid'].'')->find(); $towpath['path']=explode(',',$towpath['path']); foreach($_navlist as $menulist): $pos=in_array($menulist['ID'],$towpath['path']); $menulist['current']=''; if($menulist['ID']==$_GET['cid'] || $pos !==false){ $menulist['current']="class='now'"; } ?><li><em><a href="<?php echo ($menulist["link"]); ?>" <?php echo ($menulist["current"]); ?> <?php echo ($menulist["target"]); ?>><?php echo ($menulist["name"]); ?></a></em>
                    <?php if($menulist["find"] != null): ?><dl>
                            <?php if(is_array($menulist["find"])): foreach($menulist["find"] as $key=>$vo): ?><dd><a href="<?php echo ($vo["link"]); ?>"><?php echo ($vo["name"]); ?></a></dd><?php endforeach; endif; ?>
                        </dl><?php endif; ?>
            </li><?php endforeach;?>
        </ul>
    </div>
</div>
<!--导航 -->

<div class="clear"></div>

<!--banner -->

<?php if($_GET['cid'] == 268): else: ?>
    <div id="slideBox" class="slideBox">
            <div class="bd">
                <ul>
                    <?php $data=M("slide")->where(array("is_index"=>"1","Edition"=>2))->limit()->order("sort")->select();foreach($data as $banner):$banner["src"]="/Upload".$banner["PicUrl"];$banner["link"]=$banner["LinkUrl"];$banner["title"]=$banner["Title"];$banner["ID"]=$banner["ID"];$banner["desc"]=substr_cut($banner["Desc"],max)?><li>
                            <a class="pic" href="<?php echo ($banner["link"]); ?>"><img src="<?php echo ($banner["src"]); ?>" /></a>
                        </li><?php endforeach ?>

                </ul>
            </div>
            <span class="prev hidden-xs hidden-sm"></span>
            <span class="next hidden-xs hidden-sm"></span>
            <ul class="hd">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>

        <div id="slideBox1" class="slideBox1">
            <div class="bd">
                <ul>
                    <?php $data=M("slide")->where(array("is_index"=>"1","Edition"=>2))->limit()->order("sort")->select();foreach($data as $banner):$banner["src"]="/Upload".$banner["PicUrl"];$banner["link"]=$banner["LinkUrl"];$banner["title"]=$banner["Title"];$banner["ID"]=$banner["ID"];$banner["desc"]=substr_cut($banner["Desc"],max)?><li>
                            <a class="pic" href="/product240.html"><img src="<?php echo C('TMURL');?>/images/banner1.jpg" /></a>
                        </li>
                        <li>
                            <a class="pic" href="/product240.html"><img src="<?php echo C('TMURL');?>/images/banner2.jpg" /></a>
                        </li>
                        <li>
                            <a class="pic" href="/product240.html"><img src="<?php echo C('TMURL');?>/images/banner3.jpg" /></a>
                        </li>
                        <li>
                            <a class="pic" href="/product240.html"><img src="<?php echo C('TMURL');?>/images/banner4.jpg" /></a>
                        </li><?php endforeach ?>

                </ul>
            </div>
            <span class="prev hidden-xs hidden-sm"></span>
            <span class="next hidden-xs hidden-sm"></span>
            <ul class="hd">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>


        <script type="text/javascript" src="<?php echo C('TMURL');?>/js/TouchSlide.1.1.js" ></script>
        <script>
            jQuery("#slideBox").slide({
		          	mainCell:".bd ul",
		          	mainCell:".bd ul",
		                effect:"leftLoop",
	               delayTime:1200,
	              autoPlay:true,//自动播放
	              mouseOverStop:true
	          });
             TouchSlide({ 
                slideCell:"#slideBox1", 
                titCell:".hd li",
                mainCell:".bd ul",
                effect:"leftLoop",
              autoPlay:true//自动播放
            });
            TouchSlide({ 
                slideCell:"#news_slide",
                mainCell:".bd ul",
                effect:"leftLoop",
                autoPlay:true//自动播放
            });
        </script>

<!--banner --><?php endif; ?>
<div class="clear"></div>
<div class="i-menu">
  <div class="container-s">
      <ul class="i-menu-list c txt-c">
        <li><a href="<?php echo U('/index');?>">Home</a></li>
        <?php
 $nav=blnav(); import("Class.expand",APP_PATH); $object = new \Expand(); $_navlist=$object->menu_arr($nav); $towpath=M("class")->field('path')->where('ID='.$_GET['cid'].'')->find(); $towpath['path']=explode(',',$towpath['path']); foreach($_navlist as $menulist): $pos=in_array($menulist['ID'],$towpath['path']); $menulist['current']=''; if($menulist['ID']==$_GET['cid'] || $pos !==false){ $menulist['current']="class='now'"; } ?><li><a href="<?php echo ($menulist["link"]); ?>"><?php echo ($menulist["name"]); ?></a></li><?php endforeach;?>
      </ul>
  </div>
</div>
<!-- 当前位置 begin -->
<div class="path">
    <div class="wrap">
        <span>
        <!-- 面包屑导航 -->
				<?php echo L('position');?>:<a href="<?php echo U('Index/index');?>"><?php echo L('home');?></a> > <?php $db=M("class");$id=I("get.cid");$fgf=" > ";$data=$db->where(array("ID"=>$id))->find();$posid=explode(",",$data["path"]); foreach ($posid as $v) { $where=array('ID'=>$v); $posdata=D('ColumnView')->where($where)->find(); if($posdata['typeid']==2 && !myempty($posdata['typevalue'])){ $posurl=$posdata['typevalue']; if(!myempty($v)){ $newurl="<a href='".$posurl."'>".$posdata['Name']."</a>".$fgf; }else{ $newurl="<a href='".$posurl."'>".$data['Name']."</a>"; } echo $newurl; continue; } if(!empty($v)){ if($posdata['PID']!=0){ echo "<a href='".get_url($posdata['PID'])."'>".$posdata['Name']."</a>".$fgf; }else{ echo "<a href='".get_url($posdata['ID'])."'>".$posdata['Name']."</a>".$fgf; } }else{ if(empty($data['Name'])){ echo "<a href='".get_url($id)."'>".L('sea_empty')."</a>"; }else{ echo "<a href='".get_url($id)."'>".$data['Name']."</a>"; } } } ?>		
        </span>
    </div>
</div>
<!-- 当前位置 end -->


<!-- 内页栏目 begin -->
<?php if($_GET['cid'] == 268 or $_GET['cid'] == 267 ): else: ?>
    <div class="ny-column">
        <div class="wrap">
            <h2><?php $bname["name"]="测试方案"; $bname["remark"]=""; $bname["src"]="/Upload"; echo ($bname["name"]); ?></h2>
            <p><?php $bname["name"]="测试方案"; $bname["remark"]=""; $bname["src"]="/Upload"; echo ($bname["remark"]); ?></p>
        </div>
    </div><?php endif; ?>


<!-- 内页栏目 end -->

<div class="ny-content">
    








<div class="wrap">
      <script src="<?php echo C('TMURL');?>/js/jquery.jqzoom.js"></script>
      <script src="<?php echo C('TMURL');?>/js/base.js"></script>
      <link rel="stylesheet" type="text/css" href="<?php echo C('TMURL');?>/css/base.css">
      <div class="xq-detail">
          <div class="content">
            
            <!-- pc 放大镜效果 begin -->
            <div class="pro-list-pic pc">
              <div id="preview" class="spec-preview"> <span class="jqzoom"><img jqimg="/Upload<?php echo ($content["fm"]); ?>"  src="/Upload<?php echo ($content["fm"]); ?>"  style='max-width:auto;'/></span> </div>
              <!--缩图开始-->
              <div class="spec-scroll">
                <div class="items">
                <ul>
                  <?php if(is_array($content["Thumbnail"])): foreach($content["Thumbnail"] as $key=>$thumb): ?><li>
				      	<img bimg="/Upload<?php echo ($thumb); ?>" src="/Upload<?php echo ($thumb); ?>" onmousemove="preview(this);">
				      	</li><?php endforeach; endif; ?>
                  <div class="cl"></div>
                </ul>
                </div>
              </div>
              <!--缩图jieshu-->
            </div>
            <!-- pc 放大镜效果 end -->

            <!-- wap 产品图片展示 begin -->
            <div class="swiper-container wap">
                    <div class="swiper-wrapper">
                       <?php if(is_array($content["Thumbnail"])): foreach($content["Thumbnail"] as $key=>$thumb): ?><div class="swiper-slide">
                            <img src="/Upload<?php echo ($thumb); ?>" alt="" />
                        </div><?php endforeach; endif; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            <!-- wap 产品图片展示 end -->

            <div class="text">
              <h2><?php echo ($content["Title"]); ?></h2>
              <p><?php echo ($content["Keyword"]); ?></p>
              <dl>
                <?php echo ($content["Description"]); ?>
              </dl>

              <div class="tel">
                <p>邮箱：<span><?php echo ($email); ?></span></p>
              </div>
            </div>

            <div class="clear"></div>

            <!-- 产品详情介绍 begin -->
            <div class="xq-content">
              <div class="title">
                <ul>
                  <li><a href="#td">Product features</a></li>
                  <li><a href="#cs">Product parameters</a></li>
                  <li><a href="#al">The case shows</a></li>
                  <li><a href="#rel">Series of products</a></li>
                </ul>
              </div>
              <div class="contain #xq">
                <div id="td"><p class="biaoti">Product features</p><?php echo ($content["Content"]); ?></div>
                <div id="cs"><p class="biaoti">Product parameters</p><?php echo ($content["tedian"]); ?></div>
                <div id="al"><p class="biaoti">The case shows</p><?php echo ($content["shuoming"]); ?></div>
                <div id="rel">
                  <p class="biaoti"></p>
                  <ul class="ny-prolist rel-product">
                  <?php $noid=$_GET['cid'];$nooid=$_GET['id']; ?>
					<?php $where="id != $nooid"; $where2=array( "path"=>array('like',"%$noid%") ,"Edition"=>C('EDITION') ,"is_index"=>1 ); if(!myempty($where)){ $data=D("Product")->where($where2)->where($where)->limit(3)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); }else{ $data=D("Product")->where($where2)->limit(3)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); } foreach ($data as $product) : $piclist=explode("###",$product['Thumbnail'])[$product['Cover']]; $picpath='Upload'.$piclist; if(!empty($piclist) && file_exists($picpath)){ $product["src"]='/Upload'.$piclist; }else{ $product["src"]='/Common/images/not-pic.jpg'; } $product["title"]=substr_cut($product["Title"],18); $product["desc"]=substr_cut($product["Description"],max); $product["keyword"]=substr_cut($product["Keyword"],max); $product["link"]=get_url($product['ClassID'],$product["ID"]); $product["id"]=$product["ID"]; foreach ($product["content_on_type"] as $key => $value) { $product[$value['typeremark']]=$value['typevalue']; } ?><li>
                                      <div class="pic">
                                          <a href="<?php echo ($product["link"]); ?>"><img src="<?php echo ($product["src"]); ?>" height="182" width="230" alt="<?php echo ($product["title"]); ?>" title="<?php echo ($product["title"]); ?>"></a>
                                      </div>
                                      <a href="<?php echo ($product["link"]); ?>" class="name"><?php echo ($product["title"]); ?></a>
                                  </li><?php endforeach;?>
                              </ul>
                </div>
              </div>
            </div>
            <!-- 产品详情介绍 end -->

        </div>
      </div>

    </div>

</div>
<!-- pc 底部 begin -->
<div class="footer pc">
    <div class="wrap">
        <div class="left fast-link">
            <dl>
                <dt>Hyperlinks</dt>
                <dd><a href="/about238.html">About us</a></dd>
                <dd><a href="/productt240.html">Product center</a></dd>
                <dd><a href="/picture241.html">Partners</a></dd>
                <dd><a href="/article242.html">News Center</a></dd>
                <dd><a href="/aboutt309.html">Company culture</a></dd>
                <dd><a href="/aboutt244.html">Contact us</a></dd>
            </dl>
<!--             <dl>
                <dt>Main Products</dt>
                <?php $where=""; $where2=array( "path"=>array('like',"%240%") ,"Edition"=>C('EDITION') ,"is_index"=>1 ); if(!myempty($where)){ $data=D("Product")->where($where2)->where($where)->limit(5)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); }else{ $data=D("Product")->where($where2)->limit(5)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); } foreach ($data as $product) : $piclist=explode("###",$product['Thumbnail'])[$product['Cover']]; $picpath='Upload'.$piclist; if(!empty($piclist) && file_exists($picpath)){ $product["src"]='/Upload'.$piclist; }else{ $product["src"]='/Common/images/not-pic.jpg'; } $product["title"]=substr_cut($product["Title"],18); $product["desc"]=substr_cut($product["Description"],max); $product["keyword"]=substr_cut($product["Keyword"],max); $product["link"]=get_url($product['ClassID'],$product["ID"]); $product["id"]=$product["ID"]; foreach ($product["content_on_type"] as $key => $value) { $product[$value['typeremark']]=$value['typevalue']; } ?><dd><a href="<?php echo ($product["link"]); ?>"><?php echo ($product["title"]); ?></a></dd><?php endforeach;?>
            </dl> -->
            <dl>
                <dt>Related link</dt>
                <?php $data=M('link')->where(array('is_show'=>1,'Edition'=>C('EDITION')))->limit()->order('linkorder')->select();foreach ($data as $fdlink):$fdlink["name"]=$fdlink["linkname"];$fdlink["link"]=$fdlink["linkurl"];$fdlink["src"]="/Upload".$fdlink["linkpic"];?><dd><a href="<?php echo ($fdlink["link"]); ?>" target="_blank"><?php echo ($fdlink["name"]); ?></a></dd><?php endforeach;?>
            </dl>
        </div>

        <div class="contact">
            <em>Follow us</em>
            <img src="<?php echo C('TMURL');?>/images/ewm.jpg" height="118" width="118" alt="微信二维码" title="微信二维码" class="left">
            <p class="right">
                Tel：<?php echo ($tel); ?><br>
            Mobile：<?php echo ($phone); ?><br>
            E-mail：<?php echo ($email); ?><br>
           Address：<?php echo ($address); ?>
            </p>
        </div>
    </div>
</div>

<div class="bottom pc">
    <div class="wrap">
        <p class="left">Copyright：<a href="index.html" target="_blank"><?php echo ($sitename); ?></a>&nbsp;&nbsp;&nbsp;<a href="http://www.miitbeian.gov.cn/" target="_blank"><?php echo ($beian); ?></a> </p>
        <em class="right">Hotline：<?php echo ($tel); ?></em>
    </div>
</div>
<!-- pc 底部 end -->

<!-- wap 底部 begin -->
<div class="footer wap">
	<div class="wrap">
    	
    
        
        <!--联系 -->
        <div class="contact-way left">
        	<span class="title">联系方式</span>
            <p class="lx01">地址：<?php echo ($address); ?></p>
        	<p class="lx02">销售热线：<?php echo ($tel); ?>
            <p class="lx04">手机：<a href="tel:{18751152399}"><?php echo ($phone); ?></a></p>
            <p class="lx03">E-mail：<?php echo ($email); ?></p>

        </div>
        <!--联系 -->
            <!--版权 -->
        <div class="copyright left">
            <p>版权所有 © 2017 <?php echo ($sitename); ?> </p>
            <p><?php echo ($beian); ?> </p>
        </div>
        <!--版权 -->
        <!--联系 -->
        <!--联系 -->
        
    </div>
</div>
<!-- wap 底部 end -->


<!--wap 导航 -->
<!-- <div class="wap-nav wap">
	<button type="button" class="drawer-toggle drawer-hamburger">
		<span class="drawer-hamburger-icon"></span>
	</button>
</div> -->
<!--wap 导航 -->

<div class="clear"></div>

<!--wap 导航弹出 -->
<!-- <nav class="drawer-nav" role="navigation">
	<ul>
		<li><em><a href="<?php echo U('/index');?>">网站首页</a></em></li>
                       <?php
 $nav=blnav(); import("Class.expand",APP_PATH); $object = new \Expand(); $_navlist=$object->menu_arr($nav); $towpath=M("class")->field('path')->where('ID='.$_GET['cid'].'')->find(); $towpath['path']=explode(',',$towpath['path']); foreach($_navlist as $menulist): $pos=in_array($menulist['ID'],$towpath['path']); $menulist['current']=''; if($menulist['ID']==$_GET['cid'] || $pos !==false){ $menulist['current']="class='now'"; } ?><li><em><a href="<?php echo ($menulist["link"]); ?>"><?php echo ($menulist["name"]); ?></a></em></li><?php endforeach;?>
	</ul>
</nav> -->
<!--wap 导航弹出 -->






<!--公用 -->
<script src="<?php echo C('TMURL');?>/js/pc-slide-js.js"></script>
<script src="<?php echo C('TMURL');?>/js/wap-slide-js.js"></script>
<script src="<?php echo C('TMURL');?>/js/wap-slide-js1.js"></script>

<!--导航 -->
<script>
    $(document).ready(function() {
      $('.drawer').drawer();
    });
</script>
<script type="text/javascript">
        var $311 = $;
    </script>
    <script type="text/javascript">
        console.log($311.fn.jquery);
    </script>
<script type="text/javascript">
var $a=$("intro .buttons a");
var $s=$("intro .buttons span");
var cArr=["p7","p6","p5","p4","p3","p2","p1"];
var index=0;
$(".next").click(
    function(){
    nextimg();
    }
)
$(".prev").click(
    function(){
    previmg();
    }
)
//上一张
function previmg(){
    cArr.unshift(cArr[6]);
    cArr.pop();
    //i是元素的索引，从0开始
    //e为当前处理的元素
    //each循环，当前处理的元素移除所有的class，然后添加数组索引i的class
    $(".intro .box li").each(function(i,e){
        $(e).removeClass().addClass(cArr[i]);
    })
    index--;
    if (index<0) {
        index=6;
    }
    show();
}

//下一张
function nextimg(){
    cArr.push(cArr[0]);
    cArr.shift();
    $(".intro .box li").each(function(i,e){
        $(e).removeClass().addClass(cArr[i]);
    })
    index++;
    if (index>6) {
        index=0;
    }
    show();
}

//通过底下按钮点击切换
$a.each(function(){
    $(this).click(function(){
        var myindex=$(this).index();
        var b=myindex-index;
        if(b==0){
            return;
        }
        else if(b>0) {
            /*
             * splice(0,b)的意思是从索引0开始,取出数量为b的数组
             * 因为每次点击之后数组都被改变了,所以当前显示的这个照片的索引才是0
             * 所以取出从索引0到b的数组,就是从原本的这个照片到需要点击的照片的数组
             * 这时候原本的数组也将这部分数组进行移除了
             * 再把移除的数组添加的原本的数组的后面
             */
            var newarr=cArr.splice(0,b);
            cArr=$.merge(cArr,newarr);
            $(".intro .box li").each(function(i,e){
            $(e).removeClass().addClass(cArr[i]);
            })
            index=myindex;
            show();
        }
        else if(b<0){
            /*
             * 因为b<0,所以取数组的时候是倒序来取的,也就是说我们可以先把数组的顺序颠倒一下
             * 而b现在是负值,所以取出索引0到-b即为需要取出的数组
             * 也就是从原本的照片到需要点击的照片的数组
             * 然后将原本的数组跟取出的数组进行拼接
             * 再次倒序,使原本的倒序变为正序
             */
            cArr.reverse();
            var oldarr=cArr.splice(0,-b)
            cArr=$.merge(cArr,oldarr);
            cArr.reverse();
            $(".intro .box li").each(function(i,e){
            $(e).removeClass().addClass(cArr[i]);
            })
            index=myindex;
            show();
        }
    })
})

//改变底下按钮的背景色
function show(){
        $($s).eq(index).addClass("blue").parent().siblings().children().removeClass("blue");
}

//点击class为p2的元素触发上一张照片的函数
$(document).on("click",".p2",function(){
    previmg();
    return false;//返回一个false值，让a标签不跳转
});

//点击class为p4的元素触发下一张照片的函数
$(document).on("click",".p4",function(){
    nextimg();
    return false;
});

//          鼠标移入box时清除定时器
$(".intro .box").mouseover(function(){
    clearInterval(timer);
})

//          鼠标移出box时开始定时器
$(".intro .box").mouseleave(function(){
    timer=setInterval(nextimg,4000);
})

//          进入页面自动开始定时器
timer=setInterval(nextimg,4000);
</script>
</body>
</html>