<?php


//自定义数组打印函数
function p($data){
	echo"<pre>";
	print_r($data);
	echo"</pre>";
}

/**
 * [check_verify 验证码]
 * @param  [type] $code [description]
 * @param  string $id   [description]
 * @return [type]       [description]
 */
function check_verify($code, $id = ''){    
    $verify = new \Think\Verify();    
    return $verify->check($code, $id);
}

/**
 * [Fpage 设置分页]
 * @param [type] $count []
 */
function Fpage($count,$pagesize=0){
empty($pagesize)?$pagesize=C('FPage'):$pagesize;
$page=new \Think\Page($count,$pagesize);
$page->setConfig('header','<span class="rows">'.L('total').' %TOTAL_ROW% '.L('information').' %NOW_PAGE% / %TOTAL_PAGE% '.L('page').'</span>');
$page->setConfig('prev',"&laquo;"); //上一页
$page->setConfig('next','&raquo;'); //下一页
$page->setConfig('first',L('first'));  //第一页
$page->setConfig('last',L('last'));   //最后一页
$page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%'); 
return $page;
}


 
/**
 * 获取当前模型的栏目
 * @param  string $field [传递一个要添加文章的栏目ID  一般在栏目中添加文章是会用到 （可以为空）]
 * @return [type]        [description]
 */
function on_class($field=""){
	$db=D("Column");
            $num=$db->field("Sort",ture)->where($field)->relation('model')->order('Sort')->select();

	return $num;
}


/**
 * [tablename 判断用提交到哪一个表]
 * @param  [type] $t_name [传递一个表名]
 * @param  [type] $id     [传递一个ID号 用于判断提交到哪一个栏目下]
 * @return [type]         [表名]
 */
function tablename($id){	
	!empty($id)?$where=array('ID'=>$id):"";
		$db=D('Column');
		$stmt=$db->field("PID,Sort",ture)->where($where)->relation(true)->find();
		$tablename=$stmt['TableName'];
        
	return $tablename;	
}

/**
 * [blnav 遍历导航栏目]
 * @param  string $ModelID [判断调用哪一个模型的数据]
 * @param  string $level   [调用分类的级别]
 * @param  int    $limit   [调用分类的级别]
 * @return [type]          [description]
 */
function blnav($limit='',$level='',$ModelID='')
{	
    !empty($ModelID)?$where['ModelID']=$ModelID:$where='';
    !empty($level)?$where['depth']=array('elt',$level):'';
	$where['Status']=1;
    $where['Edition']=C('EDITION');
	$order=array('Sort ASC');
    if($limit){
        $nav=D("Menu")->where($where)->relation(array("model","class_on_type"))->order($order)->limit($limit)->select();  
    }else{
        $nav=D("Menu")->where($where)->relation(array("model","class_on_type"))->order($order)->select();
    }
    return $nav;
}

/**
 * [get_file 遍历模板目录下的主题]
 * @param  string $dirname [默认Templates文件夹]
 * @return [type]          [所有子文件]
 */
function get_file($dirname='Templates',$pathtype='Show'){
    $dirhandle=opendir($dirname);
    while ($file=readdir($dirhandle)) {
        $path='';
        //将解决中文目录名乱码问题
        $file = iconv('GB2312','UTF-8',$file);
        if($pathtype!=''){
            $path=$pathtype.'_';   
        }      
        if($file!='.'&& $file!='..'){
            $filename[]=$path.$file;
        }   
    }
    closedir($dirname);
    return $filename;
}


/**
 * [get_url 获取前台的url    根据内容的id取到当前id的路径]
 * @param  [int] $classid    [分类的ID]
 * @param  [string] $id      [内容ID 可选参数] 不填则默认为空 为空则认为是列表的链接
 * @return [type]            [description]
 */
function get_url($classid,$id=null){
    $data=M('class')->field('systemplist,systempshow')->where("ID={$classid}")->find();
    $list=$data['systemplist'];
    $show=$data['systempshow'];
    !empty($list)&&empty($id)?$temp=$list:$temp=$show;// 判断模板的类型
  
    // 判断是否有模板，没有则返回网站首页
    if(empty($temp)){
        return U('Index');
    }

    // 切分库中的模板文件名
    $temparr=explode('_', $temp);
    $controller=$temparr[0];    //控制器
    $actionhtml=$temparr[1];    //操作 带后缀
    // 去掉 操作的后缀
    $count=strpos($actionhtml,C('TMPL_TEMPLATE_SUFFIX')); 
    $action=substr_replace($actionhtml,"",$count); 
    // 拼接成url地址 并判断是否开启路由
    if(C('URL_ROUTER_ON')==true){
        // 判断列表页还是内容页 有$id则是内容页
        empty($id)?$newurl=U('/'.$action.$classid):$newurl=U('/'.$action.$classid.'/detail'.$id);   
    }else{
        $newurl=U($controller.'/'.$action,array('cid'=>$classid,'id'=>$id));
    }
    return $newurl;
}





////////////////////////////////////////////////////////////////////
// PHP截取中英文及标点符号混合的字符串函数（绝对不会出现乱码）
// 本程序在utf-8、gb2312中测试通过。使用者自行测试big5。
// 函数 left( 源字符串, 截取指定的字符串个数, 编码（可省略，默认为utf-8） )
////////////////////////////////////////////////////////////////////

function substr_cut($str, $len, $charset="utf-8")
{
    //如果截取长度小于等于0，则返回空
    if( is_numeric($len) && $len <= 0 )
    {
        return "";
    }

    // 如果截取的长度为max,则为不进行截取
    if($len=='max'){
        return $str;
    }

    //如果截取长度大于总字符串长度，则直接返回当前字符串
    $sLen = strlen($str);
    if( $len >= $sLen )
    {
        return $str;
    }
 
    //判断使用什么编码，默认为utf-8
    if ( strtolower($charset) == "utf-8" )
    {
        $len_step = 3; //如果是utf-8编码，则中文字符长度为3  
    }else{
        $len_step = 2; //如果是gb2312或big5编码，则中文字符长度为2
    } 

    //执行截取操作
    $len_i = 0; 
    //初始化计数当前已截取的字符串个数，此值为字符串的个数值（非字节数）
    $substr_len = 0; //初始化应该要截取的总字节数
    for( $i=0; $i < $sLen; $i++ )
    {  
        if ( $len_i >= $len ) break; //总截取$len个字符串后，停止循环
        //判断，如果是中文字符串，则当前总字节数加上相应编码的中文字符长度
        if( ord(substr($str,$i,1)) > 0xa0 )
        {
            $i += $len_step - 1;
            $substr_len += $len_step;
        }else{ //否则，为英文字符，加1个字节
            $substr_len ++;
        }
    $len_i ++;
    }
    //判断截取字符后加 “...”
    if($substr_len<$sLen){
        $result_str = substr($str,0,$substr_len )."...";
    }else{
        $result_str = substr($str,0,$substr_len );
    }
    return $result_str;
}


/**
 * [classNav 遍历生成分类列表]
 * @param  [type]  $column [数组]
 * @param  integer $i      []
 * @return [type]          [description]
 */
function classNav($column,$i=1){
    $style='ctitle'.$i;
    $towpath=D("Menu")->field('path')->where('ID='.I('get.cid'))->relation('class_on_type')->find();
    $towpath['path']=explode(',',$towpath['path']);
    $on='';
    if(in_array($column[0]['PID'],$towpath['path'])){
        $on="on";
    }
    $str= "<ul class='{$style} {$on} menu_body'>";
    $i+=1;   
    foreach ($column as $v) {
        $class='';  
        $class=$_GET['cid']==$v['ID']?'class="on"':'class=""'; 
        if($v['Child']!=0){
            $str.="<li ".$class."><a>{$v['Name']}</a>";    
            $str.=classNav($v['find'],$i); 
            $str.="</li>";  
        }else{
             // 判断是否填写了外部链接 与是否开启新窗口打开
                $outurl='';
                $target='';
                foreach ($v['class_on_type'] as $vo ) {
                    if($vo['typeid']==2){
                        $outurl=$vo['typevalue'];
                    }
                    if($vo['typeid']==5){
                        $target=$vo['typevalue'];
                    }
                }        

            //判断链接是否新窗口打开
            if($target){
                $v['target']='target="_blank"'; 
            }else{
                $v['target']='';    
            }

            if(!empty($outurl)){
                 $str.= "<li><a ".$class." href='".$outurl."' target='".$v['target']."'>{$v['Name']}</a></li>"; 
            }else{
               $str.= "<li ".$class."><a  href='".get_url($v['ID'])."' target='".$v['target']."'>{$v['Name']}</a></li>";  
            }
               
        }       
    }
    $str.="</ul>";
    return $str;
}


/**
 * [classNav 遍历生成分类列表]
 * @param  [type]  $column [数组]
 * @param  integer $i      []
 * @return [type]          [description]
 */
function classNavv($column,$i=1){
    $style='ctitle'.$i;
    $towpath=D("Menu")->field('path')->where('ID='.I('get.cid'))->relation('class_on_type')->find();
    $towpath['path']=explode(',',$towpath['path']);
    $on='';
    if(in_array($column[0]['PID'],$towpath['path'])){
        $on="on";
    }
    $str= "<ul class='ctitle2'>";
    $i+=1;   
    foreach ($column as $v) {
        $class='';  
        $class=$_GET['cid']==$v['ID']?'class="on"':'class=""'; 
        if($v['Child']!=0){
           $str.="<li ".$class."><a href='".get_url($v['ID'])."'>{$v['Name']}</a>";    
           // $str.=classNavv($v['find'],$i); 
            $str.="</li>";  
        }else{
            // 判断是否填写了外部链接 与是否开启新窗口打开
                $outurl='';
                $target='';
                foreach ($v['class_on_type'] as $vo ) {
                    if($vo['typeid']==2){
                        $outurl=$vo['typevalue'];
                    }
                    if($vo['typeid']==5){
                        $target=$vo['typevalue'];
                    }
                }   

            //判断链接是否新窗口打开
            if($target){
                $v['target']='target="_blank"'; 
            }else{
                $v['target']='';    
            }

            if(!empty($outurl)){
                 $str.= "<li ><a  ".$class." href='".$outurl."' target='".$v['target']."'>{$v['Name']}</a></li>"; 
            }else{
               $str.= "<li  ".$class."><a href='".get_url($v['ID'])."' target='".$v['target']."'>{$v['Name']}</a></li>";  
            }
               
        }       
    }
    $str.="</ul>";
    return $str;
}

/**
 * [classNav 遍历生成分类列表]
 * @param  [type]  $column [数组]
 * @param  integer $i      []
 * @return [type]          [description]
 */
function classNavvv($column,$i=1){
    $style='ctitle'.$i;
    $towpath=D("Menu")->field('path')->where('ID='.I('get.cid'))->relation('class_on_type')->find();
    $towpath['path']=explode(',',$towpath['path']);
    $on='';
    if(in_array($column[0]['PID'],$towpath['path'])){
        $on="on";
    }
    $str= "<ul class='ny-news-btn'>";
    $i+=1;   
    foreach ($column as $v) {
        $class='';  
        $class=$_GET['cid']==$v['ID']?'class="on menu_head"':'class="menu_head"'; 
        if($v['Child']!=0){
            $str.="<li><a ".$class.">{$v['Name']}</a>";    
            $str.=classNav($v['find'],$i); 
            $str.="</li>";  
        }else{
             // 判断是否填写了外部链接 与是否开启新窗口打开
                $outurl='';
                $target='';
                foreach ($v['class_on_type'] as $vo ) {
                    if($vo['typeid']==2){
                        $outurl=$vo['typevalue'];
                    }
                    if($vo['typeid']==5){
                        $target=$vo['typevalue'];
                    }
                }        

            //判断链接是否新窗口打开
            if($target){
                $v['target']='target="_blank"'; 
            }else{
                $v['target']='';    
            }

            if(!empty($outurl)){
                 $str.= "<li><a ".$class." href='".$outurl."' target='".$v['target']."'>{$v['Name']}</a></li>"; 
            }else{
               $str.= "<li ".$class."><a href='".get_url($v['ID'])."' target='".$v['target']."'>{$v['Name']}</a></li>";  
            }
               
        }       
    }
    $str.="</ul>";
    return $str;
}

// 替换empty函数
function myempty($data){
    $v=$data;
    return empty($v);
}


// 判断是否为手机
function ismobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;
    
    //此条摘自TPM智能切换模板引擎，适合TPM开发
    if(isset ($_SERVER['HTTP_CLIENT']) &&'PhoneClient'==$_SERVER['HTTP_CLIENT'])
        return true;
    //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
        //找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
    //判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array(
            'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile'
        );
        //从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    //协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
 }

/**
 * [bltype 获取自定义属性]
 * @param  [type] $module [模型ID]
 * @return [type]         [description]
 */
function bltype($module){
    $where=array(
        'typemodule'=>$module
        ,'is_show'=>1
    );
    return M('type')->field("typename",true)->where($where)->order('typeorder')->select();
}


/**
 * 循环删除目录和文件函数
 * @param string $dirName 路径
 * @param boolean $fileFlag 是否删除目录
 * @return void
 */
function del_dir_file($dirName, $bFlag = false ) {
    if ( $handle = opendir( "$dirName" ) ) {
        while ( false !== ( $item = readdir( $handle ) ) ) {
            if ( $item != "." && $item != ".." ) {
                if ( is_dir( "$dirName/$item" ) ) {
                    del_dir_file("$dirName/$item", $bFlag);
                } else {
                    unlink( "$dirName/$item" );
                }
            }
        }
        closedir( $handle );
        if($bFlag) rmdir($dirName);
    }
}




