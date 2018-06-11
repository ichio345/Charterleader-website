<?php
namespace Manage\Controller;
use Think\Controller;
class RbacController extends CommonController {
	//rbac 首页
	public function index(){

	}
	//角色列表
	public function role(){
		$db=M('role');
		$field=array('pid');
		$role=$db->field($field,true)->select();
		$this->assign('role_list',$role);
		$this->display();
	}
	//节点列表
	public function node(){
		$db=M('node');
		$field=array('remark');
		$node=$db->field($field,true)->order('sort asc')->select();
		// 调用数组处理类
		import("Class.expand",APP_PATH);
   		$object = new \Expand();
   		$node=$object->erwei($node);
		$this->assign('node_list',$node);
		$this->display();
	}
	//修改角色
	public function update_role(){   
		$db=M('role');
		$num=array('id'=>$_GET['noid']);
		$this->up=$db->where($num)->find();
		if(!empty($_POST['name'])){
			$up_db=M('role');
			$value=array('name'=>$_POST['name'],'remark'=>$_POST['remark'],'status'=>$_POST['status']);
			$id=array('id'=>$_GET['noid']);
			$i=$up_db->where($id)->save($value);
			if($i){
				$this->success('修改成功！',U('role'),1);
			}else{
				$this->error('修改失败，请重试！','',1);
			}
		}
		$this->display();
	}

	//添加角色
	public function add_role(){
		$this->display();
	}

	//添加角色表单
	public function add_role_form(){
		if(!empty($_POST['name'])){
			$db=M('role');
			$field=array('name'=>$_POST['name'],'remark'=>$_POST['remark'],'status'=>$_POST['status']);
			$num=$db->add($field);
			if($num){
				$this->success('添加角色成功！',U('role'),1);	
			}else{
				$this->error('添加失败，请重试！','',1);
			}
		}	
	}
	//删除角色
	public function delete_role(){
		$where=array('id'=>(int)$_GET['role']);
		$db=D('Rbac')->relation('access')->where($where)->delete();
		if($db){
			$this->success('删除角色成功！',U('role'),1);
		}else{
			$this->error('删除失败，请重试！','',1);
		}
	}

	//属性名称
	public function typename($level){
		switch ($level) {
			case '1':
				$typeN='应用';
				break;
			case '2':
				$typeN='控制器';
				break;
			case '3':
				$typeN='方法';
				break;
		}
		return $typeN;
	}

	//添加节点
	public function add_node(){
		$this->pid=$_GET['pid']?$_GET['pid']:0;
		$this->level=$_GET['level']?$_GET['level']:1;
		$level=$_GET['level']?$_GET['level']:1;
		$typeN=$this->typename($level);
		$this->assign('typename',$typeN);
		$this->display();
	}

	//添加节点表单
	public function add_node_form(){
		if(!empty($_POST['name'])){
			$db=M('node');
			$filed=array('name'=>$_POST['name'],'title'=>$_POST['title'],'is_show'=>$_POST['is_show'],
				'sort'=>$_POST['sort'],'pid'=>intval($_POST['pid']),'level'=>$_POST['level']);
			$num=$db->add($filed);
			if($num){
				$this->success('添加成功',U('node'),1,U('add_node'));
			}else{
				$this-error('添加失败，请重试！','',1);
			}
		}
	}

	//删除节点
	public function delete_node(){
		p($_GET);
	}

	//修改节点
	public function update_node(){
		if($_GET['noid']){
			$db=M('node');
			$num=array('id'=>$_GET['noid']);
			$field=array('name','title','is_show','sort');
			$this->node=$db->field($field)->where($num)->find();
			$level=$_GET['level']?$_GET['level']:1;
			$typeN=$this->typename($level);
			$this->assign('typename',$typeN);		
		}
		$this->display();
	}

	//修改节点表单
	public function update_node_form(){
		if(!empty($_GET['noid'])){
			$db=M('node');
			$num=array('id'=>$_GET['noid']);
			$node_data=array('name'=>$_POST['name'],'title'=>$_POST['title'],'is_show'=>$_POST['is_show'],'sort'=>$_POST['sort']);
			$m=$db->where($num)->save($node_data);	
			if($m){
				$this->success('修改成功！',U('node'),1);
			}else{
				$this->error('修改失败，请重试！','',1);
			}
		}
	}

	//更新排序
	public function sort_node(){
		$db=M("node");
		$num=0;
		foreach ($_POST as $id => $sort) {
			$num+=$db->where(array('id'=>(int)$id))->setField('sort',(int)$sort);
		}
		
		if($num){
			$this->success('成功更新了'.$num.'条数据！',U('node'),1);
		}else{
			$this->error('未更新任何数据！',U('node'),1);
		}
		
	}

	//配置用户权限
	public function access(){
		$this->aid=$_GET['aid'];
		$db=M('node');
		$field=array('remark');
		$node=$db->field($field,true)->where()->select();
		//调用原有权限
		$afield=array('role_id'=>$_GET['aid']);
		$access=M('access')->where($afield)->getField('node_id',true);
		// 调用数组处理类
		import("Class.expand",APP_PATH);
   		$object = new \Expand();
   		$node=$object->erwei($node,$access);
		$this->assign('node_list',$node);
		$this->display();
	}

	//配置用户权限表单
	public function access_form(){
		$role_id=$_POST['aid'];
		$db=M('access');
		$db->where(array('role_id'=>$role_id))->delete();
		//组合新的数组
		$data=array();
		foreach ($_POST['access'] as $v) {
			$tmp=explode('_', $v);
			$data=array('role_id'=>$role_id,'node_id'=>$tmp[0],'level'=>$tmp[1]);
			$num=$db->data($data)->add();
		}
		$this->success('保存成功！','',1);
	}

}