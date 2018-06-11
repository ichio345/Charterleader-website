<?php
namespace Manage\Controller;
use Think\Controller;
/**
 * 网站模型操作类
 */
class modelController extends CommonController {
	/**
	 * 模型列表
	 */
	public function index(){

		$db=M("model");
		$data=$db->select();
		$html=<<<html
	<tr><td colspan="3" align="center">暂时没有系统模型！</td></tr>
html;
		 $this->assign('empty',$html);
		$this->assign('model',$data);
		$this->display();

	}

	/**
	 * 添加模型
	 */
	public function add_model(){
		$tmName=F('hxset','',CONF_PATH)['systemp'];
		//查找模板目录下列表模板
		$pathlist='Templates/'.$tmName.'/List';
		//查找模板目录下内容页模板
		$pathshow='Templates/'.$tmName.'/Show';
		$this->systemplist=get_file($pathlist,'List');
		$this->systempshow=get_file($pathshow);
		if(!empty($_POST['name'])){
			$field=array(
				"Name"=>$_POST['name']
				,"Title"=>$_POST['title']
				,"TableName"=>$_POST['TableName']
				,"systemplist"=>$_POST['systemplist']
				,"systempshow"=>$_POST['systempshow']
			);
			$db=M("model");
			$num=$db->add($field);
			if($num){
				$this->success("添加模型成功！",U("index"),1);
			}else{
				$this->error("添加失败，请重试！",U("add_model"),1);
			}
			die;
		}
		$this->display();

	}

	/**
	 * 删除模型
	 */
	public function del_model(){
		if(!empty($_GET['moid'])){
			$field=array("ID"=>$_GET['moid']);
			$db=M("model");
			$num=$db->where($field)->delete();
			if($num){
				$this->success("删除模型成功！",U("index"),1);
			}else{
				$this->error("删除失败，请重试！",U("index"),1);
			}
		}
	}

	/**
	 * 修改模型
	 */
	public function updata_model(){
		$tmName=F('hxset','',CONF_PATH)['systemp'];
		//查找模板目录下列表模板
		$pathlist='Templates/'.$tmName.'/List';
		//查找模板目录下内容页模板
		$pathshow='Templates/'.$tmName.'/Show';
		$this->systemplist=get_file($pathlist,'List');
		$this->systempshow=get_file($pathshow);

		if(!empty($_GET['moid'])){
			$db=M("model");
			$field=array("ID"=>$_GET['moid']);
			$data=$db->where($field)->find();
			$this->assign("umodel",$data);
		}
		$this->display();	
	}
	/**
	 * 修改模型提交表单
	 */
	public function updata_model_form(){
		if(!empty($_POST['name'])){
			$db=M("model");
			$field['ID']=$_POST['moid'];
			$up=array(
				"Name"=>$_POST['name']
				,"Title"=>$_POST['title']
				,"TableName"=>$_POST['TableName']
				,"systemplist"=>$_POST['systemplist']
				,"systempshow"=>$_POST['systempshow']
				);
			$num=$db->where($field)->save($up);
			if($num){
				$this->success("修改成功！",U("index"),1);
			}else{
				$this->error("修改失败，请重新修改！",'',1);
			}
		}
	}

}