<?php
namespace Manage\Controller;
use Think\Controller;
class ProductController extends CommonController {
	// 调用表
	private $table="product";
	// 模型id
	private $mid=6;
	// 产品列表
	public function index(){
		$field['Edition']=session('edition');
		//获取当前模型的栏目  [后台公共函数]
		$current=currentl($field);
		$this->assign('current',$current);
		$db=M($this->table);
		//判断搜索的分类ID是否存在
		!myempty(I('classid'))?$where=array('tp_product.path'=>array('like',"%".I('classid')."%")):$where=null;
		$where['tp_product.Edition']=session('edition');
		$where['tp_product.Title']=array('like','%'.I('post.so').'%');
		//查询满足要求的总记录数
		$count=$db->where($where)->count();
		//调用分页类  传入总记录数和每页显示的记录数
		$page=Hpage($count,15);
		$show=$page->show();

		
		$field=array(
			'tp_product.ID','Title'
			,'tp_class.Name cname'
			,'tp_class.ID cid'
			,'tp_product.is_index'
			,'tp_product.Sort'
		);
		$art_list=$db->field($field)
			->join('tp_class ON tp_product.ClassID=tp_class.ID',LEFT)
			->order('Sort DESC,ID DESC')
			->where($where)
			->limit($page->firstRow.','.$page->listRows)
			->select();
		$this->assign('art_list',$art_list);
		$this->assign('show',$show);
		$this->display();
	}
	

	// 添加产品	 
	public function add_product(){
		if(myempty(I('cid'))){
			$field['Edition']=session('edition');
			//获取当前模型的栏目  [后台公共函数]
			$class=currentl($field);	
		}else{
			$class=M('class')->where('ID='.I('cid'))->select();
		}
	
		$this->assign('product',$class);
		//调用遍历属性表
   		$this->bltype=bltype($this->mid);
		$this->display();
	}

	/**
	 * 添加产品表单
	 */
	public function add_product_from(){	
		$filepath=implode("###",$_POST['filepath']);
		//判断添加的数据表是否存在 
		//如果不存在则调用 函数tablename() 来获取数据表名
		myempty($_POST['tablename'])?$tablename=tablename($_POST['classid']):$tablename=$_POST['tablename'];
		$db=M($tablename);
		$date=time();
		!myempty($_POST['auth'])?$name=$_POST['auth']:$name=$_SESSION['Uname'];
		$path=M("class")->field("path")->where("ID={$_POST['classid']}")->find();
		$field=array(
			'Name'=>$_POST['name']
			,'path'=>$path['path'].$_POST['classid'].','
			,'Title'=>$_POST['title']
			,'Content'=>$_POST['content']
			,'ClassID'=>$_POST['classid']
			,'Thumbnail'=>$filepath
			,'Rdate'=>$date
			,'Auth'=>$name
			,'Click'=>I('post.click')
			,'Edition'=>session('edition')
			,'Keyword'=>$_POST['keyword']
			,'Description'=>$_POST['description']
			,'Price'=>(float)$_POST['Price']
			,'is_index'=>(int)$_POST['is_index']
			,'Sort'=>I('Sort')
			,'Cover'=>(int)$_POST['Cover']-1
			,'tedian'=>$_POST['tedian']
			,'shuoming'=>$_POST['shuoming']
			);

		$num=$db->add($field);
		//先删除原有的属性值 
		$where=array(
			'cid'=>$num
			,'mid'=>$this->mid
		);
		M('content_on_type')->where($where)->delete();
		// 添加产品自定义属性
		foreach (I('post.class_type')['id'] as $key => $value) {
			if(!myempty(I('post.class_type')['value'][$value])){
				$data=array(
					'cid'=>$num
					,'typeid'=>$value
					,'typekey'=>I('post.class_type')['key'][$value]
					,'typeremark'=>I('post.class_type')['remark'][$value]
					,'typevalue'=>I('post.class_type')['value'][$value]=="on"?1:I('post.class_type')['value'][$value]
					,'mid'=>$this->mid
				);
			}else{
				continue;
			}
			M('content_on_type')->add($data);
		}

		$this->success('添加成功！',U("index"),	1);
	}

	// 修改产品
	public function update_product(){
		!myempty($_GET['cid'])?$field=array('ID'=>$_GET['cid']):'';
		$field['Edition']=session('edition');
		//获取当前模型的栏目  [后台公共函数]
		$this->class=currentl($field);
		$db=M($this->table);
		$num=array('tp_product.ID'=>$_GET['aid']);
		$field=array('tp_class.Name cname'
			,'Title'
			,'Thumbnail'
			,'Content'
			,'Auth'
			,'Keyword'
			,'Price'
			,'Click click'
			,'Description'
			,'tp_product.ID aid'
			,'tp_product.ClassID cid'
			,'tp_product.Sort'
			,'is_index is_index'
			,'Cover'
			,'tedian'
			,'shuoming'
		);

		$up_art=$db->field($field)->join('tp_class ON tp_product.ClassID=tp_class.ID',LEFT)->where($num)->find();
		$this->Thumbnail_list=explode("###", $up_art['Thumbnail']);
		$this->assign('up_art',$up_art);
		$where=array(
			'cid'=>I('get.aid')
			,'mid'=>$this->mid
		);
		$class_type_list=M('content_on_type')->field('cid',true)->where($where)->select();
		$this->assign('type_list',$class_type_list);
		//调用遍历属性表
   		$this->bltype=bltype($this->mid);
		$this->display();
	
	}

	/**
	 * 修改产品提交表单
	 */ 
	public function update_product_form(){
		if(!myempty($_POST['artid'])){
			$filepath=implode("###",$_POST['filepath']);
			$db=M($this->table);
			$num=array('ID'=>$_POST['artid']);
			$date=time();
			//获取最新的path
			$path=M("class")->field("path")->where("ID={$_POST['classid']}")->find();
			!myempty($_POST['auth'])?$name=$_POST['auth']:$name=$_SESSION['Uname'];
			$field=array(
				'Title'=>$_POST['title']
				,'path'=>$path['path'].$_POST['classid'].','
				,'Content'=>$_POST['content']
				,'ClassID'=>$_POST['classid']
				,'Thumbnail'=>$filepath
				,'Auth'=>$name
				,'Click'=>I('post.click')
				,'Rdate'=>$date
				,'Edition'=>session('edition')
				,'Keyword'=>$_POST['keyword']
				,'Description'=>$_POST['description']
				,'Price'=>(int)$_POST['Price']
				,'is_index'=>(int)$_POST['is_index']
				,'Sort'=>I('Sort')
				,'Cover'=>(int)$_POST['Cover']-1
				,'tedian'=>$_POST['tedian']
				,'shuoming'=>$_POST['shuoming']
				,);
			$db->where($num)->save($field);

			//先删除原有的属性值 
			$where=array(
				'cid'=>I('post.artid')
				,'mid'=>$this->mid
			);
			M('content_on_type')->where($where)->delete();
			$data='';
			// 添加产品自定义属性
			foreach (I('post.class_type')['id'] as $key => $value) {
				if(!myempty(I('post.class_type')['value'][$value])){
					$data=array(
						'cid'=>I('artid')
						,'typeid'=>$value
						,'typekey'=>I('post.class_type')['key'][$value]
						,'typeremark'=>I('post.class_type')['remark'][$value]
						,'typevalue'=>I('post.class_type')['value'][$value]=="on"?1:I('post.class_type')['value'][$value]
						,'mid'=>$this->mid
					);
					M('content_on_type')->add($data);
				}else{
					continue;
				}
			}
			$this->success('修改成功！',U('index',array('classid'=>$_POST['ysclassid'],'p'=>$_POST['p'] )),1);
		}	
	}

	//删除产品
	public function delete_product(){
		if(!myempty($_GET['aid']) || !myempty($_POST['del'])){
			$db=M($this->table);
			//将获取的数组转化成字符串
			$del=implode(',',$_POST['del']);
			//判断删除是多条还是一条
			!myempty($_GET['aid'])?$where=array('ID'=>$_GET['aid']):$where=array('ID'=>array('in',$del));
			$num=$db->where($where)->delete();
			if($num){
				if($num==1 && $_GET['bz']==1){
					$this->success('成功删除'.$num.'篇产品',U('index',array('classid'=>$_GET['ysclassid'],'p'=>$_GET['p'] )),1);	
				}else{
					$this->success('成功删除'.$num.'篇产品',U('index',array('classid'=>$_POST['ysclassid'],'p'=>$_POST['p'] )),1);	
				}
			}else{
				$this->error('删除失败！请重试','',1);
			}
		}
	}



	//显示产品
	public function show_product(){
		if(!myempty($_GET['aid'])){
			$db=M($this->table);
			$num=array('tp_product.ID'=>$_GET['aid']);
			$field=array('tp_class.Name cname','Rdate','Auth','Title','Content','Keyword','Description');
			$se_art=$db->field($field)->where($num)->join('tp_class ON tp_product.ClassID=tp_class.ID',LEFT)->find();
			if(!$se_art){
				$this->error('对不起找不到内容！',U("index"),1);
			}
			$this->Rdate=date('Y-m-d H:i:s',$se_art['Rdate']);	
			$this->assign('se_art',$se_art);	
		}
		$this->display();
	}

	//删除产品图片
	public function del_pic(){
		$db=M($this->table);
		$pid=$_POST['pid'];
		$Thumbnail=$db->field("Thumbnail")->where("ID={$pid}")->find();
		$ThumbnailArr=explode("###", $Thumbnail['Thumbnail']);
		foreach ($ThumbnailArr as $k => $v) {
			if($v==$_POST['picpath']){
				unset($ThumbnailArr[$k]);
			}
		}
		$Thumbnail_list=implode("###", $ThumbnailArr);
		$data['Thumbnail']=$Thumbnail_list;
		$num=$db->where("ID={$pid}")->save($data);
		echo $num;	
	}

	//更新产品的排序
	public function ajax_sort_product(){
		if(!myempty(I('id'))){
			$data=M($this->table)->where('ID='.I('id'))->save(array('Sort'=>I('Sort')));
			echo $data;
		}
		
	}

	//产品分类
//	public function product_class(){
//		$column=$this->common_fl(); 
//		$for=$column;
//		遍历得到的数组 为数组添加一个当前栏目下有多少内容的字段
//		foreach ($for as $key=>$value) {
//			$num=null;
//			$num=M($value["TableName"])->where(array("ClassID"=>$value['ID']))->count();
//			$value['contentNum']=$num;
//			$value['curl']=U(ucwords($value['mname']).'/index',array('classid'=>$value['ID']));
//			$column[$key]=$value;
//		} 
//		$this->Pclass= $column;	
//		p($this->Pclass);	
//		$this->display();
//	}

	public function product_class(){
		$column=$this->common_fl(); 
		$for=$column;
		//遍历得到的数组 为数组添加一个当前栏目下有多少内容的字段
		//foreach ($for as $key=>$value) {
//			$num=null;
//			$num=M($value["TableName"])->where(array("ClassID"=>$value['ID']))->count();
//			$value['contentNum']=$num;
//			$value['curl']=U(ucwords($value['mname']).'/index',array('classid'=>$value['ID']));
//			$column[$key]=$value;
//		} 
		$this->Pclass= $column;	
		//p($this->Pclass);	
		$this->display();
	}

	//添加产品分类
	public function add_product_class(){
		$this->djclass=M("class")->field('ID')->where("depth=1 and ModelID=6 and Edition=".session('edition'))->find();
		//p($this->djclass);
		$this->Pclass=$this->common_fl(C('ClumnPath')); 
		//p($this->Pclass);
		//获取当前分类深度
   		$this->depth=M('class')->field("depth")->where("ID={$_GET['cid']}")->find();
		$this->display();
	}

	//添加产品分类表单
	public function add_product_class_from(){
		if(!myempty($_POST['name'])){
			//判断是否要添加水印
			$filepath=implode("###",$_POST['filepath']);
			// 查找模板
			$temp=M('model')->field('systemplist,systempshow')->where('ID='.I('post.ModelID'))->find();
			$systemplist=!myempty(I('post.systemplist'))?I('post.systemplist'):$temp['systemplist'];
			$systempshow=!myempty(I('post.systempshow'))?I('post.systempshow'):$temp['systempshow'];

			$class=M('class');
			if($_POST['classid']!=0){
				//查找父类的路径
				$path=$class->field("path,depth")->where("ID={$_POST['classid']}")->find();
				//连接父类的路径
				$field['path']=$path['path'].$_POST['classid'].',';
				$field['depth']=$path['depth']+1;
			}

			$field['Edition']=session('edition');
			$field['Name']=$_POST['name'];
			$field['ModelID']=$_POST['ModelID'];
			$field['Class_pic']=$filepath;
			$field['Status']=$_POST['Status'];
			$field['PID']=$_POST['classid'];
			$field['systemplist']=$systemplist;
			$field['systempshow']=$systempshow;
			//为父类添加子类的个数
			$class->where("ID={$_POST['classid']}")->setInc('Child',1);
			$num=$class->add($field);
			if($num){
				$this->success('添加成功！',U('Product/product_class'),1);
			}else{
				$this->error('添加失败！','',1);
			}	
		}else{
			$this->error('分类名称不能为空！');
		}
	}

	//修改产品分类
	public function update_product_class(){
		if(!myempty($_GET['cid'])){
			$this->djclass=M("class")->field('ID,Name')->where("depth=1 and ModelID=6 and Edition=".session('edition'))->select();
			$db=M('class');
			$this->proclass=$db->where("ID={$_GET['cid']}")->find();
			if($this->proclass['Child']>0){
				$newdepth=C('ClumnPath')-(C('ClumnPath')-$this->proclass['depth']+1);
			}else{
				$newdepth=C('ClumnPath');
			}
			//获取分类
			$this->Pclass=$this->common_fl($newdepth);
			$this->Thumbnail_list=explode("###", $this->proclass['Class_pic']);
		}

		$this->display();
	}

	//修改产品分类表单
	public function update_product_class_from(){
		$db=M("class");
		$pid=$db->field("PID")->where("ID={$_POST['cid']}")->find();
		if(!myempty($_POST['name'])){
			$filepath=implode("###",$_POST['filepath']);
			$depth=$db
			->field('depth')
			->where("ID={$_POST["classid"]}")
			->find();
			$depth['depth']+=1;	
			//查找父类的路径
			$path=$db->field("path")->where("ID={$_POST['classid']}")->find();
			//连接父类的路径
			$data['path']=$path['path'].$_POST['classid'].',';

			$field=array("ID"=>$_POST['cid']);
			$data['Name']=$_POST['name'];
			$data["PID"]=$_POST['classid'];
			$data['Class_pic']=$filepath;
			$data['depth']=$depth['depth'];
			$data['Status']=$_POST['Status'];	
			$where=array("ClassID"=>$_POST['cid']);

			$data['ModelID']=6;
			//减去旧的父类的子分类数量
			$db->where("ID={$pid['PID']}")->setDec('Child',1);
			//给新的父类加上一个子分类数量
			$db->where("ID={$_POST['classid']}")->setInc('Child',1);
			$up=$db->where($field)->save($data);
			if($up){
				$where=null;
				$pid['PID']==0?$pid['PID']='':$pid['PID'].=',';
				$where['path']=array('like',array("%{$_POST['cid']},%","%{$pid['PID']}%"),'AND');
				//查找该分类下的所有子分类 并放入数组
				$pathArr=$db->field('ID,PID')->where($where)->order("depth")->select();
				//遍历更新子栏目的路径
				foreach ($pathArr as $v) {
					$this->uppath($v['ID'],$v['PID']);
				}
				//die();
				$this->success("修改成功！",U("Product/product_class"),1);
			}else{
				$this->error("修改失败",'',1); 
			}	
							
		}
	}

	//删除栏目
	public function del_class(){
		$db=M("class");
		$data=$db->field('PID')->where("ID={$_GET['cid']}")->find();
		if($data['PID']!=0){
			$db->where("ID={$data['PID']}")->setDec('Child',1);
		}		
		if(!myempty($_GET['cid'])){
			$db=M("class");
			$field=array("ID"=>$_GET['cid']);
			$num=$db->where($field)->delete();
			M('class_on_type')->where('cid='.$_GET['cid'])->delete();
			if($num){
				$this->success("删除成功");
			}else{
				$this->error("删除失败");
			}
		}
	}

	// 移动产品的内容
	public function move_product(){
		$field['Edition']=session('edition');
		//获取当前模型的栏目  [后台公共函数]
		$this->class=currentl($field);
		$this->moveid=I('moveid');
		$this->display();
	}

	// 移动产品的内容表单
	public function move_product_form(){
		//获取最新的path
		$path=M("class")->field("path")->where("ID={$_POST['classid']}")->find();
		$where['ID']=array('in',I("moveid"));
		$data=array(
			'ClassID'=>I('classid')
			,'path'=>$path['path'].I('classid').','
		);
		$num=M("product")->where($where)->save($data);
		if($num){
			$this->success("移动成功！",U('index'));
		}else{
			$this->error("移动失败，请重试！");
		}
	}

	/**
	 * [uppath 更新子分类的路径]
	 * @param  [type] $cid     [要修改的分类ID]
	 * @param  [type] $classid [上级分类ID]
	 * @return [type]          [description]
	 */
	private function uppath($cid,$classid){
		$db=M('class');
		//查找父类的路径
		$path=$db->field("path,depth")->where("ID={$classid}")->find();
		//连接父类的路径
		$data['path']=$path['path'].$classid.',';
		$data['depth']=$path['depth']+1;
		$db->where("ID={$cid}")->save($data);
	}

	/**
	 * [common_fl 返回产品分类]
	 * @param  string $maxpath [传入分类的最大深度  可以为空]
	 * @return [type]          [返回产品分类]
	 */
	private function common_fl($maxpath=''){
		$where=array('Edition'=>session('edition'),'ModelID=6');
		myempty($maxpath)?$where['depth']=array('gt',1):$where['depth']=array(array('gt',1),array('elt',$maxpath));
		$column=D("Column")
			->relation("model")
			->where($where)
			->order('Sort')
			->select();
			//p($column);
		$proid=M('class')->field('ID')->where(array('Edition'=>session('edition'),'ModelID'=>6,'PID'=>0))->select();	
		
			import("Class.expand",APP_PATH);
	   		$object = new \Expand();
			
		$result = array();
		foreach ($proid as $k => $v) {
			$arr = $object->yiwei($column,"ID",'<span>&nbsp;-&nbsp;</span>',$v['ID']);
			
			$result = array_merge($result,$arr);
		}
		
//	   	return $object->yiwei($column,"ID",'<span>&nbsp;-&nbsp;</span>',$proid['ID']);
		return $result;
	}

	//更新栏目的排序
	public function sort_column(){
		$db=M("class");
		$num=0;
		foreach ($_POST as $id => $sort) {
			$num+=$db->where(array('ID'=>(int)$id))->setField('Sort',(int)$sort);
		}
		if($num){
			$this->success('成功更新了'.$num.'条数据！',U('Product/product_class'),1);
		}else{
			$this->error('未更新任何数据！',U('Product/product_class'),1);
		}
	}


	// 更新点击显示与关闭
	public function ajax_click_product(){
		if(!myempty(I('id'))){
			$sql='UPDATE __TABLE__ SET `is_index`=ABS(is_index-1) WHERE ( ID='.I('id').' )';
			$data=M($this->table)->execute($sql);
			echo $data;
		}
	}
	

}