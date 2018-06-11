<?php 
namespace Manage\Controller;
use Think\Controller;	
class CommonController extends Controller{
	Public function _initialize(){
        $sys=F('hxset','',CONF_PATH);     
        $this->htname=$sys['htname'];

    	if(!isset($_SESSION[C('USER_AUTH_KEY')])){
            if(CONTROLLER_NAME!="User" && ACTION_NAME!="login"){
               $this->redirect('User/login');  
            } 
    	}else{ 
            //$Language=session('edition');
            myempty(session('edition'))?session('edition',1):session('edition');
            $edition=M("edition")
                ->field("name,remark,edition")
                ->where(array("start"=>1,'edition'=>session('edition')))
                ->select();
            session('lng',$edition[0]['remark']);
            session('lngname',$edition[0]['name']);
            //判断是否为超级管理员
            if($_SESSION[C('ADMIN_AUTH_KEY')]){
                //通过common_data 来获取所有的节点
                $data=$this->common_data();
                //p($data); 
                $this->assign('data',$data);
                
                //p(session());
            }else{
                //P($_SESSION);
                //会员拥有的模块
                $user_model=null;
                //会员拥有的方法
                $user_action=null;
                $access_list=$_SESSION['_ACCESS_LIST'];
               //p($access_list);
                foreach($access_list as $value){
                    foreach ($value as $key1 => $value1) {
                        //获取会员所拥有的模块名
                        $user_model.=$key1.',';
                        //获取会员所拥有的方法
                        foreach ($value1 as $key2 => $value2) {
                          $user_action.=$value2.',';
                        } 
                    }                   
                }
                // p($user_action);
                // p($user_model);
                //调用公共方法获取节点
                $data2=$this->common_data();
                foreach ($data2 as $key1=>$val1) {
                    foreach ($val1['child'] as $key2=>$val2) {  
                        if(!in_array(strtoupper($val2['name']),explode(',', $user_model))){
                            //删除没有权限的模型
                            unset($data2[$key1]['child'][$key2]) ;
                        }else{
                            foreach ($val2['child'] as $key3=>$val3) {
                                if(!in_array($val3['id'], explode(',',$user_action))){
                                    //删除没有权限的方法
                                  unset($data2[$key1]['child'][$key2]['child'][$key3]) ; 
                                }
                            }
                        }                    
                    }
                }

             $this->data=$data2; 
            }
            //获取语言版本
            $db=M('edition');
            $lang=$db->where(array('start'=>1))->select();
            $this->assign('lang',$lang);
        }
        //获取不需验证的模块与方法
        $Auth=in_array(CONTROLLER_NAME,explode(',',C('NOT_AUTH_MODULE')))||in_array(ACTION_NAME,explode(',',C('NOT_AUTH_ACTION')));
        if(C('USER_AUTH_ON')&& !$Auth){
            $rbac=new \Org\Util\Rbac();  
            if(!$rbac::AccessDecision()){  
                //echo '<script type="text/javascript">alert("没有权限");</script>';
               $this->error('对不起，没有权限！',U('Index/index'),1);        
            }  
        }
        //检测是否登录，没有登录就打回设置的网关  
        //$rbac::checkLogin();  
        //检测是否有权限没有权限就做相应的处理  
        

    	
   	}

    public function lang(){
        session('edition',$_GET['edition']);
        $this->success("语言切换成功！");
    }

    /**
     * [common_data 获取节点] 公共方法
     * @return [type] [description]
     */
    public function common_data(){
       $data=M('node')->where('is_show=1')->order('sort')->select(); 
        //var_dump($data); 
        import("Class.expand",APP_PATH);
        $object = new \Expand(); 
        return $object->erwei($data);
    }

    /**
     * 获取栏目分类的方法
     * @return [返回一个模板变量] [在左侧分类中使用]
     */
   	public function column(){	
		$db=M('class');
    $field['PID']=0;
    $data=$db->where($field)->select();
    $this->assign('data',$data);
	}

    /**
     * [uploadImg 上传图片]
     * @return [type] [description]
     */
    public function uploadImg($cut=1){
        $up=upload($cut);    
        $path=$up['savepath'].$up['savename'];
        //echo json_encode(array('path'=>$path));
        echo json_encode(array('path'=>$path,'up'=>$up));
        die;
    }



}
