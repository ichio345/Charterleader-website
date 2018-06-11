<?php 
class Expand{ 
	/**
	 *  二维无限级分类
	 * @param  [type] $column [未转化的数组]
	 * @param  [type] $pid    [从哪一个值开始]
	 * @return [type]         [description]
	 */
	Static Public function erwei($column,$access=null,$pid=0){ 
		$arr=array();
		foreach ($column as $v) {
			if(is_array($access)){
				if (in_array($v['id'], $access)) {
					$v['access']=1;
				}else{
					$v['access']=0;
				}
			}
			if($v['pid']==$pid){ 
				$v['child']=self::erwei($column,$access,$v['id']);
				$arr[]=$v;
			}
		}
		return $arr;	
	}
	
	/**
	 *  二维无限级分类
	 * @param  [type] $column [未转化的数组]
	 * @param  [type] $pid    [从哪一个值开始]
	 * @return [type]         [description]
	 *
	 * 与上面的pid不相同 
	 */
	Static Public function erwei2($column,$access=null,$pid=0){ 
		$arr=array();
		foreach ($column as $v) {
			//var_dump($access);
			if(is_array($access)){
				if (in_array($v['ID'], $access)) {
					$v['access']=1;
				}else{
					$v['access']=0;
				}
			}
			if($v['PID']==$pid){ 
				$v['find']=self::erwei2($column,$access,$v['ID']);
				$arr[]=$v;
			}
		}
		return $arr;	
	}

	/**
	 * [menu_arr 导航条的多维数组]
	 * @param  [type]  $column [未转化的数组]
	 * @param  integer $pid    [导航的PID]
	 * @return [type]          [转化后的数组]
	 */
	Static Public function menu_arr($column,$pid=0){ 
		$arr=array();
		foreach ($column as $v) {
			if($v['PID']==$pid){ 
				$v['find']=self::menu_arr($column,$v['ID']);

				// 判断是否填写了外部链接 与是否开启新窗口打开
				$outurl='';
				$target='';
				if($v['class_on_type']){
					foreach ($v['class_on_type'] as $vo ) {
						if($vo['typeid']==2){
							$outurl=$vo['typevalue'];
						}
						if($vo['typeid']==5){
							$target=$vo['typevalue'];
						}
					}	
				}
				if(!empty($outurl)){
					$v['link']=$outurl;
				}else{
					$v['link']=get_url($v['ID']);	
				}
				//判断链接是否新窗口打开
				if($target){
					$v['target']='target="_blank"';	
				}else{
					$v['target']='';	
				}
				//替换原来的name
				$v['name']=$v["Name"];
				$v['src']=__ROOT__."/Upload".$v["Class_pic"];
				$arr[]=$v;
			}

		}
		return $arr;	
	}

	
	/**
	 * [yiwei 一维无限级分类]
	 * @param  [type]  $cate [要转换的数组]
	 * @param  integer $pid  [所属分类的ID 一般不需要传 但数组里面必须有这个字段 ]
	 * @return [type]  $cid  [数组的ID 如果数组的ID关联名不为cid时 则需要传入数组ID的关联名]
	 */
	 Static Public function yiwei($cate,$cid="cid",$html = '-', $pid = 0, $level = 0) {
            $arr = array();
            foreach ($cate as $k => $v) {
                if ($v['PID'] == $pid) {
                    $v['level'] = $level + 1;
                    $v['html']  = str_repeat($html, $level);
                    $arr[] = $v;
                    $arr = array_merge($arr, self::yiwei($cate,$cid, $html, $v[$cid], $level + 1));
                }
            }
            return $arr;
        }

}
	