<?php
namespace Manage\Controller;
use Think\Controller;
/**
 * 网站栏目操作类
 */
class ColumnController extends CommonController {

	//显示栏目列表]
	public function index(){ 
		$db=M('class');
		$where=array('Edition'=>session('edition'));
		$column=D("Column")
		->relation("model")
		->where($where)
		->order('Sort')
		->select();	
		$for=$column;
		//遍历得到的数组 为数组添加一个当前栏目下有多少内容的字段
		foreach ($for as $key=>$value) {
			$num=null;
			$num=M($value["TableName"])->where(array("ClassID"=>$value['ID']))->count();
			$value['contentNum']=$num;
			$value['curl']=U(ucwords($value['mname']).'/index',array('classid'=>$value['ID']));
			$column[$key]=$value;
		}
		//p($column);
   		 /**
   		 * 调用自定义的类方法  Class\expand 下
   		 */
   		import("Class.expand",APP_PATH);
   		$object = new \Expand();
   		$column=$object->yiwei($column,"ID",'<span>&nbsp;-&nbsp;</span>');
   		$this->assign('column',$column);
$html=<<<html
	<tr><td colspan="8" align="center">暂时没有栏目！</td></tr>
html;
		 $this->assign('empty',$html);
		 
		 $this->assign('list',$column);
		//p($column);
		 $this->display();			
	}

	/**
	 * 栏目模型的公共方法
	 * @return [type] [description]
	 */
	public function selectDB(){
		$db=M('model');
		return $db->select();
	}


	//添加栏目
	public function add_class(){
		//获取当前模型的栏目 
		$column=selectCl(C('ClumnPath')+1);
		/**
		 * 调用自定义的类方法  Class\expand 下
		 */
   		import("Class.expand",APP_PATH);
   		$object = new \Expand();
   		$column=$object->yiwei($column,"cid","- ");
   		$this->class=$column;
   		//获取当前栏目深度
   		$this->depth=M('class')->field("depth")->where("ID={$_GET['cid']}")->find();
   		//调用遍历属性表
   		$this->bltype=bltype(-1);
   		$tmName=F('hxset','',CONF_PATH)['systemp'];
   		//查找模板目录下列表模板
		$pathlist='Templates/'.$tmName.'/List';
		//查找模板目录下内容页模板
		$pathshow='Templates/'.$tmName.'/Show';
		$this->systemplist=get_file($pathlist,'List');
		$this->systempshow=get_file($pathshow);

		// 查找模型
		$mlist=$this->selectDB();
		$this->assign('mlist',$mlist);
		$this->display();			
	}

	//添加栏目表单
	public function add_class_from(){	
		if(!myempty($_POST['name'])){
			
			$filepath=implode("###",$_POST['filepath']);
			$class=M('class');
			if($_POST['classid']!=0){
				//查找父类的路径
				$path=$class->field("path")->where("ID={$_POST['classid']}")->find();
				//连接父类的路径
				$field['path']=$path['path'].$_POST['classid'].',';
			}
			// 查找模板
			$temp=M('model')->field('systemplist,systempshow')->where('ID='.I('post.ModelID'))->find();
			$systemplist=!myempty(I('post.systemplist'))?I('post.systemplist'):$temp['systemplist'];
			$systempshow=!myempty(I('post.systempshow'))?I('post.systempshow'):$temp['systempshow'];
			
			$field['Edition']=session('edition');
			$field['Name']=$_POST['name'];
			$field['Remark']=$_POST['remark'];
			$field['ModelID']=$_POST['ModelID'];
			$field['depth']=$_POST['depth']+1;
			$field['Class_pic']=$filepath;
			$field['Class_info']=I('post.Class_info');
			$field['Status']=$_POST['Status'];
			$field['PID']=$_POST['classid'];
			$field['systemplist']=$systemplist;
			$field['systempshow']=$systempshow;
			//为父类添加子类的个数
			$class->where("ID={$_POST['classid']}")->setInc('Child',1);
			$num=$class->add($field);
			//先删除原有的属性值 
			M('class_on_type')->where('cid='.$num)->delete();
			foreach (I('post.class_type')['id'] as $key => $value) {
				if(!myempty(I('post.class_type')['value'][$value])){
					$data=array(
						'cid'=>$num
						,'typeid'=>$value
						,'typekey'=>I('post.class_type')['key'][$value]
						,'typevalue'=>I('post.class_type')['value'][$value]=="on"?1:I('post.class_type')['value'][$value]
					);
				}else{
					continue;
				}
				M('class_on_type')->add($data);
			}
			if($num){
				$this->success('添加成功！',U('Column/index'),1,U('Column/add_class'));
			}else{
				$this->error('添加失败！','',1);
			}	
		}else{
			$this->error('栏目名称不能为空！');
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

	//修改栏目
	public function updata_class(){
		if(!myempty($_GET['cid'])){
			//获取当前模型的栏目 
			$column=selectCl(C('ClumnPath')+1);
			//p($column);
			 /**
	   		 * 调用自定义的类方法  Class\expand 下
	   		 */
	   		import("Class.expand",APP_PATH);
	   		$object = new \Expand();
	   		$column=$object->yiwei($column,"cid","- ");
	   		$this->class=$column;
	   		//p($this->class);
			$where=array("tp_class.ID"=>$_GET['cid']);
			$up=D("Column")
				->relation("model")
				->where($where)
				->order('Sort')
				->find();
			//p($up);
			$this->Thumbnail_list=explode("###", $up['Class_pic']);
			$class_type_list=M('class_on_type')->field('cid',true)->where('cid='.$_GET['cid'])->select();
			//p($class_type_list);
			$this->assign('type_list',$class_type_list);			
			$this->assign('up',$up);
			//调用遍历属性表
   			$this->bltype=bltype(-1);
			$mlist=$this->selectDB();
			$this->assign('mlist',$mlist);
			$tmName=F('hxset','',CONF_PATH)['systemp'];
	   		//查找模板目录下列表模板
			$pathlist='Templates/'.$tmName.'/List';
			//查找模板目录下内容页模板
			$pathshow='Templates/'.$tmName.'/Show';
			$this->systemplist=get_file($pathlist,'List');
			$this->systempshow=get_file($pathshow);
			// p($this->systempshow);
			$this->display();
		}
	}

	//修改栏目提交表单 
	public function updata_class_form(){
		$db=M("class");
		$pid=$db->field("PID")->where("ID={$_POST['cid']}")->find();

		$filepath=implode("###",$_POST['filepath']);
		if(!myempty($_POST['name'])){
			//判断修改的栏目深度，如果是顶级栏目则将深度设为 0 ，如果不是则取到新的分类下的深度 
			if($_POST['classid']==0){
					$depth['depth']=1;
					$data['path']='';
			}else{
				$depth=$db
				->field('depth')
				->where("ID={$_POST["classid"]}")
				->find();
				$depth['depth']+=1;	
				//查找父类的路径
				$path=$db->field("path")->where("ID={$_POST['classid']}")->find();
				//连接父类的路径
				$data['path']=$path['path'].$_POST['classid'].',';

			}
			// 查找模板
			$temp=M('model')->field('systemplist,systempshow')->where('ID='.I('post.ModelID'))->find();
			$systemplist=!myempty(I('post.systemplist'))?I('post.systemplist'):$temp['systemplist'];
			$systempshow=!myempty(I('post.systempshow'))?I('post.systempshow'):$temp['systempshow'];
			
			$field=array("ID"=>$_POST['cid']);
			$data['Name']=$_POST['name'];
			$data['Remark']=$_POST['remark'];
			$data["PID"]=$_POST['classid'];
			$data['Class_pic']=$filepath;
			$data['Class_info']=I('post.Class_info');
			$data['depth']=$depth['depth'];
			$data['Status']=$_POST['Status'];
			$data['systemplist']=$systemplist;
			$data['systempshow']=$systempshow;

			$where=array("ClassID"=>$_POST['cid']);
			//检查当前分类下是否有内容，如果有内容则禁止操作
			$num=M($_POST['TableName'])->where($where)->count();
			if($num>0 && $_POST['oldModelID']!=$_POST['ModelID']){
				$up=$db->where($field)->save($data);
				$this->error("栏目模型不可以更改！此栏目下已有内容。",U("Column/index"),1);
			}else{
				$data['ModelID']=$_POST['ModelID'];
				//减去旧的父类的子分类数量
				$db->where("ID={$_POST['pid']}")->setDec('Child',1);
				//给新的父类加上一个子分类数量
				$db->where("ID={$_POST['classid']}")->setInc('Child',1);
				$db->where($field)->save($data);
				//先删除原有的属性值 
				M('class_on_type')->where('cid='.$_POST['cid'])->delete();
				$data='';
				foreach (I('post.class_type')['id'] as $key => $value) {
					if(!myempty(I('post.class_type')['value'][$value])){
						$data=array(
							'cid'=>I('cid')
							,'typeid'=>$value
							,'typekey'=>I('post.class_type')['key'][$value]
							,'typevalue'=>I('post.class_type')['value'][$value]=="on"?1:I('post.class_type')['value'][$value]
						);
						M('class_on_type')->add($data);
					}else{
						continue;
					}
					
				}

				$where=null;
				($pid['PID']==0)?$pid['PID']='':$pid['PID'].=',';
				$where['path']=array('like',array("%{$_POST['cid']},%","%{$pid['PID']}%"),'AND');
				//查找该分类下的所有子分类 并放入数组
				$pathArr=$db->field('ID,PID')->where($where)->order("depth")->select();
				//遍历更新子栏目的路径
				foreach ($pathArr as $v) {
					$this->uppath($v['ID'],$v['PID']);
				}
				//die();
				$this->success("修改成功！",U("Column/index"),1);
				
			}							
		}
	}

	//删除栏目图片
	public function del_pic(){
		$db=M("Class");
		$pid=$_POST['pid'];
		$Thumbnail=$db->field("Class_pic")->where("ID={$pid}")->find();
		$ThumbnailArr=explode("###", $Thumbnail['Class_pic']);
		foreach ($ThumbnailArr as $k => $v) {
			if($v==$_POST['picpath']){
				unset($ThumbnailArr[$k]);
			}
		}
		$Thumbnail_list=implode("###", $ThumbnailArr);
		$data['Class_pic']=$Thumbnail_list;
		$num=$db->where("ID={$pid}")->save($data);
		echo $num;	
	}

	//更新子分类的路径
	private function uppath($cid,$classid){
		$db=M('class');
		//查找父类的路径
		$path=$db->field("path,depth")->where("ID={$classid}")->find();
		//连接父类的路径
		$data['path']=$path['path'].$classid.',';
		$data['depth']=$path['depth']+1;
		$db->where("ID={$cid}")->save($data);
	}

	//更新栏目的排序
	public function sort_column(){
		$db=M("class");
		$num=0;
		foreach ($_POST as $id => $sort) {
			$num+=$db->where(array('ID'=>(int)$id))->setField('Sort',(int)$sort);
		}
		if($num){
			$this->success('成功更新了'.$num.'条数据！',U('Column/index'),1);
		}else{
			$this->error('未更新任何数据！',U('Column/index'),1);
		}
	}

	// 更新点击显示与关闭
	public function ajax_click_column(){
		if(!myempty(I('cid'))){
			$sql='UPDATE `tp_class` SET `Status`=ABS(Status-1) WHERE ( ID='.I('cid').' )';
			$data=M('class')->execute($sql);
			echo $data;
		}
	}

	
}