<?php 
namespace Manage\Controller;
use Think\Controller;	
class SystemController extends CommonController{

	public function index(){
		$this->php=phpversion();
		$this->mysql=mysql_get_server_info();
		$this->apache=$_SERVER['SERVER_SOFTWARE'];
		$this->display();
	}

	//系统设置
	public function sys_set(){
		$seo=F('system2','',CONF_PATH)['seo'];
		$sys=F('system2','',CONF_PATH)['system'];
		$this->assign('seo',$seo);
		$this->assign('sys',$sys);
		$this->lng=session('lng');		
		$this->display();
	}

	//seo 提交
	public function seo_form(){
		$data['seo']=F('system2','',CONF_PATH)['seo'];
		$data['seo'][session('lng')]=array(
			'title'=>$_POST['title']
			,'keywords'=>$_POST['keywords']
			,'description'=>$_POST['description']
			,'edition'=>session('edition')
			);
		$data['system']=F('system2','',CONF_PATH)['system'];
		F('system2',$data,CONF_PATH);
		$this->success('保存成功','',1);
	}

	//系统设置提交
	public function setsite_from(){		
		$data['seo']=F('system2','',CONF_PATH)['seo'];	
		$data['system']=F('system2','',CONF_PATH)['system'];
		$data['system'][session('lng')]=array(
			'sitename'=>$_POST['sitename']
			,'beian'=>$_POST['beian']
			,'wztj'=>I('wztj')
			,'address'=>$_POST['address']
			,'tel'=>$_POST['tel']
			,'phone'=>$_POST['phone']
			,'email'=>$_POST['email']
			,'qq'=>$_POST['qq']
			);
		F('system2',$data,CONF_PATH);
		$this->success('设置成功！','',1);
	}

	//系统核心设置
	public function hxset(){
		$db=M('edition');
		$edition=$db->select();			
		$this->filelist=get_file('Templates','');
		$this->hxset=F('hxset','',CONF_PATH);
		echo $this->systemp; 
		$this->assign('edition',$edition);
		$this->display();
	}

	
	// 系统核心设置提交
	public function hxset_form(){
		$db=M('edition');
		//判断表单中是否有更改的值
		if(!myempty($_POST['edition'])){
			//先将数据库中所有的 start 都设置为0 ,再将表单中的数据传入
			$sql="UPDATE __TABLE__ SET start=0";
			$db->execute($sql);	
		}	
		$num=0;
		foreach($_POST['edition'] as $id => $start) {
			$num+=$db->where(array('id'=>$id))->setField('start',(int)$start);
		}
		$data=array(
			'is_water'=>(bool)I('is_water')
			,'VLENTH'=>I('VLENTH')
			,'depth'=>(int)I('depth')
			,'systemp'=>$_POST['systemp']
			,'siteUrl'=>I('siteUrl')
			,'htname'=>I('htname')
		);
		F('hxset',$data,CONF_PATH);
		$this->success('保存配置成功！');
	}

	//客服QQ
	public function kfqq(){
		$qq=F('qq','',CONF_PATH);
		$this->assign('qq',$qq);
		$this->display();
	}


	//添加客服QQ
	public function add_qq_form(){
		$data=array(
			'title'=>$_POST['title']
			,'is_index'=>$_POST['is_index']
			,'qqurl'=>$_POST['qqurl']
			,'qq'=>$_POST['qq']
			,'qqtitle'=>$_POST['qqtitle']
			,'qqtel'=>$_POST['qqtel']
			,'position'=>$_POST['position']
			,'Distance'=>$_POST['Distance']
			,'display'=>$_POST['display']
			);
		F('qq',$data,CONF_PATH);
		$this->success('设置成功！',U('kfqq'),1);
	}

	//幻灯片
	public function slide(){
		$slide=M('slide')->where('Edition='.session('edition'))->order('sort')->select();
		$this->assign('slide',$slide);
		$this->display();
	}

	public function add_slide(){
		$this->display();
	}

	//添加幻灯片表单
	public function add_slide_form(){
		$filepath=implode("###",$_POST['filepath']);
		$field=array(
			'Title'=>$_POST['title']
			,'Desc'=>$_POST['desc']
			,'PicUrl'=>$filepath
			,'LinkUrl'=>$_POST['linkurl']
			,'Edition'=>session('edition')
			,'is_index'=>$_POST['is_index']
			,'sort'=>I('sort')			);
		$num=M('slide')->add($field);
		if($num){
			$this->success('添加成功！',U('slide'),1);
		}else{
			$this->error('添加失败！','',1);
		}
	}

	//修改幻灯片
	public function update_slide(){
		$id=$_GET['id'];
		$this->slide=M('slide')->where('ID='.$id)->find();
		$this->display();
	} 

	// 修改幻灯片表单
	public function update_slide_form(){
		$filepath=implode("###",$_POST['filepath']);
		$field=array(
			'Title'=>$_POST['title']
			,'Desc'=>$_POST['desc']
			,'PicUrl'=>$filepath
			,'LinkUrl'=>$_POST['linkurl']
			,'Edition'=>session('edition')
			,'is_index'=>$_POST['is_index']
			,'sort'=>I('sort')
			);
		$num=M('slide')->where('ID='.$_POST['id'])->save($field);
		if($num){
			$this->success('更新成功！',U('slide'),1);
		}else{
			$this->error('更新失败！','',1);
		}
	}

	//删除幻灯片
	public function delete_slide(){
		$id=$_GET['id'];
		//将获取的数组转化成字符串
		$del=implode(',',$_POST['del']);
		//判断删除是多条还是一条
		!myempty($_GET['id'])?$where=array('ID'=>$_GET['id']):$where=array('ID'=>array('in',$del));
		$num=M('slide')->where($where)->delete();
		if($num){
			$this->success('删除成功！',U('slide'),1);
		}else{
			$this->error('删除失败！','',1);
		}
	} 

	// 友情链接
	public function link(){
		$this->link=M('link')->where('Edition='.session('edition'))->select();
		$this->display();
	}

	// 添加友情链接
	public function add_link(){			
		if(IS_POST){
			$filepath=implode("###",$_POST['filepath']);
			$data=array(
			'linkname'=>I('post.linkname')
			,'linkurl'=>I('post.linkurl')
			,'linkpic'=>$filepath
			,'linkorder'=>I('post.linkorder')
			,'Edition'=>session('edition')
			,'is_show'=>I('post.is_show')
			);
			$num=M('link')->add($data);
			if($num){
				$this->success('添加友情链接成功！',U('System/link'));
			}else{
				$this->error('添加失败，请重试！');
			}
			die;
		}
		$this->display();
	}

	// 修改友情链接
	public function updata_link(){
		$db=M('link');
		$this->link=$db->where('id='.I('id'))->find();
		if(IS_POST){
			$filepath=implode("###",$_POST['filepath']);
			$data=array(
			'linkname'=>I('post.linkname')
			,'linkurl'=>I('post.linkurl')
			,'linkpic'=>$filepath
			,'linkorder'=>I('post.linkorder')
			,'Edition'=>session('edition')
			,'is_show'=>I('post.is_show')
			);
			$num=$db->where('id='.I('id'))->save($data);

			if($num){
				$this->success('修改友情链接成功！',U('System/link'));
			}else{
				$this->error('修改失败，请重试！');
			}
			die;
		}
		$this->display();
	}

	// 删除友情链接
	public function delete_link(){
		$id=$_GET['id'];
		//将获取的数组转化成字符串
		$del=implode(',',$_POST['del']);
		//判断删除是多条还是一条
		!myempty($_GET['id'])?$where=array('id'=>$_GET['id']):$where=array('id'=>array('in',$del));
		$num=M('link')->where($where)->delete();
		if($num){
			$this->success('删除成功！',U('link'));
		}else{
			$this->error('删除失败！','',1);
		}
	}



	//删除产品图片
	public function del_pic($table,$field='Thumbnail'){
		$db=M($table);
		$pid=$_POST['pid'];
		$Thumbnail=$db->field($field)->where("ID={$pid}")->find();
		$ThumbnailArr=explode("###", $Thumbnail[$field]);
		foreach ($ThumbnailArr as $k => $v) {
			if($v==$_POST['picpath']){
				$picpath='./Upload'.$ThumbnailArr[$k];
				unlink($picpath);
				unset($ThumbnailArr[$k]);	
			}
		}
		$Thumbnail_list=implode("###", $ThumbnailArr);
		$data[$field]=$Thumbnail_list;
		$num=$db->where("ID={$pid}")->save($data);
		echo $num;	
	}



	// 自定义属性
	public function type(){
		$this->type=M('type')->order('typeorder')->select();
		$this->display();
	}

	/**
	 * [typelist  设置属性类型列表]     
	 * @return [type] [description]
	 */
	private function typelist(){
		return array(
			0=>array('k'=>'复选框','v'=>'checkbox')
			,1=>array('k'=>'文本框','v'=>'text')
			,2=>array('k'=>'文本域','v'=>'textarea')
		);
	}

	/**
	 * [module 查找所有设置属性的模型]		
	 * @return [type] [description]
	 */
	private function module(){
		$data=M('model')->field('ID,Title')->select();
		$data[]=array('ID'=>-1,'Title'=>'栏目');
		return $data;
	}

	//添加自定义属性
	public function add_type(){
		//调用 设置属性类型列表 
		$this->typelist=$this->typelist();
		// 调用 设置属性模型的列表
		$this->module=$this->module();
		if(IS_POST){
			$typelist=explode('-', $_POST['typelist']);
			$type=$typelist[0];
			$typename=$typelist[1];
			// 调用的模型 将字符转化为数组
			$modulepost=explode('###', I('post.typemodule'));
			$typemodule=$modulepost[0];
			$typemoname=$modulepost[1];
			$data=array(
				'name'=>I('post.name')
				,'remark'=>I('post.remark')
				,'type'=>$type
				,'typename'=>$typename
				,'typeorder'=>I('post.typeorder')
				,'typemodule'=>$typemodule
				,'typemoname'=>$typemoname
				,'is_show'=>I('post.is_show')
			);
			$num=M('type')->add($data);
			if($num){
				$this->success('添加属性成功！',U('type'),1,U('add_type'));
			}else{
				$this->error('添加属性失败！');
			}
			die;
		}
		$this->display();
	}

	//修改自定义属性
	public function update_type(){
		//调用 设置属性类型列表 
		$this->typelist=$this->typelist();
		// 调用 设置属性模型的列表
		$this->module=$this->module();
		$this->type=M('type')->where('id='.I('get.id').'')->find();
		if(IS_POST){
			$id=I('post.id');
			$typelist=explode('-', $_POST['typelist']);
			$type=$typelist[0];
			$typename=$typelist[1];
			// 调用的模型 将字符转化为数组
			$modulepost=explode('###', I('post.typemodule'));
			$typemodule=$modulepost[0];
			$typemoname=$modulepost[1];
			$data=array(
				'name'=>I('post.name')
				,'remark'=>I('post.remark')
				,'type'=>$type
				,'typename'=>$typename
				,'typeorder'=>I('post.typeorder')
				,'typemodule'=>$typemodule
				,'typemoname'=>$typemoname
				,'is_show'=>I('post.is_show')
			);
			$num=M('type')->where('ID='.$id)->save($data);
			if($num){
				$this->success('修改属性成功！',U('type'));
			}else{
				$this->error('修改属性失败！');
			}
			die;
		}
		$this->display();
	}

	// 删除自定义属性
	public function delete_type(){
		$id=I('get.id');
		$num=M('type')->where('id='.$id)->delete();
		if($num){
			$this->success('删除成功！');
		}else{
			$this->error('删除失败，请重试！');
		}
	}

	// 更新点击显示与关闭
	public function ajax_click_type(){
		if(!myempty(I('id'))){
		$sql='UPDATE __TABLE__ SET `is_show`=ABS(is_show-1) WHERE ( ID='.I('id').' )';
		$data=M('type')->execute($sql);
		echo $data;
		}
	}


	/**
	 * [clearCache 清除缓存]
	 * @param  boolean $dellog [description]
	 * @return [type]          [description]
	 */
	public function clearCache($dellog = false) {
		header("Content-Type:text/html; charset=utf-8");//不然返回中文乱码

		//清除缓存
		is_dir(DATA_PATH . '_fields/') && del_dir_file(DATA_PATH . '_fields/', false);
		is_dir(CACHE_PATH) && del_dir_file(CACHE_PATH, false);//模板缓存（混编后的）
		//echo ('<p>清除模板缓存成功!</p>');
		is_dir(DATA_PATH) && del_dir_file(DATA_PATH, false);//项目数据（当使用快速缓存函数F的时候，缓存的数据）
		//echo ('<p>清除项目数据成功!</p>');
		is_dir(TEMP_PATH) && del_dir_file(TEMP_PATH, false);//项目缓存（当S方法缓存类型为File的时候，这里每个文件存放的就是缓存的数据）
		//echo ('<p>清除项目项目缓存成功!</p>');
		if ($dellog) {
			is_dir(LOG_PATH) && del_dir_file(LOG_PATH, false);//日志
		}
		is_file(RUNTIME_PATH.APP_MODE.'~runtime.php') && @unlink(RUNTIME_PATH.APP_MODE.'~runtime.php');//RUNTIME_FILE

       $this->success('清除系统缓存成功！');
	}

	
}
