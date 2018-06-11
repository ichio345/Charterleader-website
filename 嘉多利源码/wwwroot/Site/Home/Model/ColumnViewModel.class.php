<?php 
namespace Home\Model;
use Think\Model\ViewModel;
class ColumnViewModel extends ViewModel {   
	public $viewFields = array(    
	'class'=>array('ID','Name','Remark','Class_pic','Class_info','_type'=>'LEFT'),     
	'class_on_type'=>array('cid','typeid','typekey','typevalue','_on'=>'class.ID=class_on_type.cid'),
	);
}