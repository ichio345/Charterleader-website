<?php
namespace Manage\Controller;
use Think\Controller;
class ArticleController extends CommonController {
	
	// 调用表
	private $table="article";
	// 模型id
	private $mid=5;
	/**
	 * 文章首页  文章列表
	 * @return [type] [description]
	 */
	public function index(){
		$field['Edition']=session('edition');
		//获取当前模型的栏目 
		$column=currentl($field);
   		$this->current=$column;
		$db=M($this->table);
		//判断搜索的分类ID是否存在
		!myempty(I('classid'))?$where=array('tp_article.path'=>array('like',"%".I('classid')."%")):$where=null;
		$where['tp_article.Edition']=session('edition');
		$where['tp_article.Title']=array('like','%'.I('post.so').'%');
		//查询满足要求的总记录数
		$count=$db->where($where)->count();
		$page=Hpage($count);
		$show=$page->show();
		$field=array('tp_article.ID','Title','tp_class.Name cname','tp_class.ID cid','tp_article.is_index');
		$art_list=$db->field($field)
			->join('tp_class ON tp_article.ClassID=tp_class.ID',LEFT)
			->where($where)
			->order('Rdate DESC,ID DESC')
			->limit($page->firstRow.','.$page->listRows)
			->select();
		$this->assign('art_list',$art_list);
		$this->assign('show',$show);
		$this->display();
	}
	

	// 添加文章	 
	public function add_article(){
		!myempty($_GET['cid'])?$field=array('ID'=>$_GET['cid']):'';
		$field['Edition']=session('edition');
		//获取当前模型的栏目 
		$column=currentl($field);
		$this->assign('article',$column);
		//调用遍历属性表
   		$this->bltype=bltype($this->mid);
		$this->display();
	}

	/**
	 * 添加文章表单
	 */
	public function add_article_from(){
		//判断添加的数据表是否存在 
		//如果不存在则调用 函数tablename() 来获取数据表名
		myempty($_POST['tablename'])?$tablename=tablename($_POST['classid']):$tablename=$_POST['tablename'];
		$db=M($tablename);
		$date=time();
		!myempty($_POST['auth'])?$name=$_POST['auth']:$name=$_SESSION['Uname'];
		$filepath=implode("###",$_POST['filepath']);
		$path=M("class")->field("path")->where("ID={$_POST['classid']}")->find();
		$Rdate=I('Rdate');
		!empty($Rdate)?$Rdate=strtotime(I('Rdate')):$Rdate=time();
		$field=array(
			'Name'=>$_POST['name']
			,'Title'=>$_POST['title']
			,'Content'=>$_POST['content']
			,'ClassID'=>$_POST['classid']
			,'path'=>$path['path'].$_POST['classid'].','
			,'Thumbnail'=>$filepath
			,'Rdate'=>$Rdate
			,'Auth'=>$name
			,'Click'=>I('post.click')
			,'Edition'=>session('edition')
			,'Keyword'=>$_POST['keyword']
			,'Description'=>$_POST['description']
			,'Cover'=>myempty($_POST['Cover'])?0:(int)$_POST['Cover']-1
			,'is_index'=>(int)$_POST['is_index']
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
			$this->error('添加失败，请重试！',U("add_article"),1);
		}
	}

	// 修改文章
	public function update_article(){
		$field['Edition']=session('edition');
        //获取当前模型的栏目
        $column=currentl($field);
		$this->class=$column;
		$db=M($this->table);
		$num=array('tp_article.ID'=>$_GET['aid']);
		$field=array('tp_class.Name cname'
			,'Title'
			,'is_index is_index'
			,'Thumbnail'
			,'Content'
			,'Auth'
			,'Click click'
			,'Keyword'
			,'Description'
			,'Cover'
			,'tp_article.ID aid'
			,'tp_article.ClassID cid'
			,'tp_article.Rdate'
		);
		$up_art=$db->field($field)->join('tp_class ON tp_article.ClassID=tp_class.ID',LEFT)->where($num)->find();
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
	 * 修改文章提交表单
	 */ 
	public function update_article_form(){
		if(!myempty($_POST['artid'])){
			$db=M($this->table);
			$num=array('ID'=>$_POST['artid']);
			$filepath=implode("###",$_POST['filepath']);
			$path=M("class")->field("path")->where("ID={$_POST['classid']}")->find();
			!myempty($_POST['auth'])?$name=$_POST['auth']:$name=$_SESSION['Uname'];
			$Rdate=I('Rdate');
			!empty($Rdate)?$Rdate=strtotime(I('Rdate')):$Rdate=time();
			$field=array(
				'Title'=>$_POST['title']
				,'Content'=>$_POST['content']
				,'ClassID'=>$_POST['classid']
				,'path'=>$path['path'].$_POST['classid'].','
				,'Thumbnail'=>$filepath
				,'Auth'=>$name
				,'Click'=>I('post.click')
				,'Rdate'=>$Rdate
				,'Edition'=>session('edition')
				,'Keyword'=>$_POST['keyword']
				,'Description'=>$_POST['description']
				,'Cover'=>myempty($_POST['Cover'])?0:(int)$_POST['Cover']-1
				,'is_index'=>(int)$_POST['is_index']
				,);
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
		}	
	}

	/**
	 * 删除文章
	 * @return [type] [description]
	 */
	public function delete_article(){
		if(!myempty($_GET['aid']) || !myempty($_POST['del'])){
			$db=M($this->table);
			//将获取的数组转化成字符串
			$del=implode(',',$_POST['del']);
			//判断删除是多条还是一条
			!myempty($_GET['aid'])?$where=array('ID'=>$_GET['aid']):$where=array('ID'=>array('in',$del));
			$num=$db->where($where)->delete();
			if($num){
				if($num==1 && $_GET['bz']==1){
					$this->success('成功删除'.$num.'篇文章',U('index',array('classid'=>$_GET['ysclassid'],'p'=>$_GET['p'] )),1);	
				}else{
					$this->success('成功删除'.$num.'篇文章',U('index',array('classid'=>$_POST['ysclassid'],'p'=>$_POST['p'] )),1);	
				}
			}else{
				$this->error('删除失败！请重试','',1);
			}
		}
	}


	// 移动文章的内容
	public function move_article(){
		$field['Edition']=session('edition');
		//获取当前模型的栏目  [后台公共函数]
		$this->class=currentl($field);
		$this->moveid=I('moveid');
		$this->display();
	}

	// 移动文章的内容表单
	public function move_article_form(){
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

	/**
	 * [show_article 显示文章]
	 */
	public function show_article(){
		if(!myempty($_GET['aid'])){
			$db=M($this->table);
			$num=array('tp_article.ID'=>$_GET['aid']);
			$field=array('tp_class.Name cname','Rdate','Auth','Title','Content','Keyword','Description');
			$se_art=$db->field($field)->where($num)->join('tp_class ON tp_article.ClassID=tp_class.ID',LEFT)->find();
			if(!$se_art){
				$this->error('对不起找不到内容！',U("index"),1);
			}
			$this->Rdate=date('Y-m-d H:i:s',$se_art['Rdate']);	
			$this->assign('se_art',$se_art);	
		}
		$this->display();
	}

	//删除新闻图片
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

	// 更新点击显示与关闭
	public function ajax_click_article(){
		if(!myempty(I('id'))){
		$sql='UPDATE __TABLE__ SET `is_index`=ABS(is_index-1) WHERE ( ID='.I('id').' )';
		$data=M($this->table)->execute($sql);
		echo $data;
		}
	}

}