<?php
namespace Home\Controller;
use Think\Controller;
class ShowController extends CommonController{
	public function _initialize(){
		parent::_initialize();
		$action=ACTION_NAME;
		
		switch ($action) {
			case 'product':
				$where=array("ID"=>I('id'));
				$content=M('product')->where($where)->find();
				$content['Thumbnail']=explode("###",$content['Thumbnail']);
				$content['fm']=$content['Thumbnail'][$content['Cover']];		
				$this->assign('content',$content);
				// 上一条
				$this->prev=$this->newsinfo('product','prev',I('get.id'),I('get.cid'));
				// 下一条
				$this->next=$this->newsinfo('product','next',I('get.id'),I('get.cid'));

				$db=M('product');
				$field=array(
				'Click'=>$content['Click']+1
				
				);
				$db->where($where)->save($field);

				break;
			case 'article':
				$where=array("ID"=>I('id'));
				$content=M('article')->where($where)->find();
				$content['Thumbnail']=explode("###",$content['Thumbnail']);
				$content['fm']=$content['Thumbnail'][$content['Cover']];				
				// 上一条
				$prev=$this->newsinfo('article','prev',I('get.id'),I('get.cid'));
				// 下一条
				$next=$this->newsinfo('article','next',I('get.id'),I('get.cid'));
				$this->assign('content',$content);
				$this->assign('prev',$prev);
				$this->assign('next',$next);

				$db=M('article');
				$field=array(
				'Click'=>$content['Click']+1
				
				);
				$db->where($where)->save($field);

				break;
			case 'picture':
				$where=array("ID"=>I('id'));
				$content=M('pic')->where($where)->find();
				$content['Thumbnail']=explode("###",$content['Thumbnail']);
				$content['fm']=$content['Thumbnail'][$content['Cover']];		
				$this->assign('content',$content);
				// 上一条
				$this->prev=$this->newsinfo('pic','prev',I('get.id'),I('get.cid'));
				// 下一条
				$this->next=$this->newsinfo('pic','next',I('get.id'),I('get.cid'));

				$db=M('pic');
				$field=array(
				'Click'=>$content['Click']+1
				
				);
				$db->where($where)->save($field);
				break;	
			default:

				$where=array('ClassID'=>I('get.cid'));
				$content=M('about')->where($where)->find();
				if($content){
					$this->assign('content',$content);
				}

				$db=M('about');
				$field=array(
				'Click'=>$content['Click']+1
				
				);
				$db->where($where)->save($field);
				break;
		}

		if($action!='feedback_from'){
			//$this->display($action);
		}	
	}

	

	/**
	 * [show_feedback_from 客户留言提交]
	 * @return [type] [description]
	 */
	public function feedback_from(){
		$verify = new \Think\Verify();
		 if($verify->check(I('post.code'))){
			$field=array(
				'Title'=>I('title'),
				'Content'=>I('content'),
				'Name'=>I('name'),
				'Company'=>I('company'),
				'Tel'=>I('tel'),
				'QQ'=>I('qq'),
				'Phone'=>I('phone'),
				'Email'=>I('email'),
				'Address'=>I('address'),
				'Rdate'=>time(),
				'Edition'=>C('EDITION')
			);
			$emcontent="易动力网络友情提醒您：有客户从您的网站给您发来了咨询信息，由于此邮件是系统自动发出，请根据客户所填的邮件地址回复，不要直接回复，谢谢！<br>";
			$emcontent.="<b>标题：</b>".I('title')."<br>";
			$emcontent.="<b>内容：</b>".I('content')."<br>";
			$emcontent.="<b>联系人：</b>".I('name')."<br>";
			$emcontent.="<b>公司名称：</b>".I('company')."<br>";
			$emcontent.="<b>电话：</b>".I('tel')."<br>";
			$emcontent.="<b>QQ：</b>".I('qq')."<br>";
			$emcontent.="<b>手机：</b>".I('phone')."<br>";
			$emcontent.="<b>E-mail：</b>".I('email')."<br>";
			$emcontent.="<b>地址：</b>".I('address')."<br>";
			$jsemail = $_POST['jsemail'];
			//echo $jsemail;
			//exit();
			$num=M('feedback')->add($field);
			if($num){
					if($jsemail != ''){

					//	$this->sendMail($jsemail, "网站咨询",$emcontent);

					}
				$this->success("成功提交信息，我们尽快给您回复！");
			}else{
				$this->error(L('ferror'));
			}
	
		}else{

			$this->error('验证码错误',U('/feedback6'),3);
		}


	}



}
