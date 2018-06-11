<?php
namespace Manage\Controller;
use Think\Controller;
class AboutController extends CommonController {
	// 调用表
	private $table="about";
	// 模型id
	private $mid=10;
	//单篇列表
	public function index(){
		$db=M($this->table);
		// 查询满足要求的总记录数
		$count=$db->where(array('Edition'=>session('edition')))->count();
		//调用分页类  传入总记录数和每页显示的记录数
		$page=Hpage($count);
		$show=$page->show();
		$field=array('tp_about.ID','Title','tp_class.Name cname');
		$about_list=$db->field($field)
					->join('tp_class ON tp_about.ClassID=tp_class.ID ',LEFT)
					->order('ID desc')
					->where(array('tp_about.Edition'=>session('edition')))
					->limit($page->firstRow.','.$page->listRows)
					->select();
		$this->assign('about_list',$about_list);
		$this->assign('show',$show);
		$this->display();
	}

	//添加单篇内容
	public function add_about(){
		!empty($_GET['cid'])?$field['ID']=$_GET['cid']:'';
		$field['Edition']=session('edition');
		//获取当前模型的栏目  [后台公共函数]
		$this->about=currentl($field);
		//调用遍历属性表
   		$this->bltype=bltype($this->mid);
		$this->display();
	}
	
	//添加单篇内容表单
	public function add_about_form(){
		//判断添加的数据表是否存在 
		//如果不存在则调用 函数tablename() 来获取数据表名
		empty($_POST['tablename'])?$tablename=tablename($_POST['classid']):$tablename=$_POST['tablename'];
		$db=M($tablename);
		
		$recrod=array(
			'Title'=>$_POST['title']
			,'ClassID'=>$_POST['classid']
			,'Rdate'=>time()
			,'Desc'=>$_POST['Desc']
			,'Content'=>$_POST['content']
			,'is_index'=>$_POST['is_index']
			,'Edition'=>session('edition')
		);
		$num=$db->add($recrod);
		//先删除原有的属性值 
		$where=array(
			'cid'=>$num
			,'mid'=>$this->mid
		);
		M('content_on_type')->where($where)->delete();
		foreach (I('post.class_type')['id'] as $key => $value) {
			if(!empty(I('post.class_type')['value'][$value])){
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
		if($num){
			$this->success('添加成功！',U('index'));
		}else{
			$this->error('添加失败，请重试！');
		}
	}

	//修改单篇内容
	public function update_about(){
		$db=M($this->table);
		$num=array('tp_about.ID'=>$_GET['aid']);
		$field=array('tp_class.Name cname','Title','is_index','Desc','Content','tp_about.ID aid','tp_about.ClassID cid');
		$up_art=$db->field($field)->join('tp_class ON tp_about.ClassID=tp_class.ID',LEFT)->where($num)->find();
		$field2['Edition']=session('edition');
		$this->class=currentl($field2);
		$this->assign('up_art',$up_art);
		$mid=M('model')->field('ID')->where('TableName="'.$this->table.'"')->find()['ID'];
		$where=array(
			'cid'=>I('get.aid')
			,'mid'=>$mid
		);
		$class_type_list=M('content_on_type')->field('cid',true)->where($where)->select();
		$this->assign('type_list',$class_type_list);

		//调用遍历属性表
   		$this->bltype=bltype($this->mid);
		$this->display();
	}

	/**
	 * 修改文章提交表单
	 */ 
	public function update_article_form(){
		if(!empty($_POST['artid'])){
			$db=M($this->table);
			$where=array('ID'=>$_POST['artid']);
			$data=array(
				'Title'=>$_POST['title']
				,'is_index'=>isset($_POST['is_index'])&&$_POST['is_index']==1?$_POST['is_index']:0
				,'Desc'=>$_POST['Desc']
				,'Content'=>$_POST['content']
				,'ClassID'=>$_POST['classid']
				,'Edition'=>session('edition')
			);

			$upa=$db->where($where)->save($data);

			//先删除原有的属性值 
			$where=array(
				'cid'=>I('post.artid')
				,'mid'=>$this->mid
			);
			M('content_on_type')->where($where)->delete();
			$data='';
			foreach (I('post.class_type')['id'] as $key => $value) {
				if(!empty(I('post.class_type')['value'][$value])){
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
			$this->success('修改成功！',U('index'),1);
			
		}	
	}

	//删除单篇内容
	public function delete_about(){
		if(!empty($_GET['aid']) || !empty($_POST['del'])){
			$db=M($this->table);
			//将获取的数组转化成字符串
			$del=implode(',',$_POST['del']);
			//判断删除是多条还是一条
			!empty($_GET['aid'])?$where=array('ID'=>$_GET['aid']):$where=array('ID'=>array('in',$del));
			$num=$db->where($where)->delete();
			if($num){
				$this->success('成功删除'.$num.'篇',U('index'),1);
			}else{
				$this->error('删除失败！请重试','',1);
			}
		}
	}

	//显示单篇内容
	public function show_about(){
		if(!empty($_GET['aid'])){
			$db=M($this->table);
			$num=array('tp_about.ID'=>$_GET['aid']);
			$field=array('tp_class.Name cname','Title','Content');
			$se_art=$db->field($field)->where($num)->join('tp_class ON tp_about.ClassID=tp_class.ID',LEFT)->find();
			if(!$se_art){
				$this->error('对不起找不到内容！',U("index"),1);
			}		
		}
		$this->assign('se_art',$se_art);
		$this->display();
	}
}