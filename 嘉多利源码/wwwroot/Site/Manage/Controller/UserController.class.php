<?php
namespace Manage\Controller;
use Think\Controller;
class UserController extends CommonController {
	
	/**
	 * 会员中心
	 * @return [type] [description]
	 */
    public function index(){
		echo  "User";
		$this->display();
    }
    //会员列表
    public function user_list(){
    	$db=D('user');
    	$field=array("ID","UserName");
    	$this->user=$db->field($field)->relation('role')->select();	
		if (session('Uname')==C('RBAC_SUPERADMIN')) {  
				   $this->admin=C('RBAC_SUPERADMIN');  
				}  	
		if (session('Uname')==C('RBAC_ADMIN')) {  
				   $this->admin=C('RBAC_ADMIN');  
				}  
    	$this->admin=C('RBAC_SUPERADMIN');
		//$this->admin=C('RBAC_ADMIN');
    	$this->display();
    }
    //后台添加会员
    public function add_user(){
    	$db=M('role');
    	$field=array('id','remark');
    	$this->role=$db->field($field)->where('status=1')->select();
    	$this->display();
    }
    //删除会员
    public function del_user(){
    	$db=D('user');
    	$where=array('ID'=>(int)$_GET['ID']);
    	$stmt=$db->relation('role')->where($where)->delete();
    	if($stmt){
    		$this->success('删除成功',U('User/user_list'),1);
    	}else{
    		$this->error('删除失败！');
    	}
    }
    //修改会员
    public function updata_user(){
    	//获取用户的身份
		$db=D('user');
    	$field=array("ID","UserName");	
    	$where="id=".$_GET["ID"];
    	$this->user=$db->field($field)->relation('role')->where($where)->find();
    	//查找所有的身份
    	$db=M('role');
    	$field=array('id','remark');
    	$this->role=$db->field($field)->where('status=1')->select();
    	//修改会员表
    	$up_user=M('user');
    	$field=array('ID'=>$_GET['uid']);
    	!empty($_POST['UserName'])?$user['UserName']=$_POST['UserName']:"";
			//密码为用户+已经加密的密码
		!empty($_POST['PassWord'])?$user['PassWord']=md5(md5($_POST['PassWord']).$_POST['UserName']):"";
    	$up_user->where($field)->save($user);
    	if($_POST['role_id']){
    		//清空原身份
    		$d_db=M('role_user');
    		$uid=array('user_id'=>$_GET['uid']);
    		$d_db->where($uid)->delete();
    		$this->add_role_user($_GET['uid'],$_POST['role_id']);
    		$this->success('修改成功！','',1);	
    		die;
    	}
    	$this->display();
    }
	
	  //修改管理员密码
    public function updata_admin(){

    	//修改会员表
    	$up_user=M('user');
    	//$field=array('ID'=>$_GET['uid']);
	$field=array('ID'=>session('user_id'));
    	!empty($_POST['UserName'])?$user['UserName']=$_POST['UserName']:"";
	//密码为用户+已经加密的密码
	!empty($_POST['PassWord'])?$user['PassWord']=md5(md5($_POST['PassWord']).$_POST['UserName']):"";
    	$up_user->where($field)->save($user);
    	if($_POST['UserName']){
    		$this->success('修改成功！','',1);	
    		die;
    	}
        	$this->display();

		
    }
	
	
    //后台添加会员表单
    public function add_user_form(){
    	if(!empty($_POST['UserName'])){
    		$data=M('user');
	    	$user['UserName']=$_POST['UserName'];
			//密码为用户+已经加密的密码
			$user['PassWord']=md5(md5($_POST['PassWord']).$_POST['UserName']);
			$user['Date']=date();
			$uid=$data->add($user);
			$this->add_role_user($uid,$_POST['id']);
			if($uid){
				$this->success('会员添加成功！','user_list',1);
			}else{
				$this->error('添加失败,请重试！','',1);
			}
    	}			
    }
    //设置会员身份
    public function add_role_user($uid,$rid){
    	if($uid && !empty($rid)){
			$db=M('role_user');
			$role_data=array('role_id'=>$rid,'user_id'=>$uid);
			$num=$db->add($role_data);
		}			
    }

    /**
     * 会员登录
     * 
     */
	public function login(){		
		$this->display();		
	}

	/**
     * 会员登录表单
     * 
     */
	public function login_form(){
		$data=D('User');
		if(isset($_POST)&&!empty($_POST['username'])){
			$where['UserName']=$_POST['username'];
			$where['PassWord']=md5(md5($_POST['password']).$_POST['username']);
			//获取会员信息
			$stmt=$data->where($where)->relation('role')->find();
			//如果会员的信息为真 ，则存进SESSION
			if(!empty($stmt)){ 
				session('Uname',$stmt['UserName']);
				session(C('USER_AUTH_KEY'),$stmt['ID']);
				!empty($stmt['role'])?session('Ustatus',$stmt['role'][0]['remark']):session('Ustatus','普通用户');
				//session('Ulevel',$stmt['Level']);
				//如果用户是超级管理员，则可以进行一切操作  
				if (session('Uname')==C('RBAC_SUPERADMIN')) {  
				    session(C('ADMIN_AUTH_KEY'),true);  
				}  	
				$rbac=new \Org\Util\Rbac();  
				//取出用户权限信息  
				$rbac::saveAccessList();
				// p($_SESSION);
				
				$this->success('登录成功！',U('Index/index'),1);
					
			}else{ 
				$this->error('对不起，用户名或密码错误！',U('User/login'),1);
			}
		}
	}

	/**
	 * 会员注册
	 * 
	 */
	public function register(){
		$data=M('user');
		$user['UserName']=$_POST['username'];
		//密码为用户+已经加密的密码
		$user['PassWord']=md5(md5($_POST['password']).$_POST['username']);
		$user['Date']=date();
		$yz=$data->add($user);
		if($yz){
			session('Uname',$_POST['username']);
			session('Uid',$yz);
			session('Ulevel',0);
			$this->success('注册成功！',U('index'),2);
		}
		$this->display();
	}

	//会员名注册验证
	public function slect_register(){
		if(!empty($_POST['username'])&&isset($_POST)){
			$data=M('user');
			$where['UserName']=$_POST['username'];
			$num=$data->where($where)->count();
			echo $num;
		}
	}

	/**
	 * 会员退出
	 * 
	 */
	public function userout(){
		session(null);
		if(isset($_COOKIE[session_name()])){
			setcookie(session_name(),'',time()-1,'/');
		}
		session_destroy();
		$this->success('退出成功！',U('login'),2);
	}

	//管理组
	public function manage(){ 
		$db=D('user');
		$field=array('ID','UserName');
		$ma=$db->relation('role')->field($field)->select();
		//遍历管理员
		foreach ($ma as $key => $value) {
			//p($ma[$key]['role']);
			if(empty($ma[$key]['role'])){
				unset($ma[$key]);
			}
		}
		$this->assign('ma',$ma);
		$this->display();
	}

	//调用验证码
	function code() {
		$config =array(
			// 验证码字体大小
			'fontSize'  =>  C('VFONTSIZE'),
			// 验证码位数
			'length'    =>  C('VLENTH'),
			//关闭混淆曲线 
			'useCurve'  =>  C('VUSECURVE'),
			//杂点
			'useNoise'  =>  C('VUSENOISE'),
		);
		//生成验证码
		$Verify = new \Think\Verify($config);
		$Verify->entry();
	}

	/**
	 * ajax 异步验证用户登录
	 * 
	 */
	public function yzlogin(){
		$username=trim(I('username')); 
		$password=trim(I('password'));
		$code=trim(I('code'));
		if(empty($username)) {die('用户名必填！');}
		if(empty($password)) {die('密码必填！'); }
		if(empty($code)) {die('验证码必填！') ;}
		$db=M('user');
		$where['UserName']=$username;
		$where['PassWord']=md5(md5($password).I('username'));
		$user=$db->where($where)->find();
		if(!$user){
			die('用户或密码错误！');
		}else{
			if(($user['UserName']==$username) && ($user['PassWord']==$where['PassWord'])){
				if(!check_verify($code)){
					die("验证码错误，点击图片切换！");
				}else{
					echo 1;
				}
			}else{
				die('用户或密码错误！');
			}
		}	
	}


}