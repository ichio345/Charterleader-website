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

<div class="clear"></div>

<!--pc 精品推荐 begin-->
<div class="product-recommend pc">
	
    <!--图片 -->
    <div class="bd wrap">
    	<ul>
        	<?php $where=""; $where2=array( "path"=>array('like',"%264%") ,"Edition"=>C('EDITION') ,"is_index"=>1 ); if(!myempty($where)){ $data=D("Product")->where($where2)->where($where)->limit(20)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); }else{ $data=D("Product")->where($where2)->limit(20)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); } foreach ($data as $product) : $piclist=explode("###",$product['Thumbnail'])[$product['Cover']]; $picpath='Upload'.$piclist; if(!empty($piclist) && file_exists($picpath)){ $product["src"]='/Upload'.$piclist; }else{ $product["src"]='/Common/images/not-pic.jpg'; } $product["title"]=substr_cut($product["Title"],18); $product["desc"]=substr_cut($product["Description"],max); $product["keyword"]=substr_cut($product["Keyword"],max); $product["link"]=get_url($product['ClassID'],$product["ID"]); $product["id"]=$product["ID"]; foreach ($product["content_on_type"] as $key => $value) { $product[$value['typeremark']]=$value['typevalue']; } ?><li>
                <a href="<?php echo ($product["link"]); ?>" title="<?php echo ($product["title"]); ?>">
                       <span class="pic">
                           <p><img src="<?php echo ($product["src"]); ?>"  alt="<?php echo ($product["title"]); ?>" title="<?php echo ($product["title"]); ?>" /></p>
                       </span>
                       <span class="text">
                           <?php echo ($product["title"]); ?>
                       </span>
                </a>
            </li><?php endforeach;?>
        </ul>
    </div>
    <!--图片 -->
    
</div>
<!--pc 精品推荐 end-->

<!--wap 精品推荐 begin-->
<div class="product-recommend wap" style="overflow: hidden;">
	<div class="jdl_1" style="overflow: hidden;">
        <div class="swiper-wrapper">
           <?php $where=""; $where2=array( "path"=>array('like',"%240%") ,"Edition"=>C('EDITION') ,"is_index"=>1 ); if(!myempty($where)){ $data=D("Product")->where($where2)->where($where)->limit(20)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); }else{ $data=D("Product")->where($where2)->limit(20)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); } foreach ($data as $product) : $piclist=explode("###",$product['Thumbnail'])[$product['Cover']]; $picpath='Upload'.$piclist; if(!empty($piclist) && file_exists($picpath)){ $product["src"]='/Upload'.$piclist; }else{ $product["src"]='/Common/images/not-pic.jpg'; } $product["title"]=substr_cut($product["Title"],18); $product["desc"]=substr_cut($product["Description"],max); $product["keyword"]=substr_cut($product["Keyword"],max); $product["link"]=get_url($product['ClassID'],$product["ID"]); $product["id"]=$product["ID"]; foreach ($product["content_on_type"] as $key => $value) { $product[$value['typeremark']]=$value['typevalue']; } ?><div class="swiper-slide">
                <a href="<?php echo ($product["link"]); ?>" title="<?php echo ($product["title"]); ?>">
                    <div class="box">
                        <span class="pic">
                            <p><img src="<?php echo ($product["src"]); ?>" title="<?php echo ($product["title"]); ?>" alt="<?php echo ($product["title"]); ?>" /></p>
                        </span>
                        <span class="text">
                           <?php echo ($product["title"]); ?>
                        </span>
                    </div>
                </a>
            </div><?php endforeach;?>
        </div>
      
    </div>
</div>
<!--wap 精品推荐 end-->
<script>
    var swiper = new Swiper('.jdl_1', {
      loop:true,
      slidesPerView:2,
      spaceBetween: 30,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
       autoplay: {
	        delay: 2500,
	        disableOnInteraction: false,
	      },
     
    });
  </script>
<div class="clear"></div>
<!-- pc 测试方案 begin -->
<div class="test pc">
    <div class="wrap">
        <!-- 标题 begin -->
        <div class="title">
            <a href="/product239.html"><h2>Charter Leader’s Testing Solution</h2></a>
        </div>
        <!-- 标题 end -->

        <!-- 内容 begin-->
        <div class="test-center">
            <div class="bd">
                <a class="prev"></a>
                <a class="next"></a>
                <ul>
                   <?php $where=""; $where2=array( "path"=>array('like',"%263%") ,"Edition"=>C('EDITION') ,"is_index"=>1 ); if(!myempty($where)){ $data=D("Product")->where($where2)->where($where)->limit(20)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); }else{ $data=D("Product")->where($where2)->limit(20)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); } foreach ($data as $product) : $piclist=explode("###",$product['Thumbnail'])[$product['Cover']]; $picpath='Upload'.$piclist; if(!empty($piclist) && file_exists($picpath)){ $product["src"]='/Upload'.$piclist; }else{ $product["src"]='/Common/images/not-pic.jpg'; } $product["title"]=substr_cut($product["Title"],18); $product["desc"]=substr_cut($product["Description"],max); $product["keyword"]=substr_cut($product["Keyword"],50); $product["link"]=get_url($product['ClassID'],$product["ID"]); $product["id"]=$product["ID"]; foreach ($product["content_on_type"] as $key => $value) { $product[$value['typeremark']]=$value['typevalue']; } ?><li>
                        <a href="<?php echo ($product["link"]); ?>" title="<?php echo ($product["title"]); ?>">
                            <div class="pic">
                                <img src="<?php echo ($product["src"]); ?>" title="<?php echo ($product["title"]); ?>" alt="<?php echo ($product["title"]); ?>">
                            </div>
                            <div class="detail">
                                <em><?php echo ($product["title"]); ?></em>
                                <p><?php echo ($product["keyword"]); ?></p>
                            </div>
                        </a>
                    </li><?php endforeach;?>
                </ul>
            </div>
        </div>
        <!-- 内容 end -->
    </div>
</div>
<!-- pc 测试方案 end -->
<!--wap 测试方案 begin -->
<div class="test wap">
    <!--标题 -->
    <div class="title">
        <div class="box">
            <h2>Charter Leader’s Testing Solution</h2>
        </div>
    </div>
    <!--标题 -->
    <div class="jdl_ceshi">
        <div class="swiper-wrapper">
            <?php $where=""; $where2=array( "path"=>array('like',"%263%") ,"Edition"=>C('EDITION') ,"is_index"=>1 ); if(!myempty($where)){ $data=D("Product")->where($where2)->where($where)->limit(20)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); }else{ $data=D("Product")->where($where2)->limit(20)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); } foreach ($data as $product) : $piclist=explode("###",$product['Thumbnail'])[$product['Cover']]; $picpath='Upload'.$piclist; if(!empty($piclist) && file_exists($picpath)){ $product["src"]='/Upload'.$piclist; }else{ $product["src"]='/Common/images/not-pic.jpg'; } $product["title"]=substr_cut($product["Title"],18); $product["desc"]=substr_cut($product["Description"],max); $product["keyword"]=substr_cut($product["Keyword"],max); $product["link"]=get_url($product['ClassID'],$product["ID"]); $product["id"]=$product["ID"]; foreach ($product["content_on_type"] as $key => $value) { $product[$value['typeremark']]=$value['typevalue']; } ?><div class="swiper-slide">
                <div class="box">
                    <span class="pic">
                        <a href="<?php echo ($product["link"]); ?>">
                        <div class="more">
                            <em></em>
                        </div>
                        <img src="<?php echo ($product["src"]); ?>" />
                        </a>
                    </span>
                    <span class="text">
                        <a href="<?php echo ($product["link"]); ?>"><?php echo ($product["title"]); ?></a>
                    </span>
                </div>
            </div><?php endforeach;?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    
</div>


<script>
    var swiper = new Swiper('.jdl_ceshi', {
      spaceBetween: 30,
      centeredSlides: true,
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
     
    });
  </script>
<!--wap 测试方案 end -->


<!--产品中心 begin-->
<div class="product">
    <div class="wrap">
        <!-- 标题 begin -->
        <div class="title">
            <h2>Product Center</h2>
        </div>
        <!-- 标题 end -->

        <!-- 产品分类列表 begin -->
        <ul class="proclass-list">
        <?php $isid="272"; $id=!empty($isid)?$isid:I("get.cid");$desclen="100";$data=M("class")->where("ID=".$id)->find();$cname["src"]="/Upload".$data["Class_pic"];$cname["name"]=!myempty($data["Name"])?$data["Name"]:"Products";$cname["desc"]=substr_cut($data["Class_info"],$desclen);$cname["remark"]=$data["Remark"];?><li>
                <a href="/product302.html" class="pic"  title="<?php echo ($cname["name"]); ?>"><img src="<?php echo ($cname["src"]); ?>" alt="<?php echo ($cname["name"]); ?>" title="<?php echo ($cname["name"]); ?>"></a>
                <div class="detail">
                    <h3><a href=""><?php echo ($cname["name"]); ?><em><?php echo ($cname["remark"]); ?></em></a></h3>
                    <dl>
                         <dd>Suit for <em>Calibration, TX</em> and other testing items of RF chips</dd>
                         <dd>With fixtures it can test modules or Chips with<em> PCI-e, USB, SDIO</em> interfaces.</dd>
                         <dd>For wireless network AP/Module, it realize 1 to 4 automatic testing. <em>Support 802.11a/b/g/n/ac’2.4G</em> </dd>
                         <dd><em>Provided with Ethernet connecting to DUTs,</em> test equipment and computer. With serial port connecting DUTs or controlling shielding boxes.</dd>
                        
                        

                    </dl>
                    <ul class="sence">
                        <p>product display：</p>
                        <li><img src="<?php echo C('TMURL');?>/images/scene1.png"></li>
                        <li><img src="<?php echo C('TMURL');?>/images/scene2.png"></li>
                    </ul>
                </div>
            </li>
             <?php $isid="273"; $id=!empty($isid)?$isid:I("get.cid");$desclen="100";$data=M("class")->where("ID=".$id)->find();$cname["src"]="/Upload".$data["Class_pic"];$cname["name"]=!myempty($data["Name"])?$data["Name"]:"Products";$cname["desc"]=substr_cut($data["Class_info"],$desclen);$cname["remark"]=$data["Remark"];?><li>
                <a href="/product301.html" class="pic"  title="<?php echo ($cname["name"]); ?>"><img src="<?php echo ($cname["src"]); ?>" alt="<?php echo ($cname["name"]); ?>" title="<?php echo ($cname["name"]); ?>"></a>
                <div class="detail">
                    <h3><a href=""><?php echo ($cname["name"]); ?><em><?php echo ($cname["remark"]); ?></em></a></h3>
                    <p> Customizing highly-isolated Shielding boxes, satisfying customers’ testing environments and requirements. Boxes are made from Aluminum alloy, guaranteeing long service life</p>
                    <dl>
                        <dd>Type:<em> Manual, Pneumatic or Automatic Shielding box</em></dd>
                        <dd>Isolation：<em>2.4GHz > -85dB   5.8GHz > -80dB</em></dd>
                        <dd>Interface：<em>AC,DC,RJ45,USB2.0 ,USB3.0 HDMI,RS232</em>,etc</dd>
                    </dl>
                    <ul class="sence">
                        <p>product display：</p>
                        <li><img src="<?php echo C('TMURL');?>/images/scene3.png"></li>
                        <li><img src="<?php echo C('TMURL');?>/images/scene4.png"></li>
                        <li><img src="<?php echo C('TMURL');?>/images/scene5.png"></li>
                        <li><img src="<?php echo C('TMURL');?>/images/scene6.png"></li>
                    </ul>
                </div>
            </li>
            <?php $isid="274"; $id=!empty($isid)?$isid:I("get.cid");$desclen="100";$data=M("class")->where("ID=".$id)->find();$cname["src"]="/Upload".$data["Class_pic"];$cname["name"]=!myempty($data["Name"])?$data["Name"]:"Products";$cname["desc"]=substr_cut($data["Class_info"],$desclen);$cname["remark"]=$data["Remark"];?><li>
                <a href="/product303.html" class="pic"  title="<?php echo ($cname["name"]); ?>"><img src="<?php echo ($cname["src"]); ?>" alt="<?php echo ($cname["name"]); ?>" title="<?php echo ($cname["name"]); ?>"></a>
                <div class="detail">
                    <h3><a href=""><?php echo ($cname["name"]); ?><em><?php echo ($cname["remark"]); ?></em></a></h3>
                    <p>Shielding and soundproof boxes satisfy customers' operating environment and test requirement by combining the shielding effect of metal and the absorbing ability of absorptive material. In addition, made from Aluminum alloy enable our boxes having long service life.</p>
                    <dl>
                        <dd>Shielding:  <em>≥ -70 dB</em>, Soundproof: <em>≥ -40 dB</em></dd>
                        <dd>Interface： <em>RS-232C*1  USB*1 DC*2  BNC*1  卡农接口*1</em></dd>
                        <dd>Pneumatic input：<em>5 - 10 Pa</em></dd>
                    </dl>
                    <ul class="sence">
                        <p>product display：</p>
                        <li><img src="<?php echo C('TMURL');?>/images/scene7.png"></li>
                        <li><img src="<?php echo C('TMURL');?>/images/scene8.png"></li>
                    </ul>
                </div>
            </li>
            <?php $isid="275"; $id=!empty($isid)?$isid:I("get.cid");$desclen="100";$data=M("class")->where("ID=".$id)->find();$cname["src"]="/Upload".$data["Class_pic"];$cname["name"]=!myempty($data["Name"])?$data["Name"]:"Products";$cname["desc"]=substr_cut($data["Class_info"],$desclen);$cname["remark"]=$data["Remark"];?><li>
                <a href="/product251.html" class="pic"  title="<?php echo ($cname["name"]); ?>"><img src="<?php echo ($cname["src"]); ?>" alt="<?php echo ($cname["name"]); ?>" title="<?php echo ($cname["name"]); ?>"></a>
                <div class="detail">
                    <h3><a href=""><?php echo ($cname["name"]); ?><em><?php echo ($cname["remark"]); ?></em></a></h3>
                    <p>Available for different kinds of RF Test and functional test fixture, meanwhile customers could collocate with our shielding boxes, realizing accurately testing, raising yield rate and efficiency</p>
                    <dl>
                        <dd>Applicable Products:  <em>Smartphone, Router, Remote controller, wifi module </em>and other kinds of electronic products related to wireless or sound</dd>
                    </dl>
                    <ul class="sence">
                        <p>product display：</p>
                        <li><img src="<?php echo C('TMURL');?>/images/scene9.png"></li>
                        <li><img src="<?php echo C('TMURL');?>/images/scene10.png"></li>
                        <li><img src="<?php echo C('TMURL');?>/images/scene11.png"></li>
                        <li><img src="<?php echo C('TMURL');?>/images/scene12.png"></li>
                    </ul>
                </div>
            </li>
        </ul>
        <!-- 产品分类列表 end -->

        <ul class="button">
            <li><a href="/productt240.html">More products +</a></li>
            <li><a href="/aboutt244.html">Online order +</a></li>
        </ul>

    </div>
</div>
<!--产品中心 end-->

<div class="clear"></div>

<!--pc 质赢天下 begin -->
<div class="ad pc">
    <div class="wrap">
    
    <div class="angle"></div>
    <!--标题 -->
    <div class="title">
    	<div class="box">
            <h2>Quality wins the world</h2>
        </div>
    </div>
    <!--标题 -->
    
    <!--内容 -->
    <div class="box bd">
        <ul class="ad-list">
            <li>
                <div class="left">
                    <h3>Extensive Capability</h3>
                    <em>Decade of experiences in Wireless Testing</em>
                    <p>Charterleader Electronics has dedicated into wireless testing for more than a decade. Our products cover IOT Test solution, automatic test solution, multiple test solution for mass production, Highly-isolated shielding box, wireless test equipments, fixtures. 
                    By foresighted decision, solid technology and professional manufacture, Charter Leader Group develops  and innovates continuously. We keep the strong competitive advantages in markets meanwhile supporting Made In China 2025</p>
                </div>
                <img src="<?php echo C('TMURL');?>/images/ad1.png" alt="" title="">
            </li>
            <li>
                <div class="left">
                     <h3>Extensive Capability</h3>
                    <em>Decade of experiences in Wireless Testing</em>
                    <p>Charterleader Electronics has dedicated into wireless testing for more than a decade. Our products cover IOT Test solution, automatic test solution, multiple test solution for mass production, Highly-isolated shielding box, wireless test equipments, fixtures. 
                    By foresighted decision, solid technology and professional manufacture, Charter Leader Group develops  and innovates continuously. We keep the strong competitive advantages in markets meanwhile supporting Made In China 2025</p>
                </div>
                <img src="<?php echo C('TMURL');?>/images/ad1.png" alt="" title="">
            </li>
            <li>
                <div class="left">
                     <h3>Extensive Capability</h3>
                    <em>Decade of experiences in Wireless Testing</em>
                    <p>Charterleader Electronics has dedicated into wireless testing for more than a decade. Our products cover IOT Test solution, automatic test solution, multiple test solution for mass production, Highly-isolated shielding box, wireless test equipments, fixtures. 
                    By foresighted decision, solid technology and professional manufacture, Charter Leader Group develops  and innovates continuously. We keep the strong competitive advantages in markets meanwhile supporting Made In China 2025</p>
                </div>
                <img src="<?php echo C('TMURL');?>/images/ad1.png" alt="" title="">
            </li>
            <li>
                <div class="left">
                     <h3>Extensive Capability</h3>
                    <em>Decade of experiences in Wireless Testing</em>
                    <p>Charterleader Electronics has dedicated into wireless testing for more than a decade. Our products cover IOT Test solution, automatic test solution, multiple test solution for mass production, Highly-isolated shielding box, wireless test equipments, fixtures. 
                    By foresighted decision, solid technology and professional manufacture, Charter Leader Group develops  and innovates continuously. We keep the strong competitive advantages in markets meanwhile supporting Made In China 2025</p>
                </div>
                <img src="<?php echo C('TMURL');?>/images/ad1.png" alt="" title="">
            </li>
        </ul>
    </div>
    <div class="hd">
        <ul>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
    <a href="/aboutt244.html">Contact us +</a>
    <!--内容 -->
    </div>  
</div>
<!--pc 质赢天下 end -->


<!--wap 质赢天下 begin -->
<div class="ad wap">
    <div class="swiper-container">
    <!--标题 -->
    <div class="title">
        <div class="box">
            <h2>"质"赢天下</h2>
        </div>
    </div>
    <!--标题 -->
    
    <!--内容 -->
    <div class="ad-center">
        <ul class="ad-list">
            <li>
                <span>One<i></i></span>
                <div class="left">
                    <img src="<?php echo C('TMURL');?>/images/ad1.png" alt="" title="">
                    <h3>Extensive Capability</h3>
                    <em>Decade of experiences in Wireless Testing</em>
                    <p>Charterleader Electronics has dedicated into wireless testing for more than a decade. Our products cover IOT Test solution, automatic test solution, multiple test solution for mass production, Highly-isolated shielding box, wireless test equipments, fixtures. 
                    By foresighted decision, solid technology and professional manufacture, Charter Leader Group develops  and innovates continuously. We keep the strong competitive advantages in markets meanwhile supporting Made In China 2025</p>
                </div>
            </li>



        </ul>
    </div>
    <a href="/aboutt244.html">立即咨询 +</a>
    <!--内容 -->
    </div>  
</div>
<!--wap 质赢天下 end -->

<div class="clear"></div>



<div class="clear"></div>

<!--全国热线 -->
<div class="hot-tel wap">
	<div class="wrap">
    	<span class="text">
        	全国服务热线电话 <em><?php echo ($tel); ?></em>
        </span>
        <span class="btn">
        	<a href="/aboutt244.html">立即咨询</a>
        </span>
    </div>
</div>
<!--全国热线 -->

<div class="clear"></div>

<!-- pc 新闻中心 begin -->


<div class="clear"></div>


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