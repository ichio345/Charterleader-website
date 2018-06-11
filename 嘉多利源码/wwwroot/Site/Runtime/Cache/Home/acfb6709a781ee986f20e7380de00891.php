<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"> 

<meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=yes">  
<meta http-equiv = "X-UA-Compatible" content = "IE=edge,chrome=1" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="">
<meta name="format-detection" content="telephone=no">
<title>苏州嘉多利精密电子有限公司</title>
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
                <li  class="on"><a href="<?php echo U('/index');?>">中文</a></li>
                <li><a href="">|</a></li>
                <li><a href="<?php echo U('Common/lang',array('lng'=>'en'));?>">ENGLISH</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <!-- 语言版本 end -->

    </div>

</div>
        <!-- 手机语言版本 begin -->
    <div class="lang-ver1">
            <ul class="ver">
                <li  class="on"><a href="<?php echo U('/index');?>"><img src="<?php echo C('TMURL');?>/images/cn.png"  alt="中文版">中文</a></li>
                <li><a href="<?php echo U('Common/lang',array('lng'=>'en'));?>"><img src="<?php echo C('TMURL');?>/images/en.png"  alt="English">EN</a></li>
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
            <li><em><a href="<?php echo U('/index');?>" <?php if($_GET['cid']==""){ ?>class="now"<?php } ?>>网站首页</a></em></li>
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

<?php if($_GET['cid'] == 244): else: ?>
    <div id="slideBox" class="slideBox">
            <div class="bd">
                <ul>
                    <?php $data=M("slide")->where(array("is_index"=>"1","Edition"=>1))->limit()->order("sort")->select();foreach($data as $banner):$banner["src"]="/Upload".$banner["PicUrl"];$banner["link"]=$banner["LinkUrl"];$banner["title"]=$banner["Title"];$banner["ID"]=$banner["ID"];$banner["desc"]=substr_cut($banner["Desc"],max)?><li>
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
                    <?php $data=M("slide")->where(array("is_index"=>"1","Edition"=>1))->limit()->order("sort")->select();foreach($data as $banner):$banner["src"]="/Upload".$banner["PicUrl"];$banner["link"]=$banner["LinkUrl"];$banner["title"]=$banner["Title"];$banner["ID"]=$banner["ID"];$banner["desc"]=substr_cut($banner["Desc"],max)?><li>
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
          	mainCell:".bd ul",mainCell:".bd ul",
                effect:"leftLoop",
               delayTime:800,
               interTime:5500,
              autoPlay:true,//自动播放
              mouseOverStop:true});  
		
            
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
        <li><a href="<?php echo U('/index');?>">网站首页</a></li>
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
        	<?php $where=""; $where2=array( "path"=>array('like',"%240%") ,"Edition"=>C('EDITION') ,"is_index"=>1 ); if(!myempty($where)){ $data=D("Product")->where($where2)->where($where)->limit(20)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); }else{ $data=D("Product")->where($where2)->limit(20)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); } foreach ($data as $product) : $piclist=explode("###",$product['Thumbnail'])[$product['Cover']]; $picpath='Upload'.$piclist; if(!empty($piclist) && file_exists($picpath)){ $product["src"]='/Upload'.$piclist; }else{ $product["src"]='/Common/images/not-pic.jpg'; } $product["title"]=substr_cut($product["Title"],18); $product["desc"]=substr_cut($product["Description"],max); $product["keyword"]=substr_cut($product["Keyword"],max); $product["link"]=get_url($product['ClassID'],$product["ID"]); $product["id"]=$product["ID"]; foreach ($product["content_on_type"] as $key => $value) { $product[$value['typeremark']]=$value['typevalue']; } ?><li>
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
      slidesPerView:3,
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
            <a href="/product239.html"><h2>嘉多利测试方案</h2></a>
        </div>
        <!-- 标题 end -->

        <!-- 内容 begin-->
        <div class="test-center">
            <div class="bd">
                <a class="prev"></a>
                <a class="next"></a>
                <ul>
                   <?php $where=""; $where2=array( "path"=>array('like',"%239%") ,"Edition"=>C('EDITION') ,"is_index"=>1 ); if(!myempty($where)){ $data=D("Product")->where($where2)->where($where)->limit(20)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); }else{ $data=D("Product")->where($where2)->limit(20)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); } foreach ($data as $product) : $piclist=explode("###",$product['Thumbnail'])[$product['Cover']]; $picpath='Upload'.$piclist; if(!empty($piclist) && file_exists($picpath)){ $product["src"]='/Upload'.$piclist; }else{ $product["src"]='/Common/images/not-pic.jpg'; } $product["title"]=substr_cut($product["Title"],18); $product["desc"]=substr_cut($product["Description"],max); $product["keyword"]=substr_cut($product["Keyword"],50); $product["link"]=get_url($product['ClassID'],$product["ID"]); $product["id"]=$product["ID"]; foreach ($product["content_on_type"] as $key => $value) { $product[$value['typeremark']]=$value['typevalue']; } ?><li>
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
            <h2>嘉多利测试方案</h2>
            <p>Charter Leader Test Plan</p>
        </div>
    </div>
    <!--标题 -->
    <div class="jdl_2" style="margin-bottom:30px; overflow: hidden;">
        <div class="swiper-wrapper">
            <?php $where=""; $where2=array( "path"=>array('like',"%239%") ,"Edition"=>C('EDITION') ,"is_index"=>1 ); if(!myempty($where)){ $data=D("Product")->where($where2)->where($where)->limit(20)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); }else{ $data=D("Product")->where($where2)->limit(20)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); } foreach ($data as $product) : $piclist=explode("###",$product['Thumbnail'])[$product['Cover']]; $picpath='Upload'.$piclist; if(!empty($piclist) && file_exists($picpath)){ $product["src"]='/Upload'.$piclist; }else{ $product["src"]='/Common/images/not-pic.jpg'; } $product["title"]=substr_cut($product["Title"],18); $product["desc"]=substr_cut($product["Description"],max); $product["keyword"]=substr_cut($product["Keyword"],max); $product["link"]=get_url($product['ClassID'],$product["ID"]); $product["id"]=$product["ID"]; foreach ($product["content_on_type"] as $key => $value) { $product[$value['typeremark']]=$value['typevalue']; } ?><div class="swiper-slide">
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
    <script>
    var swiper = new Swiper('.jdl_2', {
      spaceBetween: 30,
      centeredSlides: true,
      autoplay: {
        delay:1,
        disableOnInteraction: false,
      },
     
    });
  </script>
</div>



<!--wap 测试方案 end -->


<!--产品中心 begin-->
<div class="product">
    <div class="wrap">
        <!-- 标题 begin -->
        <div class="title">
            <h2>产品中心</h2>
            <p style="font-size:12px;text-transform:uppercase;font-family:arial;">product center</p>
        </div>
        <!-- 标题 end -->

        <!-- 产品分类列表 begin -->
        <ul class="proclass-list">
        <?php $isid="302"; $id=!empty($isid)?$isid:I("get.cid");$desclen="100";$data=M("class")->where("ID=".$id)->find();$cname["src"]="/Upload".$data["Class_pic"];$cname["name"]=!myempty($data["Name"])?$data["Name"]:"产品展示";$cname["desc"]=substr_cut($data["Class_info"],$desclen);$cname["remark"]=$data["Remark"];?><li>
              <div class="detail">
                    <h3><a href=""><?php echo ($cname["name"]); ?><em><?php echo ($cname["remark"]); ?></em></a></h3>
                    <dl>
                         <dd>RF芯片的<em>Calibration、TX</em>等测试项</dd>
                         <dd>搭配治具可<em>测试PCI-e,USB,SDIO接口</em>的模块或网卡</dd>
                         <dd>能搭配<em>多种无线测量仪表</em>使用，Blue Tooth和GPS测试</dd>
                         <dd>无线网络AP/模块产品1对4自动化测试，支持<em>802.11a/b/g/n/ac’2.4G</em>测试规范</dd>
                         <dd>具备<em>以太网供连接待测，量测仪表和测试计算机，</em>具备串口供连接待测或控制屏蔽箱开合</dd>
                        
                        

                    </dl>
                    <ul class="sence">
                        <p>产品展示：</p>
                        <li><img src="<?php echo C('TMURL');?>/images/scene1.png"></li>
                        <li><img src="<?php echo C('TMURL');?>/images/scene2.png"></li>
                    </ul>
                </div>
                <a href="/product302.html" class="pic"  title="<?php echo ($cname["name"]); ?>"><img src="<?php echo ($cname["src"]); ?>" alt="<?php echo ($cname["name"]); ?>" title="<?php echo ($cname["name"]); ?>"></a>
              
            </li>
             <?php $isid="301"; $id=!empty($isid)?$isid:I("get.cid");$desclen="100";$data=M("class")->where("ID=".$id)->find();$cname["src"]="/Upload".$data["Class_pic"];$cname["name"]=!myempty($data["Name"])?$data["Name"]:"产品展示";$cname["desc"]=substr_cut($data["Class_info"],$desclen);$cname["remark"]=$data["Remark"];?><li>
             <div class="detail">
                    <h3><a href=""><?php echo ($cname["name"]); ?><em><?php echo ($cname["remark"]); ?></em></a></h3>
                    <p>专业定制各种规格的高隔离度隔离箱，满足客户现场使用环境以及测试要求，铝合金材质使用寿命长</p>
                    <dl>
                        <dd>类型：<em>手动，气动以及配合自动化使用</em>的隔离箱</dd>
                        <dd>隔离特性：<em>2.4GHz > -85dB   5.8GHz > -80dB</em></dd>
                        <dd>滤波器端口：<em>AC,DC,RJ45,USB2.0 ,USB3.0 HDMI,RS232</em>等</dd>
                    </dl>
                    <ul class="sence">
                        <p>产品展示：</p>
                        <li><img src="<?php echo C('TMURL');?>/images/scene3.png"></li>
                        <li><img src="<?php echo C('TMURL');?>/images/scene4.png"></li>
                        <li><img src="<?php echo C('TMURL');?>/images/scene5.png"></li>
                        <li><img src="<?php echo C('TMURL');?>/images/scene6.png"></li>
                    </ul>
                </div>
                <a href="/product301.html" class="pic"  title="<?php echo ($cname["name"]); ?>"><img src="<?php echo ($cname["src"]); ?>" alt="<?php echo ($cname["name"]); ?>" title="<?php echo ($cname["name"]); ?>"></a>
               
            </li>
            <?php $isid="303"; $id=!empty($isid)?$isid:I("get.cid");$desclen="100";$data=M("class")->where("ID=".$id)->find();$cname["src"]="/Upload".$data["Class_pic"];$cname["name"]=!myempty($data["Name"])?$data["Name"]:"产品展示";$cname["desc"]=substr_cut($data["Class_info"],$desclen);$cname["remark"]=$data["Remark"];?><li>
            <div class="detail">
                    <h3><a href=""><?php echo ($cname["name"]); ?><em><?php echo ($cname["remark"]); ?></em></a></h3>
                    <p>隔离隔音箱采用金属屏蔽结合吸波材吸收原理，满足客户现场使用环境以及测试要求，铝合金材质使用寿命长</p>
                    <dl>
                        <dd>电磁屏蔽效能：<em>≥-70 dB</em>  声音屏蔽效能：<em>≥-40 dB</em></dd>
                        <dd>接口： <em>RS-232C*1  USB*1 DC*2  BNC*1  卡农接口*1</em></dd>
                        <dd>输入气压：<em>5 - 10 Pa</em></dd>
                    </dl>
                    <ul class="sence">
                        <p>产品展示：</p>
                        <li><img src="<?php echo C('TMURL');?>/images/scene7.png"></li>
                        <li><img src="<?php echo C('TMURL');?>/images/scene8.png"></li>
                    </ul>
                </div>
                <a href="/product303.html" class="pic"  title="<?php echo ($cname["name"]); ?>"><img src="<?php echo ($cname["src"]); ?>" alt="<?php echo ($cname["name"]); ?>" title="<?php echo ($cname["name"]); ?>"></a>
                
            </li>
            <?php $isid="250"; $id=!empty($isid)?$isid:I("get.cid");$desclen="100";$data=M("class")->where("ID=".$id)->find();$cname["src"]="/Upload".$data["Class_pic"];$cname["name"]=!myempty($data["Name"])?$data["Name"]:"产品展示";$cname["desc"]=substr_cut($data["Class_info"],$desclen);$cname["remark"]=$data["Remark"];?><li>
             <div class="detail">
                    <h3><a href=""><?php echo ($cname["name"]); ?><em><?php echo ($cname["remark"]); ?></em></a></h3>
                    <p>可以定制各种射频测试与功能测试治具，亦可搭配我司隔离箱实现高精度的测试，提升测试良率和效率</p>
                    <dl>
                        <dd>适用产品：<em>手机，路由器，遥控器，WIFI模块</em>等各种电子产品</dd>
                    </dl>
                    <ul class="sence">
                        <p>产品展示：</p>
                        <li><img src="<?php echo C('TMURL');?>/images/scene9.png"></li>
                        <li><img src="<?php echo C('TMURL');?>/images/scene10.png"></li>
                        <li><img src="<?php echo C('TMURL');?>/images/scene11.png"></li>
                        <li><img src="<?php echo C('TMURL');?>/images/scene12.png"></li>
                    </ul>
                </div>
                <a href="/product250.html" class="pic"  title="<?php echo ($cname["name"]); ?>"><img src="<?php echo ($cname["src"]); ?>" alt="<?php echo ($cname["name"]); ?>" title="<?php echo ($cname["name"]); ?>"></a>
               
            </li>
        </ul>
        <!-- 产品分类列表 end -->

        <ul class="button">
            <li><a href="/productt240.html">更多产品 +</a></li>
            <li><a href="/aboutt244.html">在线订购 +</a></li>
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
            <h2>"质"赢天下</h2>
            <p>QUALITY WINS THE WORLD</p>
        </div>
    </div>
    <!--标题 -->
    
    <!--内容 -->
    <div class="box bd">
        <ul class="ad-list">
            <li>
                <div class="left">
                    <h3>实力 • 雄厚</h3>
                    <em>十年专注无线测试</em>
                    <p>嘉多利精密电子有限公司专注无线测试领域十多年，产品涉及IoT物联网测试方案、自动化测试方案、1对多量产测试方案、高隔离度隔离箱、无线测试设备、治夹具等广泛领域。凭借前瞻决 策、扎根科技和专业制造，嘉多利集团不断创新、发展壮大，时刻保持着最强势的市场竞争力，助力2025中国制造！</p>
                </div>
                <img src="<?php echo C('TMURL');?>/images/ad1.png" alt="" title="">
            </li>
            <li>
                <div class="left">
                     <h3>实力 • 雄厚</h3>
                    <em>十年专注无线测试</em>
                    <p>嘉多利精密电子有限公司专注无线测试领域十多年，产品涉及IoT物联网测试方案、自动化测试方案、1对多量产测试方案、高隔离度隔离箱、无线测试设备、治夹具等广泛领域。凭借前瞻决 策、扎根科技和专业制造，嘉多利集团不断创新、发展壮大，时刻保持着最强势的市场竞争力，助力2025中国制造！</p>
                </div>
                <img src="<?php echo C('TMURL');?>/images/ad1.png" alt="" title="">
            </li>
            <li>
                <div class="left">
                     <h3>实力 • 雄厚</h3>
                    <em>十年专注无线测试</em>
                    <p>嘉多利精密电子有限公司专注无线测试领域十多年，产品涉及IoT物联网测试方案、自动化测试方案、1对多量产测试方案、高隔离度隔离箱、无线测试设备、治夹具等广泛领域。凭借前瞻决 策、扎根科技和专业制造，嘉多利集团不断创新、发展壮大，时刻保持着最强势的市场竞争力，助力2025中国制造！</p>
                </div>
                <img src="<?php echo C('TMURL');?>/images/ad1.png" alt="" title="">
            </li>
            <li>
                <div class="left">
                     <h3>实力 • 雄厚</h3>
                    <em>十年专注无线测试</em>
                    <p>嘉多利精密电子有限公司专注无线测试领域十多年，产品涉及IoT物联网测试方案、自动化测试方案、1对多量产测试方案、高隔离度隔离箱、无线测试设备、治夹具等广泛领域。凭借前瞻决 策、扎根科技和专业制造，嘉多利集团不断创新、发展壮大，时刻保持着最强势的市场竞争力，助力2025中国制造！</p>
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
    <a href="/aboutt244.html">立即咨询 +</a>
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
            <p>QUALITY WINS THE WORLD</p>
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
                    <h3>实力 • 雄厚</h3>
                    <em>十年专注无线测试</em>
                    <p>嘉多利精密电子有限公司专注无线测试领域十多年，产品涉及IoT物联网测试方案、自动化测试方案、1对多量产测试方案、高隔离度隔离箱、无线测试设备、治夹具等广泛领域。凭借前瞻决 策、扎根科技和专业制造，嘉多利集团不断不断创新、发展壮大，时刻保持着最强势的市场竞争力，助力2025中国制造！</p>
                </div>
            </li>



        </ul>
    </div>
 
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
<div class="news pc">
    <div class="wrap">
        <!--标题 -->
        <div class="title">
            <h2>新闻中心</h2>
            <p>News Center</p>
        </div>
        <!--标题 -->

        <!-- 内容 begin -->
        <div class="news-center">
            <div class="left">
            <?php $where=""; $where2=array( "path"=>array('like',"%261%") ,"Edition"=>C('EDITION') ,"is_index"=>1 ); if(!myempty($where)){ $data=M("article")->where($where2)->where($where)->limit(1)->order("Rdate DESC")->select(); }else{ $data=M("article")->where($where2)->limit(1)->order("Rdate DESC")->select(); } $datacount=count($data); $i=1; foreach ($data as $key=>$news) : $news['count']=$datacount-1; $news['desc']=substr_cut($news['Description'],60); $news['title']=substr_cut($news['Title'],50); $news['time']=$news['Rdate']; $news['i']=$i++; $news['link']=get_url($news['ClassID'],$news['ID']); $piclist=explode("###",$news['Thumbnail'])[$news['Cover']]; $picpath='Upload'.$piclist; if(!empty($piclist) && file_exists($picpath)){ $news["src"]='/Upload'.$piclist; }else{ $news["src"]='/Common/images/not-pic.jpg'; } ?><a href="<?php echo ($news["link"]); ?>" title="<?php echo ($news["title"]); ?>">
                    <img src="<?php echo ($news["src"]); ?>" alt="<?php echo ($news["title"]); ?>">
                    <em><?php echo ($news["title"]); ?></em>
                    <p><?php echo ($news["desc"]); ?></p>
                </a><?php endforeach;?>
            </div>
            
            <div class="right">
            <div class="hd">
                    <a class="prev"></a>
                    <ul></ul>
                    <a class="next"></a>
                </div>
            <div class="bd">
                <div class="ulWrap">
                
                    <ul class="news-list">
                       <?php $where=""; $where2=array( "path"=>array('like',"%260%") ,"Edition"=>C('EDITION') ,"is_index"=>1 ); if(!myempty($where)){ $data=M("article")->where($where2)->where($where)->limit(0,2)->order("Rdate DESC")->select(); }else{ $data=M("article")->where($where2)->limit(0,2)->order("Rdate DESC")->select(); } $datacount=count($data); $i=1; foreach ($data as $key=>$news) : $news['count']=$datacount-1; $news['desc']=substr_cut($news['Description'],80); $news['title']=substr_cut($news['Title'],50); $news['time']=$news['Rdate']; $news['i']=$i++; $news['link']=get_url($news['ClassID'],$news['ID']); $piclist=explode("###",$news['Thumbnail'])[$news['Cover']]; $picpath='Upload'.$piclist; if(!empty($piclist) && file_exists($picpath)){ $news["src"]='/Upload'.$piclist; }else{ $news["src"]='/Common/images/not-pic.jpg'; } ?><li>
                            <a href="<?php echo ($news["link"]); ?>" title="<?php echo ($news["title"]); ?>">
                                <img src="<?php echo ($news["src"]); ?>" alt="<?php echo ($news["title"]); ?>" title="<?php echo ($news["title"]); ?>" class="left" height="174" width="263">
                                <div class="detail right">
                                    <strong><?php echo ($news["title"]); ?></strong>
                                    <span>发布日期：<?php echo (date('Y-m-d',$news["time"])); ?></span>
                                    <p><?php echo ($news["desc"]); ?></p>
                                </div>
                            </a>
                        </li><?php endforeach;?>
                    </ul>
                    <ul class="news-list">
                       <?php $where=""; $where2=array( "path"=>array('like',"%260%") ,"Edition"=>C('EDITION') ,"is_index"=>1 ); if(!myempty($where)){ $data=M("article")->where($where2)->where($where)->limit(2,2)->order("Rdate DESC")->select(); }else{ $data=M("article")->where($where2)->limit(2,2)->order("Rdate DESC")->select(); } $datacount=count($data); $i=1; foreach ($data as $key=>$news) : $news['count']=$datacount-1; $news['desc']=substr_cut($news['Description'],100); $news['title']=substr_cut($news['Title'],50); $news['time']=$news['Rdate']; $news['i']=$i++; $news['link']=get_url($news['ClassID'],$news['ID']); $piclist=explode("###",$news['Thumbnail'])[$news['Cover']]; $picpath='Upload'.$piclist; if(!empty($piclist) && file_exists($picpath)){ $news["src"]='/Upload'.$piclist; }else{ $news["src"]='/Common/images/not-pic.jpg'; } ?><li>
                            <a href="<?php echo ($news["link"]); ?>" title="<?php echo ($news["title"]); ?>">
                                <img src="<?php echo ($news["src"]); ?>" alt="<?php echo ($news["title"]); ?>" title="<?php echo ($news["title"]); ?>" class="left" height="174" width="263">
                                <div class="detail right">
                                    <strong><?php echo ($news["title"]); ?></strong>
                                    <span>发布日期：<?php echo (date('Y-m-d',$news["time"])); ?></span>
                                    <p><?php echo ($news["desc"]); ?></p>
                                </div>
                            </a>
                        </li><?php endforeach;?>
                    </ul>
                </div>
            </div>
            </div>
        </div>
        <!-- 内容 end -->
    </div>
</div>
<!-- pc 新闻中心 end -->

<!-- wap 新闻中心 begin -->
<div class="news-center wap">
	<div class="wrap">
    	
        <!--标题 -->
        <div class="title">
            <h2>新闻中心</h2>
        	<p>News Center</p>
            
            <ul>
                <li><a href="/article260.html">业内新闻</a></li>
                <li><a href="/article261.html">公司动态</a></li>
            </ul>
        </div>
        <!--标题 -->
        
        <!--列表 -->
        <div class="list">
        	<ul>
            	<?php $where=""; $where2=array( "path"=>array('like',"%242%") ,"Edition"=>C('EDITION') ,"is_index"=>1 ); if(!myempty($where)){ $data=M("article")->where($where2)->where($where)->limit(4)->order("Rdate DESC")->select(); }else{ $data=M("article")->where($where2)->limit(4)->order("Rdate DESC")->select(); } $datacount=count($data); $i=1; foreach ($data as $key=>$news) : $news['count']=$datacount-1; $news['desc']=substr_cut($news['Description'],100); $news['title']=substr_cut($news['Title'],50); $news['time']=$news['Rdate']; $news['i']=$i++; $news['link']=get_url($news['ClassID'],$news['ID']); $piclist=explode("###",$news['Thumbnail'])[$news['Cover']]; $picpath='Upload'.$piclist; if(!empty($piclist) && file_exists($picpath)){ $news["src"]='/Upload'.$piclist; }else{ $news["src"]='/Common/images/not-pic.jpg'; } ?><li>
                	<span class="pic">
                    	<a href="<?php echo ($news["link"]); ?>"><img src="<?php echo ($news["src"]); ?>" /></a>
                    </span>
                    <span class="text">
                    	<h3><a href="<?php echo ($news["link"]); ?>"><?php echo ($news["title"]); ?></a></h3>
                        <p><?php echo ($news["desc"]); ?></p>
                        <em><?php echo (date('Y-m-d',$news["time"])); ?></em>
                    </span>
                </li><?php endforeach;?>
            </ul>
        </div>
        <!--列表 -->
        
    </div>
</div>
<!-- wap 新闻中心 end -->

<div class="clear"></div>


<!-- pc 底部 begin -->
<div class="footer pc">
    <div class="wrap">
        <div class="left fast-link">
            <dl>
                <dt>快捷链接</dt>
                <dd><a href="/about238.html">关于我们</a></dd>
                <dd><a href="/productt240.html">产品中心</a></dd>
                <dd><a href="/picture241.html">合作伙伴</a></dd>
                <dd><a href="/article242.html">新闻中心</a></dd>
                <dd><a href="/aboutt309.html">企业风采</a></dd>
                <dd><a href="/aboutt244.html">联系我们</a></dd>
            </dl>
            <dl>
                <dt>主营产品</dt>
                <?php $where=""; $where2=array( "path"=>array('like',"%240%") ,"Edition"=>C('EDITION') ,"is_index"=>1 ); if(!myempty($where)){ $data=D("Product")->where($where2)->where($where)->limit(5)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); }else{ $data=D("Product")->where($where2)->limit(5)->order("Sort DESC,ID DESC")->relation('content_on_type')->select(); } foreach ($data as $product) : $piclist=explode("###",$product['Thumbnail'])[$product['Cover']]; $picpath='Upload'.$piclist; if(!empty($piclist) && file_exists($picpath)){ $product["src"]='/Upload'.$piclist; }else{ $product["src"]='/Common/images/not-pic.jpg'; } $product["title"]=substr_cut($product["Title"],18); $product["desc"]=substr_cut($product["Description"],max); $product["keyword"]=substr_cut($product["Keyword"],max); $product["link"]=get_url($product['ClassID'],$product["ID"]); $product["id"]=$product["ID"]; foreach ($product["content_on_type"] as $key => $value) { $product[$value['typeremark']]=$value['typevalue']; } ?><dd><a href="<?php echo ($product["link"]); ?>"><?php echo ($product["title"]); ?></a></dd><?php endforeach;?>
            </dl>
            <dl>
                <dt>友情链接</dt>
                <?php $data=M('link')->where(array('is_show'=>1,'Edition'=>C('EDITION')))->limit()->order('linkorder')->select();foreach ($data as $fdlink):$fdlink["name"]=$fdlink["linkname"];$fdlink["link"]=$fdlink["linkurl"];$fdlink["src"]="/Upload".$fdlink["linkpic"];?><dd><a href="<?php echo ($fdlink["link"]); ?>" target="_blank"><?php echo ($fdlink["name"]); ?></a></dd><?php endforeach;?>
            </dl>
        </div>

        <div class="contact">
            <em>关注我们</em>
            <img src="<?php echo C('TMURL');?>/images/ewm.jpg" height="118" width="118" alt="微信二维码" title="微信二维码" class="left">
            <p class="right">
                电话：<?php echo ($tel); ?><br>
            手机：<?php echo ($phone); ?><br>
            邮箱：<?php echo ($email); ?><br>
            地址：<?php echo ($address); ?>
            </p>
        </div>
    </div>
</div>

<div class="bottom pc">
    <div class="wrap">
        <p class="left">版权所有：<a href="index.html" target="_blank"><?php echo ($sitename); ?></a>&nbsp;&nbsp;&nbsp;<a href="http://www.miitbeian.gov.cn/" target="_blank"><?php echo ($beian); ?></a> </p>
        <em class="right">销售热线：<?php echo ($tel); ?></em>
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