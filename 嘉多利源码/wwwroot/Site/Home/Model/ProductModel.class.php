<?php 
namespace Home\Model;
use Think\Model;
use Think\Model\RelationModel;
class ProductModel extends RelationModel{   
	protected $tableName = 'product';
	protected $_link=array(
		"content_on_type"=>array(
			'mapping_type'=> self::HAS_MANY,
			'foreign_key' => 'cid',
			'condition'=>'mid=6',
			'mapping_fields'=>'typekey,typeremark,typevalue',
		),
	);	
}