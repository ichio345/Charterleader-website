<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller{
	Public function _initialize(){
		$lng=session('lng');		
		// 判断如果session中不存在lng则再通过数据库查询
		if(!$lng){
			// 查询当前模板的语言
			$edition=M('edition')->field('Remark')->where('edition='.C('EDITION'))->find();
			$lng=$edition['Remark'];
			// 将数据库中的查询到的语言值存入session中
			session('lng',$lng);
		}
		$sys=F('system2','',CONF_PATH);
		$sysstem=$sys['system'][$lng];
		
        // 设置语言对应的模板
        if($lng=='en'){ 
        	C('EDITION',2);      
			C('DEFAULT_THEME','en');
			C('TMURL',__ROOT__."/Templates/en/Common");
        }

        //判断是否为手机访问  
		//if (ismobile()) {
		//	  if($lng=='cn'){ 
		//	        C('EDITION',1); 
		//			C('DEFAULT_THEME','mobile');
		//			C('TMURL',__ROOT__."/Templates/mobile/Common");
		//	  }else{
		//		    C('EDITION',2); 
		//			C('DEFAULT_THEME','mobilee');
		//			C('TMURL',__ROOT__."/Templates/mobilee/Common");
		//	  }
       //  } 
        
        
        // 将数组直接转化为变量
		extract($sysstem);
		//网站备案号
		$this->assign('beian',$beian);
		//网站统计
		$this->assign('wztj',$wztj);
		//网站地址
		$this->assign('address',$address);
		//网站电话
		$this->assign('tel',$tel);
		//网站手机
		$this->assign('phone',$phone);
		// 邮箱
		$this->assign('email',$email);
		// QQ
		$this->assign('qq',$qq);
		// 网站名
		$this->assign('sitename',$sitename);
		
		
		$seo=F('system2','',CONF_PATH)['seo'][$lng];
		extract($seo);
		//网站标题
		$this->assign('title',$title);
		//网站关键词
		$this->assign('keywords',$keywords);
		//网站描述
		$this->assign('description',$description);
		
		$cid=I('cid');
		if(!empty($cid)){
			$path=M('class')->where(array('ID'=>$cid))->getField('path');
			!empty($path)?$id=explode(',', $path)[0]:$id=I('cid');
		}
		$classname=M('class')->where(array('ID'=>$id))->getField('Name');

		$this->assign('classname',$classname);

	}

	// 在线客服QQ
	public function qq(){
		$qq=F('qq','',CONF_PATH);
		$this->assign('qq',$qq);
		$this->display("qq");
	}

	/**
	 * [lang 切换语言]
	 * @return [type] [description]
	 */
	public function lang($lng){
		session('lng',$lng);
		$this->redirect("Index/index");
	}

	/**
	 * [searchCon 查找指定的数据内容]
	 * @param  [type] $table     [表名]
	 * @param  [type] $direction [方向]
	 * @param  [type] $id 		 [id]
	 * @return [type]            [description]
	 */
	public function searchCon($table,$direction,$id='',$cid=''){
		$db=M("{$table}");
		// 判断方向 
		switch ($direction) {
			case 'prev':
				$fx='gt';
				$order="Click DESC";
				break;
			case 'next':
				$fx='lt';
				$order="Click ASC";
				break;			
		}

		// 查找的字段
		$field=array('ID','ClassID','Title','Click');		
		$newdata='';
		// 如果为空 则返回
		$str=L('not');
		$id=empty($id)?I('id'):$id;
		$where=array(
			'Edition'=>C('EDITION')
		);
		$click=$db->where(array('ID'=>$id))->getField('Click');
		// 判断 点击是否为0
		if($click ==0){
			$min=$db->where('Click=0')->order("ID ASC")->getField('ID');
			$max=$db->where('Click=0')->order("ID DESC")->getField('ID');
			$where['Click']=array("eq",0);
			// 判断最小的 如果是最小的则找到 click 为0 中的ID 最大的一个
			if($max==$id){
				if($fx=='gt'){
					$where['Click']=array("gt",$click);
					$order="Click ASC";
				}else{
					$where['ID']=array("{$fx}",$id);
					$where['Click']=array("eq",0);
					$order="ID DESC";
				}
			}else{
				$where['ID']=array("{$fx}",$id);
				$order="ID DESC";
				if($fx=='gt' || $min==$id ){
					$order="ID ASC";
				}
			}
		}else{
			$min=$db->where('Click>0')->order("Click ASC")->getField('ID');
			$max=$db->where('Click>0')->order("Click DESC")->getField('ID');
			// 判断最小的 如果是最小的则找到 click 为0 中的ID 最大的一个
			if($min==$id){
				if($fx=='lt'){
					$where['Click']=array("eq",0);
					$order="ID DESC";
				}else{
					$where['Click']=array("gt",$click);
					$order="Click ASC";
				}
			}else{
				$where['Click']=array("{$fx}",$click);
				// 判断是否为最大的 如果是最大的 则按倒序  
				$order="Click ASC";
				if($fx=='lt' ||$max==$id){
					$order="Click DESC";
				}	
			}
		}
		if(!empty($cid)){
			$where['ClassID'] = array("eq",$cid);
		}
		$data=$db->field($field)->where($where)->order($order)->find();	
		
		if(myempty($data)){
			$newdata['title']=$str;
			$newdata['link']='';
			return $newdata;
		}
		$newdata['title']=$data['Title'];
		$newdata['id']=$data['ID'];
		$newdata['cid']=$data['ClassID'];
		$newdata['link']=get_url($data['ClassID'],$data['ID']);
		return $newdata;
	}
	
	
	
		/**
     *上下页代码
     */
	public function newsinfo($table,$direction,$id,$cid){
		$id=empty($id)?I('id'):$id;
		$cid=empty($cid)?I('cid'):$cid;
		$field=array('ID','ClassID','Title','Click');	
		$db=M("{$table}");
		$str=L('not');
	switch ($direction) {
			case 'prev':
			    $where['ClassID'] = array("eq",$cid);
				$where['ID'] = array("lt",$id);
				$order="ID DESC";
				$data=$db->where($where)->order($order)->limit('1')->find();	
				break;
			case 'next':
			    $where['ClassID'] = array("eq",$cid);
				$where['ID'] = array("gt",$id);
				$order="ID ASC";
				$data=$db->where($where)->order($order)->limit('1')->find();
				break;			
		}	
		if(myempty($data)){
			$newdata['title']=$str;
			$newdata['src']='Common/images/not-pic.jpg';
			$newdata['link']='';
			return $newdata;
		}
		$newdata['title']=$data['Title'];
		$data['Thumbnail']=explode("###",$data['Thumbnail']);
		$newdata['src']='Upload'.$data['Thumbnail'][$data['Cover']];
		
		$newdata['id']=$data['ID'];
		$newdata['cid']=$data['ClassID'];
		$newdata['link']=get_url($data['ClassID'],$data['ID']);
		return $newdata;
  //$this->info = M("{$table}")->where("cid=".$cid." and id=".$id)->find();
 // $this->front=M("{$table}")->where("cid=".$cid." and id<".$id])->order('id desc')->limit('1')->find();
 // $this->after=M("{$table}")->where("cid=".$cid." and id>".$id)->order('id desc')->limit('1')->find();
 // $this->display();
 }
	
	
	
    /**
     * 邮件发送函数
     */
function sendMail($to, $title, $content) {
        import("Class.phpmailer.phpmailer",APP_PATH,'.php');   
        $mail = new \PHPMailer(); //实例化
        $mail->IsSMTP(); // 启用SMTP
        $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
        $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
        $mail->Username = C('MAIL_USERNAME'); //你的邮箱名
        $mail->Password = C('MAIL_PASSWORD') ; //邮箱密码
        $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
        $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
        $mail->AddAddress($to,"尊敬的客户");
        $mail->WordWrap = 50; //设置每行字符长度
        $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
        $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
        $mail->Subject =$title; //邮件主题
        $mail->Body = $content; //邮件内容
        $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
        return($mail->Send());
    }



public function verify() {
	
	
        $verify = new \Think\Verify();
        $verify->entry();
	
		
		
		
    }

		
}