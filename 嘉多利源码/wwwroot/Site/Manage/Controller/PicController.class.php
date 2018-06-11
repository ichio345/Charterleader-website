<?php
namespace Manage\Controller;
use Think\Controller;
class PicController extends CommonController {	
	// 调用表
	private $table="pic";
	// 模型id
	private $mid=8;
	// 定义一个取产品栏目的方法  
	protected function currentl($field=''){
		//获取当前模型的栏目 
		$current=on_class($field);
		import("Class.expand",APP_PATH);
   		$object = new \Expand();
   		//将数组转成有分类级别的一维数组 
   		return $object->yiwei($current,"ID",'─ ');
	}

	//图片列表
	public function index(){
		$field['Edition']=session('edition');
		//获取当前模型的栏目 
		$column=currentl($field);
   		$this->current=$column;
		$db=M($this->table);
		//判断搜索的分类ID是否存在
		!myempty(I('classid'))?$where=array('tp_pic.path'=>array('like',"%".I('classid')."%")):$where=null;
		$where['tp_pic.Edition']=session('edition');
		$where['tp_pic.Title']=array('like','%'.I('post.so').'%');
		//查询满足要求的总记录数
		$count=$db->where($where)->count();
		//调用分页类  传入总记录数和每页显示的记录数
		$page=new \Think\Page($count,10);
		$page->setConfig('prev',"上一页"); //上一页
		$page->setConfig('next','下一页'); //下一页
		$page->setConfig('first','首页');  //第一页
		$page->setConfig('last',"末页");   //最后一页
		$page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$show=$page->show();

		//获取要搜索栏目的ID 如果没有则为空
		//!myempty(I('classid'))?$searchfield=array('tp_pic.path'=>array('like',"%".I('classid')."%")):$searchfield='';
		$field=array(
			'tp_pic.ID',
			'Title',
			'tp_class.Name cname',
			'tp_class.ID cid',
			'tp_pic.is_index',
			'tp_pic.Sort'
		);
		$art_list=$db->field($field)
					->join('tp_class ON tp_pic.ClassID=tp_class.ID',LEFT)
					->order('Sort DESC,ID DESC')
					->where($where)
					->limit($page->firstRow.','.$page->listRows)
					->select();
		$this->assign('art_list',$art_list);
		$this->assign('show',$show);
		$this->display();
	}
	

	// 添加图片	 
	public function add_pic(){

		!myempty($_GET['cid'])?$field=array('ID'=>$_GET['cid']):'';
		$field['Edition']=session('edition');
		//调用共公的函数  on_class   在common->common->funcion.php
        $column=currentl($field);
        $this->pic=$column;
		//调用遍历属性表
   		$this->bltype=bltype($this->mid);
		$this->display();
	}

	/**
	 * 添加图片表单
	 */
	public function add_pic_from(){
		//判断是否要添加水印
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
			,'Title'=>$_POST['title']
			,'path'=>$path['path'].$_POST['classid'].','
			,'Content'=>$_POST['content']
			,'ClassID'=>$_POST['classid']
			,'Thumbnail'=>$filepath
			,'Rdate'=>$date
			,'Edition'=>session('edition')
			,'Auth'=>$name
			,'Sort'=>I('Sort')
			,'Click'=>I('post.click')
			,'Keyword'=>$_POST['keyword']
			,'Description'=>$_POST['description']
			,'is_index'=>I('post.is_index')
			);
		$num=$db->add($field);
		//先删除原有的属性值 
		$where=array(
			'cid'=>$num
			,'mid'=>$this->mid
		);
		M('content_on_type')->where($where)->delete();
		// 添加图片自定义属性
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

		if($num){
			$this->success('添加成功！',U("index"),	1);
		}else{
			$this->error('添加失败，请重试！',U("add_pic"),1);
		}
	}

	// 修改图片
	public function update_pic(){
		$db=M($this->table);
		$num=array('tp_pic.ID'=>$_GET['aid']);
		$field=array(
			'tp_class.Name cname'
			,'Title','Thumbnail'
			,'Content'
			,'Auth'
			,'Click click'
			,'Keyword'
			,'Description'
			,'tp_pic.is_index'
			,'tp_pic.ID aid'
			,'tp_pic.ClassID cid'
			,'tp_pic.Sort'
			);
		$up_art=$db->field($field)->join('tp_class ON tp_pic.ClassID=tp_class.ID',LEFT)->where($num)->find();
		$edition['Edition']=session('edition');
		//获取当前模型的栏目
        $column=currentl($edition); 
        $this->class=$column;
        //p($this->class);
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
	 * 修改图片提交表单
	 */ 
	public function update_pic_form(){
		if(!myempty($_POST['artid'])){
			$name=!myempty($_POST['auth'])?$_POST['auth']:session("Uname");
			$filepath=implode("###",$_POST['filepath']);
			$db=M($this->table);
			$num=array('ID'=>$_POST['artid']);
			$path=M("class")->field("path")->where("ID={$_POST['classid']}")->find();
			$field=array(
				'Title'=>$_POST['title']
				,'path'=>$path['path'].$_POST['classid'].','
				,'Content'=>$_POST['content']
				,'ClassID'=>$_POST['classid']
				,'Thumbnail'=>$filepath
				,'Edition'=>session('edition')
				,'Click'=>I('post.click')
				,'Sort'=>I('Sort')
				,'Auth'=>$name
				,'Keyword'=>$_POST['keyword']
				,'Description'=>$_POST['description']
				,'is_index'=>I('post.is_index')
				);
			$db->where($num)->save($field);
			//先删除原有的属性值 
			$where=array(
				'cid'=>I('post.artid')
				,'mid'=>$this->mid
			);
			M('content_on_type')->where($where)->delete();
			$data='';
			// 添加图片自定义属性
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
			
		}else{
			$this->error('非法操作！');
		}	
	}

	/**
	 * 删除图片
	 * @return [type] [description]
	 */
	public function delete_pic(){
		if(!myempty($_GET['aid']) || !myempty($_POST['del'])){
			$db=M($this->table);
			//将获取的数组转化成字符串
			$del=implode(',',$_POST['del']);
			//判断删除是多条还是一条
			!myempty($_GET['aid'])?$where=array('ID'=>$_GET['aid']):$where=array('ID'=>array('in',$del));
			$num=$db->where($where)->delete();
			if($num){
				if($num==1 && $_GET['bz']==1){
					$this->success('成功删除'.$num.'篇文章',U('index',array('ysclassid'=>$_GET['classid'],'p'=>$_GET['p'] )),1);	
				}else{
					$this->success('成功删除'.$num.'篇文章',U('index',array('ysclassid'=>$_POST['classid'],'p'=>$_POST['p'] )),1);	
				}
			}else{
				$this->error('删除失败！请重试','',1);
			}
		}
	}

	/**
	 * [show_pic 显示文章]
	 */
	public function show_pic(){
		if(!myempty($_GET['aid'])){
			$db=M($this->table);
			$num=array('tp_pic.ID'=>$_GET['aid']);
			$field=array('tp_class.Name cname','Rdate','Auth','Title','Content','Keyword','Description');
			$se_art=$db->field($field)->where($num)->join('tp_class ON tp_pic.ClassID=tp_class.ID',LEFT)->find();
			if(!$se_art){
				$this->error('对不起找不到内容！',U("index"),1);
			}
			$this->Rdate=date('Y-m-d H:i:s',$se_art['Rdate']);	
			$this->assign('se_art',$se_art);	
		}
		$this->display();
	}

	// 移动图片的内容
	public function move_pic(){
		$field['Edition']=session('edition');
		//获取当前模型的栏目  [后台公共函数]
		$this->class=currentl($field);
		$this->moveid=I('moveid');
		$this->display();
	}

	// 移动图片的内容表单
	public function move_pic_form(){
		//获取最新的path
		$path=M("class")->field("path")->where("ID={$_POST['classid']}")->find();
		$where['ID']=array('in',I("moveid"));
		$data=array(
			'ClassID'=>I('classid')
			,'path'=>$path['path'].I('classid').','
		);
		$num=M($this->table)->where($where)->save($data);
		if($num){
			$this->success("移动成功！",U('index'));
		}else{
			$this->error("移动失败，请重试！");
		}
	}

	// 更新点击显示与关闭
	public function ajax_click_pic(){
		if(!myempty(I('id'))){
		$sql='UPDATE __TABLE__ SET `is_index`=ABS(is_index-1) WHERE ( ID='.I('id').' )';
		$data=M($this->table)->execute($sql);
		echo $data;
		}
	}

	//更新产品的排序
	public function ajax_sort_pic(){
		if(!myempty(I('id'))){
			$data=M($this->table)->where('ID='.I('id'))->save(array('Sort'=>I('Sort')));
			echo $data;
		}
		
	}
}