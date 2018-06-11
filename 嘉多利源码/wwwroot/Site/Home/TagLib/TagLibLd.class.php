<?php
namespace Home\TagLib;
use Think\Template\TagLib;
//自定义标签库
class TagLibLd extends TagLib {
	//语言版本
	protected $lng=EDITION;
	protected $tags=array(
		/** 
		 * 首页标签
		*/
		// 大图片
		"banner"=>array('attr'=>'desclen,where','close'=>1),
		// 关于我们 
		"about"=>array('attr'=>'len,id','close'=>0),
		// 产品列表
		"product"=>array('attr'=>'id,titlelen,limit,type,where','close'=>1),
		// 新闻列表
		"news"=>array('attr'=>'id,titlelen,limit,where','close'=>1),
		// 图片列表
		"pic"=>array('attr'=>'id,titlelen,limit','close'=>1),
		// 分类列表
		"classify"=>array('attr'=>'id,titlelen,limit','close'=>1),
		// 分类列表
		"classifyy"=>array('attr'=>'id,titlelen,limit','close'=>1),
		// 更多标签
		"more"=>array('attr'=>'id,type','close'=>1),
		/*
		 * 首页标签end 
		 */
		
		// 导航条
		"menu"=>array('attr'=>'','close'=>1),
		//产品列表页标签
		"Prolist"=>array('attr'=>'pagenum','close'=>1),
		//图片列表页标签
		"Piclist"=>array('attr'=>'pagenum','close'=>1),
		//文章列表页标签
		"Articlelist"=>array('attr'=>'pagenum','close'=>1),
		//面包屑导航标签
		"position"=>array('attr'=>'fgf','close'=>0),
		//二级栏目列表标签
		"columnList"=>array('attr'=>'type,id,show','close'=>0),
		//二级栏目列表标签
		"columnListt"=>array('attr'=>'type,id,show','close'=>0),
		//二级栏目列表标签
		"columnListtt"=>array('attr'=>'type,id,show','close'=>0),
		//分类栏目标题
		"cname"=>array('attr'=>'id,desclen','close'=>1),
		//分类栏目标题
		"bname"=>array('attr'=>'id','close'=>1),
		//分类栏目标题
		"pronum"=>array('attr'=>'id','close'=>1),
		//qq客服
		"qq"=>array('attr'=>'','close'=>0),
		//网站标题
		"siteTitle"=>array('attr'=>'','close'=>0),
		//网站标题
		"siteKeyword"=>array('attr'=>'','close'=>0),
		//网站标题
		"siteDescription"=>array('attr'=>'','close'=>0),
		//友情链接
		"fdlink"=>array('attr'=>'','close'=>1),
		//网站搜索
		"search"=>array('attr'=>'','close'=>1),
		// 整合的列表页标签 功能基本与三个列表页标签相同
		"List"=>array('attr'=>'pagenum','close'=>1) ,

	);


	/*导航条*/
	public function _menu($attr,$content){	
		$str=<<<str
<?php
		\$nav=blnav();
		import("Class.expand",APP_PATH);
        \$object = new \Expand(); 
      	\$_navlist=\$object->menu_arr(\$nav);
		//查找二级分类下的path 路径
		\$towpath=M("class")->field('path')->where('ID='.\$_GET['cid'].'')->find();
		\$towpath['path']=explode(',',\$towpath['path']);
		foreach(\$_navlist as \$menulist):			
			//查找当前的路径里是否存在导航的ID中
			\$pos=in_array(\$menulist['ID'],\$towpath['path']);
			\$menulist['current']='';
			if(\$menulist['ID']==\$_GET['cid'] || \$pos !==false){
				\$menulist['current']="class='now'";
			}
?>
str;
	 	$str.=$content;
		$str.='<?php endforeach;?>';
		return $str;

	}

	/**
	 * [_banner  首页图片切换] 
	 *
	 * 属性：
	 * @param [type] desclen   [描述长度]
	 *
	 * 调用：
	 * banner["src"]	图片
	 * banner["link"] 	链接
	 * banner["title"]	图片名
	 * banner["desc"] 	描述内容
	 * 
	 */
public function _banner($attr,$content){
		$desclen=!empty($attr['desclen'])?$attr['desclen']:'max';
        $num=$attr['limit'];
        $where=$attr['where'];
		
       
        if(!myempty($where)){
		$str='<?php $data=M("slide")->where(array("is_index"=>"1","Edition"=>'.C('EDITION').'))->where("'.$where.'")->limit('.$num.')->order("sort")->select();';	
		}else{
		$str='<?php $data=M("slide")->where(array("is_index"=>"1","Edition"=>'.C('EDITION').'))->limit('.$num.')->order("sort")->select();';
		}
		
		$str.='foreach($data as $banner):';
		$str.='$banner["src"]="'.__ROOT__.'/Upload".$banner["PicUrl"];';
		$str.='$banner["link"]=$banner["LinkUrl"];';
		$str.='$banner["title"]=$banner["Title"];';
		$str.='$banner["ID"]=$banner["ID"];';
		$str.='$banner["desc"]=substr_cut($banner["Desc"],'.$desclen.')?>';
		$str.=$content;
		$str.='<?php endforeach ?>';
		return $str;
	}


	/**
	 *  标签功能 ：获取单页描述
	 *	标签属性 ：
	 *		len (表示获取的字节数) [必填]
	 *		id  (表示获取指单页的id号) [可以为空]
	 *				{如果为空则直接获取后台勾选"显示首页"的单页内容} 
	 *  示例1：  <about len="150" id="*"/>   获取指定单页
	 *  示例2：  <about len="150" />         后台勾选"显示首页"的单页内容
	 *	ruturn   单页描述的内容
	 */
	public function _about($attr){
		$len=!myempty($attr['len'])?$attr['len']:'max';
		$id=!empty($attr['id'])?$attr['id']:0;
		!($id==0)?$where='ClassID=>'.$id:$where='is_index=>1';
		$str='<?php $about=M("about")->field("Desc")->where(array('.$where.',"Edition"=>'.C('EDITION').'))->order("ID DESC")->find();';
		$str.='echo substr_cut($about["Desc"],'.$len.');?>';
		return $str;
	}


	/*产品展示列表*/
	public function _product($attr,$content){
        $id=$attr['id'];
		//数量
		$num=$attr['limit'];
		//标题长度 如果为空则不进行截取
		$titlelen=!myempty($attr['titlelen'])?$attr['titlelen']:'max';
		//简介长度 如果为空则不进行截取
		$desclen=!myempty($attr['desclen'])?$attr['desclen']:'max';
        $keywordlen=!myempty($attr['keywordlen'])?$attr['keywordlen']:'max';
        $where=$attr['where'];
		$str='<?php $where="'.$where.'";?>';
		$str.=<<<eof
<?php


        \$where2=array(
            "path"=>array('like',"%{$id}%")
            ,"Edition"=>C('EDITION')
            ,"is_index"=>1
        );

        if(!myempty(\$where)){
            \$data=D("Product")->where(\$where2)->where(\$where)->limit($num)->order("Sort DESC,ID DESC")->relation('content_on_type')->select();
        }else{
            \$data=D("Product")->where(\$where2)->limit($num)->order("Sort DESC,ID DESC")->relation('content_on_type')->select();
        }



		foreach (\$data as \$product) :
			\$piclist=explode("###",\$product['Thumbnail'])[\$product['Cover']];
			\$picpath='Upload'.\$piclist;
			if(!empty(\$piclist) && file_exists(\$picpath)){
				\$product["src"]='__ROOT__/Upload'.\$piclist;
			}else{
				\$product["src"]='__ROOT__/Common/images/not-pic.jpg';
			}
			\$product["title"]=substr_cut(\$product["Title"],$titlelen);
			\$product["desc"]=substr_cut(\$product["Description"],$desclen);
			\$product["keyword"]=substr_cut(\$product["Keyword"],$keywordlen);
			\$product["link"]=get_url(\$product['ClassID'],\$product["ID"]);
			\$product["id"]=\$product["ID"];
			//增加的附加属性
			foreach (\$product["content_on_type"] as \$key => \$value) {
				\$product[\$value['typeremark']]=\$value['typevalue'];
			}
?>
eof;
		$str.=$content;
		$str.="<?php endforeach;?>";
		return $str;
	}

	/**
	 * [_news 首页新闻]
	 *
	 * 属性：
	 * @param [type] desclen   	[描述长度]
	 * @param [type] id   	 	[指定ID]
	 * @param [type] limit   	[调用数量]
	 * @param [type] titlelen   [标题长度]
	 * @param [type] where      [自定义where条件]
	 *
	 * 调用：
	 * $news['desc'] 		描述
	 * $news['title']		标题
	 * $news['time']		时间
	 * $news['link']		链接
	 * $news['src']			图片路径
	 * 
	 * 
	 */
	public function _news($attr,$content){
		$id=$attr['id'];
		$num=$attr['limit'];
		$titlelen=!myempty($attr['titlelen'])?$attr['titlelen']:'max';
		$desclen=!myempty($attr['desclen'])?$attr['desclen']:'max';
		$where=$attr["where"];
		$str='<?php $where="'.$where.'";?>';
		$str.=<<<eof
<?php
		\$where2=array(
			"path"=>array('like',"%{$id}%")
			,"Edition"=>C('EDITION')
			,"is_index"=>1
		);

		if(!myempty(\$where)){
		\$data=M("article")->where(\$where2)->where(\$where)->limit($num)->order("Rdate DESC")->select();	
		}else{
		\$data=M("article")->where(\$where2)->limit($num)->order("Rdate DESC")->select();	
		}
		\$datacount=count(\$data);
		\$i=1;
		foreach (\$data as \$key=>\$news) :
			\$news['count']=\$datacount-1;
			\$news['desc']=substr_cut(\$news['Description'],$desclen);
			\$news['title']=substr_cut(\$news['Title'],$titlelen);
			\$news['time']=\$news['Rdate'];
			\$news['i']=\$i++;
			\$news['link']=get_url(\$news['ClassID'],\$news['ID']);
			\$piclist=explode("###",\$news['Thumbnail'])[\$news['Cover']];
			\$picpath='Upload'.\$piclist;
			if(!empty(\$piclist) && file_exists(\$picpath)){
				\$news["src"]='__ROOT__/Upload'.\$piclist;
			}else{
				\$news["src"]='__ROOT__/Common/images/not-pic.jpg';
			}
?>
eof;
		$str.=$content;
		$str.="<?php endforeach;?>";
		return $str;
	}

	/*案例展示*/
	public function _pic($attr,$content){
		$id=!empty($attr['id'])?$attr['id']:'0';
		$titlelen=!myempty($attr['titlelen'])?$attr['titlelen']:'max';
        $desclen=!myempty($attr['desclen'])?$attr['desclen']:'max';
		$num=$attr['limit'];
		//p($data);
		$str=<<<eof
<?php
		\$where="";
		
		\$where=array(
			"path"=>array('like',"%{$id}%")
			,"Edition"=>C('EDITION')
			,"is_index"=>1
		);
		
		\$data=M('pic')->where(\$where)->limit($num)->select();
		foreach (\$data as \$pic) :
			\$pic['title']=substr_cut(\$pic['Title'],$titlelen);
			\$pic['desc']=substr_cut(\$pic['Description'],$desclen);
			\$pic['auth']=substr_cut(\$pic['Auth'],$titlelen);
			\$piclist=explode("###",\$pic['Thumbnail'])[\$pic['Cover']];
			\$picpath='Upload'.\$piclist;
			if(!empty(\$piclist) && file_exists(\$picpath)){
				\$pic["src"]='__ROOT__/Upload'.\$piclist;
			}else{
				\$pic["src"]='__ROOT__/Common/images/not-pic.jpg';
			}
			\$pic['link']=get_url(\$pic['ClassID'],\$pic['ID']);	
?>
eof;
		$str.=$content;
		$str.="<?php endforeach; ?>";
		return $str;
	}
	/**
	 * [_classify 首页分类列表]
	 *
	 * 属性：
	 * @param [type] id   	 	[指定ID]
	 * @param [type] limit   	[调用数量]
	 * @param [type] titlelen   [标题长度]
	 *
	 * 调用：
	 * $classify['title']		标题
	 * $classify['link']		链接
	 * $classify['src']			图片
	 * 
	 * 
	 */
	public function _classify($attr,$content){
		$id=$attr['id'];
		$titlelen=!myempty($attr['titlelen'])?$attr['titlelen']:'max';
		$limit=$attr['limit'];
		$desclen=!myempty($attr['desclen'])?$attr['desclen']:'max';
		$str='<?php $db=M("class");';
		$str.=<<<eof
			\$where=array('PID'=>$id);
			// 查找父类下的子分类
			\$data=\$db->where(\$where)->limit($limit)->order('sort')->select();
			foreach (\$data as \$k=>\$v):
				
				\$classify['title']=substr_cut(\$v['Name'],$titlelen);
				\$classify['link']=get_url(\$v['ID']);
				\$picpath='Upload'.\$v['Class_pic'];
				if(!empty(\$v['Class_pic']) && file_exists(\$picpath)){
					\$classify['src']='__ROOT__/Upload'.\$v['Class_pic'];
				}else{
					\$classify['src']='__ROOT__/Common/images/not-pic.jpg';
				}
				\$classify['desc']=substr_cut(\$v['Class_info'],$desclen);
			?>
eof;
		$str.=$content;
		$str.='<?php endforeach;?>';
		return $str;
	}

		public function _classifyy($attr,$content){
		$id=$attr['id'];
		$titlelen=!myempty($attr['titlelen'])?$attr['titlelen']:'max';
		$limit=$attr['limit'];
		$desclen=!myempty($attr['desclen'])?$attr['desclen']:'max';
		$str='<?php $db=M("class");';
		$str.=<<<eof
			\$where=array('PID'=>$id);
			// 查找父类下的子分类
			\$data=\$db->where(\$where)->limit($limit)->order('sort')->select();
			foreach (\$data as \$k=>\$vv):
				
				\$classifyy['title']=substr_cut(\$vv['Name'],$titlelen);
				\$classifyy['link']=get_url(\$vv['ID']);
				\$picpath='Upload'.\$vv['Class_pic'];
				if(!empty(\$vv['Class_pic']) && file_exists(\$picpath)){
					\$classifyy['src']='__ROOT__/Upload'.\$vv['Class_pic'];
				}else{
					\$classifyy['src']='__ROOT__/Common/images/not-pic.jpg';
				}
				\$classifyy['desc']=substr_cut(\$vv['Class_info'],$desclen);
			?>
eof;
		$str.=$content;
		$str.='<?php endforeach;?>';
		return $str;
	}

/**
	 *  标签功能 ：获取指定栏目名称与链接
	 *	标签属性 ：
	 *		id  	(表示获取指栏目的id号) [必填]
	 *		type 	(获取栏目的类型) 	   [可选]
	 *		
	 *  示例：  <more id='108'> </more>
	 *  ruturn   
	 *		$more['link']   url路径
	 *		$more['title']  栏目名称
	 *		$more['remark'] 栏目副标题
	 */
	public function _more($attr,$content){
		$id=$attr['id'];
		$type=$attr['type'];
		$link=get_url($id);
		$data=M("Class")->field('Name,Remark')->where('ID='.$id.'')->find();
		$title=$data['Name'];
		$remark=$data['Remark'];
		$str='<?php $more["link"]="'.$link.'"; $more["title"]="'.$title.'"; $more["remark"]="'.$remark.'";?>';
		$str.=$content;
		return $str;
	}
	

	/*产品列表页标签*/
	public function _Prolist($attr,$content){

		//标题长度
		$titlelen=$attr['titlelen'];
		//简介长度
		$desclen=!empty($attr['desclen'])>0?$attr['desclen']:0;		
		//每页显示的个数
		if(!empty($attr['pagenum'])){
			$productListNum=$attr['pagenum'];
		}
		$str = "<?php \$where='';\$db=M(\"product\");";
		$str.= "\$where['path']=array('like',\"%\".I('get.cid').\"%\");";
		$str.= "\$where['Title']=array('like',\"%\".I('title').\"%\");";
		$str.= "\$where['Edition']=C('EDITION');";
		//查询满足要求的 总记录 数 
		$str.= "\$proTotalList=\$db->where(\$where)->count();";
		// $str.= "echo \$proTotalList; ";
		$str.= "\$productListNum=".$productListNum.";?>";
	
		$str.=<<<eof
<?php

		//获取分页对象  Fpage() 调用分页类  传入总记录数和每页显示的记录数
		\$page=Fpage(\$proTotalList,\$productListNum);

		//分页跳转的时候保证查询条件 
		if(!myempty(I('title'))){			
			\$page->parameter['title']=I('title');
		}

		if(!myempty(I('cid'))){			
			\$page->parameter['cid']=I('cid');
		}
		
		// 获取分页
		
		\$num=\$proTotalList;
		
		\$pageshow=\$page->show();
		\$where['path']=array('like',"%".I('get.cid')."%");
		\$where['Title']=array('like',"%".I('title')."%");
		\$where['Edition']=C('EDITION');
		\$data=M('product')
			->where(\$where)
			->limit("\$page->firstRow,\$page->listRows")
			->order('Sort DESC,ID DESC')
			->select();
		\$key="<p style='text-align:center;font-size:14px;margin:20px 0px 0px 0px'>对不起,暂无的信息!</p>";
		if(empty(\$data)){
			echo \$key;
		}
		
	foreach (\$data as \$productList) :
		\$piclist=explode("###",\$productList['Thumbnail'])[\$productList['Cover']];
		\$picpath='Upload'.\$piclist;
		if(!empty(\$piclist) && file_exists(\$picpath)){
			\$productList["src"]="__ROOT__/".\$picpath;
		}else{
			\$productList["src"]='__ROOT__/Common/images/not-pic.jpg';
		}	
		\$productList["title"]=substr_cut(\$productList["Title"],$titlelen);
		\$productList["desc"]=substr_cut(\$productList["Description"],$desclen);
		\$productList["keyword"]=substr_cut(\$productList["Keyword"],$desclen);
		\$productList["link"]=get_url(\$productList['ClassID'],\$productList["ID"]);	
		//\$productList["num"]=\$proTotalList;	
?>
eof;
		$str.=$content;
        
		$str.="<?php endforeach; ?>";
		return $str;
        
	}






	/**
	 * [_search 搜索标签]
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _search($attr,$content){
		$str='<?php $action=U("List/product");';
		$str.=" \$name='title';";
		$str.='echo "<form action=\"$action\" method=\"post\">";?>';
		$str.=$content;
		$str.='<?php echo"</form>";?>';
		return $str;

	}




	/*文章列表页标签*/
	public function _Articlelist($attr,$content){
		//属性中的自定义 where 条件
		$where2=$attr['where'];
		//标题长度
		$titlelen=$attr['titlelen'];
		//简介长度
		$desclen=!empty($attr['desclen'])>0?$attr['desclen']:0;	
		//每页显示的个数
		if(!myempty($attr['pagenum'])){
			$ArticleListNum=$attr['pagenum'];
		}
		
		$str='<?php $db=M("article");';
		$str.='$where=array("path"=>array("like","%".I("cid")."%"),"Edition"=>C("EDITION"));';
		if(!myempty($where2)){
			$str.='$where2='.$where2.';';
			//查询满足要求的 总记录 数 
			$str.='$AtricleTotalList=$db->where($where)->where($where2)->count();'; 	
		}else{
			//查询满足要求的 总记录 数 
			$str.='$AtricleTotalList=$db->where($where)->count();'; 
		}
		//每页显示的个数
		$str.='$ArticleListNum='.$ArticleListNum.';';
		//获取分页对象  Fpage() 调用分页类  传入总记录数和每页显示的记录数
		
		$str.='$page=Fpage($AtricleTotalList,$ArticleListNum);';
		$str.='$pageshow=$page->show();?>';

		$str.=<<<eof
<?php
	if(!myempty(\$where2)){
	\$data=\$db->where(\$where)->where(\$where2)->limit("\$page->firstRow,\$page->listRows")->order('Rdate DESC')->select();
	}else{
	\$data=\$db->where(\$where)->limit("\$page->firstRow,\$page->listRows")->order('Rdate DESC')->select();	
	}
	foreach (\$data as \$articleList) :
		\$piclist=explode("###",\$articleList['Thumbnail'])[\$articleList['Cover']];
		\$picpath='Upload'.\$piclist;
		if(!empty(\$piclist) && file_exists(\$picpath)){
			\$articleList["src"]="__ROOT__/".\$picpath;
		}else{
			\$articleList["src"]='__ROOT__/Common/images/not-pic.jpg';
		}			
		\$articleList["title"]=substr_cut(\$articleList["Title"],$titlelen);
		\$articleList["desc"]=substr_cut(\$articleList["Description"],$desclen);
		\$articleList["link"]=get_url(\$articleList['ClassID'],\$articleList["ID"]);	
		\$articleList["time"]=\$articleList["Rdate"];
		\$articleList["auth"]=\$articleList['Auth'];
?>
eof;
		$str.=$content;
		$str.="<?php endforeach; ?>";
		return $str;
	}




	/*图片列表页标签*/
	public function _Piclist($attr,$content){
		//属性中的自定义 where 条件
		$where2=$attr['where'];
		//标题长度
		$titlelen=$attr['titlelen'];
		//简介长度
		$desclen=!empty($attr['desclen'])>0?$attr['desclen']:0;
		//每页显示的个数
		if(!empty($attr['pagenum'])){
			$picListNum=$attr['pagenum'];
		}
		$str='<?php $db=M("pic");';
		$str.='$where=array("path"=>array("like","%".I("cid")."%"),"Edition"=>C("EDITION"));';
		if(!myempty($where2)){
			$str.='$where2='.$where2.';';
			//查询满足要求的 总记录 数 
			$str.='$picTotalList=$db->where($where)->where($where2)->count();'; 	
		}else{
			//查询满足要求的 总记录 数 
			$str.='$picTotalList=$db->where($where)->count();'; 
		}		
		//每页显示的个数
		$str.='$picListNum='.$picListNum.';';
		//获取分页对象  Fpage() 调用分页类  传入总记录数和每页显示的记录数		
		$str.='$page=Fpage($picTotalList,$picListNum);';
		$str.='$pageshow=$page->show();?>';		
	
		$str.=<<<eof
<?php
	// 判断标签的where条件是否为空
	if(!myempty(\$where2)){
	\$data=\$db->where(\$where)->where(\$where2)->limit("\$page->firstRow,\$page->listRows")->order('Sort DESC,ID DESC')->select();
	}else{
	\$data=\$db->where(\$where)->limit("\$page->firstRow,\$page->listRows")->order('Sort DESC,ID DESC')->select();	
	}		
	foreach (\$data as \$Piclist) :
		\$piclist=explode("###",\$Piclist['Thumbnail'])[\$Piclist['Cover']];
		\$picpath='Upload'.\$piclist;
		if(!empty(\$piclist) && file_exists(\$picpath)){
			\$Piclist["src"]="__ROOT__/".\$picpath;
		}else{
			\$Piclist["src"]='__ROOT__/Common/images/not-pic.jpg';
		}			
		\$Piclist["title"]=substr_cut(\$Piclist["Title"],$titlelen);
		\$Piclist["desc"]=substr_cut(\$Piclist["Description"],$desclen);
		\$Piclist["url"]=get_url(\$Piclist['ClassID'],\$Piclist["ID"]);	
?>
eof;
		$str.=$content;
		$str.="<?php endforeach; ?>";
		return $str;
	}
	

	/**
	 * 面包屑导航
	 * [$id   	获取栏目的ID ]
	 * [$fgf  	自定义分割符 ]
	 */
	public function _position($attr,$content){
		// 获取定界符
		$fgf=!empty($attr['fgf'])?$attr['fgf']:" > ";
		$str='<?php $db=M("class");';
		$str.='$id=I("get.cid");';
		$str.='$fgf="'.$fgf.'";';
		$str.='$data=$db->where(array("ID"=>$id))->find();';
		$str.='$posid=explode(",",$data["path"]);?>';
		$str.=<<<eof
<?php

		foreach (\$posid as \$v) {
		\$where=array('ID'=>\$v);
		\$posdata=D('ColumnView')->where(\$where)->find();
		
		// 判断是否有外部的链接
		if(\$posdata['typeid']==2 && !myempty(\$posdata['typevalue'])){
			\$posurl=\$posdata['typevalue'];
			// 判断是否加分割符
			if(!myempty(\$v)){
				\$newurl="<a href='".\$posurl."'>".\$posdata['Name']."</a>".\$fgf;
			}else{
				\$newurl="<a href='".\$posurl."'>".\$data['Name']."</a>";			
			}	
			echo \$newurl;
			// 退出本次循环
			continue;					
		}

			// 判断是否有子类 如果没有则输出当前
			if(!empty(\$v)){
				if(\$posdata['PID']!=0){
					echo "<a href='".get_url(\$posdata['PID'])."'>".\$posdata['Name']."</a>".\$fgf;
				}else{
					echo "<a href='".get_url(\$posdata['ID'])."'>".\$posdata['Name']."</a>".\$fgf;
				}
			}else{
				if(empty(\$data['Name'])){
					echo "<a href='".get_url(\$id)."'>".L('sea_empty')."</a>";	
				}else{
					echo "<a href='".get_url(\$id)."'>".\$data['Name']."</a>";	
				}
				
			}
		
		}		

		
?>		
eof;
		
		return $str;
	}


	/*栏目列表
	 *
	all 	获取栏目下的所有分类 不会根据 url的cid改变而变化 
			可以传入ID 指定获取  

	now     根据分类的ID获取子分类，且只显示子分类，
			不显示其它同级或上级的分类 。可以指定ID 默认获取url的cid值 

	now_all 获取同一模块下不同的子分类  
			根据栏目的ID自动进行获取 一般用于不同的栏目使用同一个模型
 	*/
	public function _columnList($attr,$content){
		// 类型 模块 	product  pic  about  news
		// 类型模块可以不传，但是没有按模块查找的功能
		$type=$attr['type'];
		// ID
		$id=$attr['id'];
		$limit=$attr['limit'];
		// 显示类型
		$show=!empty($attr['show'])?$attr['show']:"all";
		$str='<?php $show="'.$show.'";';
		$str.='$id="'.$id.'";';
		$str.='$type="'.$type.'";';
		$str.='$db=M("class");?>';
		$str.=<<<eof
<?php
		\$isid=!myempty(\$id)?\$id:I('cid');

		\$ModelID=M("model")->field("ID")->where("Name='$type'")->find(); 
		\$column=blnav();
		if(!empty(\$type)){
			\$where=array('ModelID'=>\$ModelID['ID'],'Child'=>array('neq',0),'Status'=>1,'Edition'=>C('edition'));
		}else{
			\$where=array('Child'=>array('neq',0),'Status'=>1,'Edition'=>C('edition'));
		}
		if(\$show=="all"){
			!empty(\$id)?\$where['ID']=\$id:'';	
		}else if(\$show=="now"){
			\$where['ID']=\$isid;
		}else if(\$show=='now_all'){
			\$gid=\$_GET['cid'];
			\$data=\$db->field('path')->where('ID='.\$gid.'')->find();
			!empty(\$data['path'])?\$path=explode(',', \$data['path'])[0]:\$gid;
			\$where['ID']=\$path;
		}
		\$pid=\$db->where(\$where)->order('depth')->find();
		empty(\$pid['ID'])?\$pid['ID']=I('cid'):\$pid['ID'];
		import("Class.expand",APP_PATH);
		\$object = new \Expand();
		\$column=\$object->erwei2(\$column,'',\$pid['ID']);	
		echo classNav(\$column);
?>		
eof;
		
		return $str; 
	}


	/*栏目列表
	 *
	all 	获取栏目下的所有分类 不会根据 url的cid改变而变化 
			可以传入ID 指定获取  

	now     根据分类的ID获取子分类，且只显示子分类，
			不显示其它同级或上级的分类 。可以指定ID 默认获取url的cid值 

	now_all 获取同一模块下不同的子分类  
			根据栏目的ID自动进行获取 一般用于不同的栏目使用同一个模型
 	*/
	public function _columnListt($attr,$content){
		// 类型 模块 	product  pic  about  news
		// 类型模块可以不传，但是没有按模块查找的功能
			// 类型 模块 	product  pic  about  news
		// 类型模块可以不传，但是没有按模块查找的功能
		$type=$attr['type'];
		// ID
		$id=$attr['id'];
		$limit=$attr['limit'];
		// 显示类型
		$show=!empty($attr['show'])?$attr['show']:"all";
		$str='<?php $show="'.$show.'";';
		$str.='$id="'.$id.'";';
		$str.='$type="'.$type.'";';
		$str.='$db=M("class");?>';
		$str.=<<<eof
<?php
		\$isid=!myempty(\$id)?\$id:I('cid');

		\$ModelID=M("model")->field("ID")->where("Name='$type'")->find(); 
		\$column=blnav();
		if(!empty(\$type)){
			\$where=array('ModelID'=>\$ModelID['ID'],'Child'=>array('neq',0),'Status'=>1,'Edition'=>C('edition'));
		}else{
			\$where=array('Child'=>array('neq',0),'Status'=>1,'Edition'=>C('edition'));
		}
		if(\$show=="all"){
			!empty(\$id)?\$where['ID']=\$id:'';	
		}else if(\$show=="now"){
			\$where['ID']=\$isid;
		}else if(\$show=='now_all'){
			\$gid=\$_GET['cid'];
			\$data=\$db->field('path')->where('ID='.\$gid.'')->find();
			!empty(\$data['path'])?\$path=explode(',', \$data['path'])[0]:\$gid;
			\$where['ID']=\$path;
		}
		\$pid=\$db->where(\$where)->order('depth')->find();
		empty(\$pid['ID'])?\$pid['ID']=I('cid'):\$pid['ID'];
		import("Class.expand",APP_PATH);
		\$object = new \Expand();
		\$column=\$object->erwei2(\$column,'',\$pid['ID']);	
		echo classNavv(\$column);
?>		
eof;
		
		return $str; 
	}

	/*栏目列表
	 *
	all 	获取栏目下的所有分类 不会根据 url的cid改变而变化 
			可以传入ID 指定获取  

	now     根据分类的ID获取子分类，且只显示子分类，
			不显示其它同级或上级的分类 。可以指定ID 默认获取url的cid值 

	now_all 获取同一模块下不同的子分类  
			根据栏目的ID自动进行获取 一般用于不同的栏目使用同一个模型
 	*/
	public function _columnListtt($attr,$content){
		// 类型 模块 	product  pic  about  news
		// 类型模块可以不传，但是没有按模块查找的功能
		$type=$attr['type'];
		// ID
		$id=$attr['id'];
		$limit=$attr['limit'];
		// 显示类型
		$show=!empty($attr['show'])?$attr['show']:"all";
		$str='<?php $show="'.$show.'";';
		$str.='$id="'.$id.'";';
		$str.='$type="'.$type.'";';
		$str.='$db=M("class");?>';
		$str.=<<<eof
<?php
		\$isid=!myempty(\$id)?\$id:I('cid');

		\$ModelID=M("model")->field("ID")->where("Name='$type'")->find(); 
		\$column=blnav();
		if(!empty(\$type)){
			\$where=array('ModelID'=>\$ModelID['ID'],'Child'=>array('neq',0),'Status'=>1,'Edition'=>C('edition'));
		}else{
			\$where=array('Child'=>array('neq',0),'Status'=>1,'Edition'=>C('edition'));
		}
		if(\$show=="all"){
			!empty(\$id)?\$where['ID']=\$id:'';	
		}else if(\$show=="now"){
			\$where['ID']=\$isid;
		}else if(\$show=='now_all'){
			\$gid=\$_GET['cid'];
			\$data=\$db->field('path')->where('ID='.\$gid.'')->find();
			!empty(\$data['path'])?\$path=explode(',', \$data['path'])[0]:\$gid;
			\$where['ID']=\$path;
		}
		\$pid=\$db->where(\$where)->order('depth')->find();
		empty(\$pid['ID'])?\$pid['ID']=I('cid'):\$pid['ID'];
		import("Class.expand",APP_PATH);
		\$object = new \Expand();
		\$column=\$object->erwei2(\$column,'',\$pid['ID']);	
		echo classNavvv(\$column);
?>		
eof;
		
		return $str; 
	}	
	/**
	 * [_cname 分类栏目标题]
	 * 
	 * 属性：
	 * id  指定调用栏目的id [可以为空]
	 * 
	 */
	public function _cname($attr,$content){
		$id=$attr['id'];
        $desclen=$attr['desclen'];
        
		$str='<?php $isid="'.$id.'"; $id=!empty($isid)?$isid:I("get.cid");';
		$str.='$desclen="'.$desclen.'";';
		$str.='$data=M("class")->where("ID=".$id)->find();';
		$str.='$cname["src"]="'.__ROOT__.'/Upload".$data["Class_pic"];';
		$str.='$cname["name"]=!myempty($data["Name"])?$data["Name"]:"'.L('sea_empty').'";';
		$str.='$cname["desc"]=substr_cut($data["Class_info"],$desclen);';
		$str.='$cname["remark"]=$data["Remark"];?>';
		$str.=$content;
		return $str;
	}


	/**
	 * [_bname 分类栏目标题]
	 * 
	 * 属性：
	 * id  指定调用栏目的id [可以为空]
	 * 
	 */
	public function _bname($attr,$content){
		$id=$_GET['cid'];
		//$isid="'.$id.'"; $id=!empty($isid)?$isid:I("get.cid");
		$data=M("class")->where("ID=".$id)->find();
		if($data["depth"]==1){
			$id=$data["ID"];
		}else{
        $id=explode(',',$data["path"])[0];
        }
		
        
		$dataa=M("class")->where("ID=".$id)->find();
		$name=$dataa["Name"];
		$remark=$dataa["Remark"];
        $class_pic=$dataa["Class_pic"];
		$str='<?php $bname["name"]="'.$name.'"; $bname["remark"]="'.$remark.'"; $bname["src"]="'.__ROOT__.'/Upload'.$class_pic.'"; ?>';
		$str.=$content;
		return $str;
		
	}
    
    
    	/**
	 * [_bname 分类栏目标题]
	 * 
	 * 属性：
	 * id  指定调用栏目的id [可以为空]
	 * 
	 */
	public function _pronum($attr,$content){
		$id=$_GET['cid'];
		//$isid="'.$id.'"; $id=!empty($isid)?$isid:I("get.cid");
		$data=M("product")->where("ClassID=".$id)->count();
		
		
		$str='<?php $pronum["num"]="'.$data.'";  ?>';
		$str.=$content;
		return $str;
		
	}




	/*qq客服*/
	public function _qq($attr,$content){
$qq=<<<eof
<script type="text/javascript">
$("body").append("<div class='qq'></div>")
$('.qq').load("<?php echo U(MODULE_NAME.'/Common/qq') ?>");
</script>
eof;
		return $qq;
	}



	/**
	 * 网站标题
	 * [$id   获取栏目的ID ]
	 * [$fgf  自定义分割符 ]
	 */
	public function _siteTitle($attr,$content){
		$fgf='-';
		$str='<?php $fgf="'.$fgf.'";';
		$str.="\$db=M('class');?>";
		$str.=<<<eof
<?php

		\$data=\$db->where(array('ID'=>I('get.cid')))->find();
		/**
		*   array_reverse()  函数将原数组中的元素顺序翻转
		*	array_filter()	 用回调函数过滤数组中的单元
		*/
		\$posid=array_reverse(array_filter(explode(',',\$data['path'])));
		\$count=count(\$posid);
		if(!myempty(\$content['Title'])){
			echo \$content['Title'],\$fgf;
		}
		if(!myempty(\$data['Name'])){
			echo \$data['Name'],\$fgf;	
		}
		foreach (\$posid as \$k=>\$v) {
			\$where=array('ID'=>\$v);
			\$posdata=\$db->where(\$where)->find();
			if(\$count>\$k){
				echo \$posdata['Name'].\$fgf;
			}else{
				echo \$posdata['Name'];
			}
		}
?>
eof;
		return $str;
	}

	/**
	 * 网站标题
	 * [$id   获取栏目的ID ]
	 * [$fgf  自定义分割符 ]
	 */
	public function _siteKeyword($attr,$content){
		$fgf='-';
		$str='<?php $fgf="'.$fgf.'";';
		$str.="\$db=M('class');?>";
		$str.=<<<eof
<?php

		\$data=\$db->where(array('ID'=>I('get.cid')))->find();
		/**
		*   array_reverse()  函数将原数组中的元素顺序翻转
		*	array_filter()	 用回调函数过滤数组中的单元
		*/
		\$posid=array_reverse(array_filter(explode(',',\$data['path'])));
		\$count=count(\$posid);
		if(!myempty(\$content['Keyword'])){
			echo \$content['Keyword'],\$fgf;
		}
		if(!myempty(\$data['Name'])){
			echo \$data['Name'],\$fgf;	
		}
		foreach (\$posid as \$k=>\$v) {
			\$where=array('ID'=>\$v);
			\$posdata=\$db->where(\$where)->find();
			if(\$count>\$k){
				echo \$posdata['Name'].\$fgf;
			}else{
				echo \$posdata['Name'];
			}
		}
?>
eof;
		return $str;
	}
	
	
		/**
	 * 网站标题
	 * [$id   获取栏目的ID ]
	 * [$fgf  自定义分割符 ]
	 */
	public function _siteDescription($attr,$content){
		$fgf='-';
		$str='<?php $fgf="'.$fgf.'";';
		$str.="\$db=M('class');?>";
		$str.=<<<eof
<?php

		\$data=\$db->where(array('ID'=>I('get.cid')))->find();
		/**
		*   array_reverse()  函数将原数组中的元素顺序翻转
		*	array_filter()	 用回调函数过滤数组中的单元
		*/
		\$posid=array_reverse(array_filter(explode(',',\$data['path'])));
		\$count=count(\$posid);
		if(!myempty(\$content['Description'])){
			echo \$content['Description'],\$fgf;
		}
		if(!myempty(\$data['Name'])){
			echo \$data['Name'],\$fgf;	
		}
		foreach (\$posid as \$k=>\$v) {
			\$where=array('ID'=>\$v);
			\$posdata=\$db->where(\$where)->find();
			if(\$count>\$k){
				echo \$posdata['Name'].\$fgf;
			}else{
				echo \$posdata['Name'];
			}
		}
?>
eof;
		return $str;
	}
	
	/**
	 * [_fdlink 友情链接]
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * 
	 * 字段调用:
	 * fdlink['name']  友情链接名称
	 * fdlink['link']  友情链接路径
	 * 
	 */
	public function _fdlink($attr,$content){
		$limit=$attr['limit'];
		$str="<?php \$data=M('link')->where(array('is_show'=>1,'Edition'=>C('EDITION')))->limit($limit)->order('linkorder')->select();";
		$str.='foreach ($data as $fdlink):';
		$str.='$fdlink["name"]=$fdlink["linkname"];';
		$str.='$fdlink["link"]=$fdlink["linkurl"];';
		$str.='$fdlink["src"]="__ROOT__/Upload".$fdlink["linkpic"];?>';
		$str.=$content;
		$str.='<?php endforeach;?>';

		return $str;
	}


	/**
	 * [_List 列表页标签]  功能基本与三个列表页标签相同,但可能在用的时候会出现一些问题
	 *
	 * 属性：
	 * @type      列表类型  	值 ：文章型 article  产品型  product   图片型 pic
	 * @titlelen  标题长度
	 * @desclen   简介长度
	 * @pagenum   每页显示数量
	 *
	 * 通用字段调用：  其余字段按各个表里的字段调用
	 * 
	 * List["src"]  		图片
	 * List["title"]		标题
	 * List["desc"]			简介
	 * List["time"]			添加时间
	 * List["auth"]			作者
	 * 
	 */
	public function _List($attr,$content){

		//标题长度
		$titlelen=$attr['titlelen'];
		//简介长度
		$desclen=!empty($attr['desclen'])>0?$attr['desclen']:0;	
		//每页显示的个数
		if(!myempty($attr['pagenum'])){
			$ListNum=$attr['pagenum'];
		}
		// 判断属性中的自定义 where 条件是否存在
		$iswhere=isset($attr['where'])?$attr['where']:'';
		// 判断type属性是否为空，如果为空则提示出错
		if(myempty($attr['type'])){
			return "<p style='color:#f30;font-size:18px;text-align:center;line-height:25px;'>error: type为必填属性！</p>";
		}

		// 按标签的type 的属性查找相对应的表
		switch ($attr['type']) {
			case 'product':
				$str='<?php $db=M("product");';
				break;
			case 'pic':
				$str='<?php $db=M("pic");';
				break;
			case 'article':
				$str='<?php $db=M("article");';
				break;
		}

		$str.='$where=array("path"=>array("like","%".I("cid")."%"),"Edition"=>C("EDITION"));'	;
		!myempty($iswhere)?$str.='$where2='.$attr['where'].';':$str.='$where2="";';
		// 判断标签的where条件是否为空
		if(!myempty($iswhere)){
			//查询满足要求的 总记录 数 
			$str.='$TotalList=$db->where($where)->where($where2)->count();'; 
		}else{
			//查询满足要求的 总记录 数 
			$str.='$TotalList=$db->where($where)->count();'; 
		}
		
		//每页显示的个数
		$str.='$ListNum='.$ListNum.';';
		//获取分页对象  Fpage() 调用分页类  传入总记录数和每页显示的记录数
		
		$str.='$page=Fpage($TotalList,$ListNum);';
		$str.='$pageshow=$page->show();?>';

		$str.=<<<eof
<?php
	// 判断标签的where条件是否为空
	if(!myempty(\$where2)){
	\$data=\$db->where(\$where)->where(\$where2)->limit("\$page->firstRow,\$page->listRows")->order('Click DESC,ID DESC')->select();
	}else{
	\$data=\$db->where(\$where)->limit("\$page->firstRow,\$page->listRows")->order('Click DESC,ID DESC')->select();	
	}
	// 判断是否有数据
	if(!myempty(\$data)){
	foreach (\$data as \$List) :
		\$piclist=explode("###",\$List['Thumbnail'])[\$List['Cover']];
		\$picpath='Upload'.\$piclist;
		if(!empty(\$piclist) && file_exists(\$picpath)){
			\$List["src"]="__ROOT__/".\$picpath;
		}else{
			\$List["src"]='__ROOT__/Common/images/not-pic.jpg';
		}			
		\$List["title"]=substr_cut(\$List["Title"],$titlelen);
		\$List["desc"]=substr_cut(\$List["Description"],$desclen);
		\$List["url"]=get_url(\$List['ClassID'],\$List["ID"]));	
		\$List["time"]=date('Y-m-d',\$List["Rdate"]);
		\$List["auth"]=\$List['Auth'];
?>
eof;
		$str.=$content;
		$str.="<?php endforeach; ";
		$str.="}else{";
		$str.="echo \"<p style='text-align:center;'>对不起，暂无数据！</p>\";}?>";
		return $str;
	}


}