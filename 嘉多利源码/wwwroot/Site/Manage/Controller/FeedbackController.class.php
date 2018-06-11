<?php
namespace Manage\Controller;
use Think\Controller;
class FeedbackController extends CommonController {
	//单篇列表
	public function index(){
		$db=M('feedback');
		// 查询满足要求的总记录数
		$count=$db->count();
		//调用分页类  传入总记录数和每页显示的记录数
		$page= new \Think\Page($count,10);
		$page->setConfig('prev', "上一页");//上一页
		$page->setConfig('next', '下一页');//下一页
		$page->setConfig('first', '首页');//第一页
		$page->setConfig('last', "末页");//最后一页
		$page->setConfig ( 'theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
		$show=$page->show();
		$field=array("ID,Name,Title,Rdate");
		$where=array("Edition"=>session('edition'));
		$feedback_list=$db
			->field($field)
			->where($where)
			->order('ID desc')
			->limit($page->firstRow.','.$page->listRows)
			->select();
			//p($feedback_list);
		$this->Rdate=date('Y-m-d H:i:s',$feedback_list['Rdate']);
		$this->assign('feedback_list',$feedback_list);
		$this->assign('show',$show);
		$this->display();
	}

	
	//删除单篇内容
	public function delete_feedback(){
		if(!empty($_GET['aid']) || !empty($_POST['del'])){
			$db=M('feedback');
			//将获取的数组转化成字符串
			$del=implode(',',$_POST['del']);
			//判断删除是多条还是一条
			!empty($_GET['aid'])?$where=array('ID'=>$_GET['aid']):$where=array('ID'=>array('in',$del));
			$num=$db->where($where)->delete();
			if($num){
				
				if($num==1 && $_GET['bz']==1){
					$this->success('成功删除'.$num.'篇反馈信息',U('index',array('p'=>$_GET['p'] )),1);	
				}else{
					$this->success('成功删除'.$num.'篇反馈信息',U('index',array('p'=>$_POST['p'] )),1);	
				}
			}else{
				$this->error('删除失败！请重试','',1);
			}
		}
	}

	//显示反馈内容
	public function show_feedback(){
		//echo $_GET('id');
		$data=M('feedback')->where('ID='.$_POST['id'].' ')->find();

		$str=<<<eof
		<div class="dh_content">
	           	<ul>
           		<li>
           			<span class="mrtitle fl">留言标题：</span>
           			{$data['Title']}
           		</li>
           		<li>
           			<span class="mrtitle fl">留言人：</span>
           			{$data['Name']}
           		</li>
           		<li>
           			<span class="mrtitle fl">公司：</span>
           			{$data['Company']}
           		</li>
           		<li>
           			<span class="mrtitle fl">电话：</span>
           			{$data['Tel']}
           		</li>
				<li>
           			<span class="mrtitle fl">QQ：</span>
           			{$data['QQ']}
           		</li>
           		
           		<li>
           			<span class="mrtitle fl">手机：</span>
			{$data['Phone']}
           		</li>
           		<li>
           			<span class="mrtitle fl">E-mail：</span>
			{$data['Email']}
           		</li>
  
           		<li>
           			<span class="mrtitle fl">地址：</span>
			{$data['Address']}
           		</li>
           		<li>
           			<span class="mrtitle fl">内容：</span>
			{$data['Content']}
           		</li>

            </ul>
        </div>
eof;
echo $str;
	}


}



