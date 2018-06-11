<?php 
namespace Home\Model;
use Think\Model;
use Think\Model\RelationModel;
class MenuModel extends RelationModel{
	protected $tableName = 'class';
	protected $_link=array(
		"model"=>array(
			'mapping_type'=> self::BELONGS_TO,
			'foreign_key' => 'ModelID',
			 'mapping_fields'=>'TableName,Name,Title,systemplist',
			 'as_fields'=>'TableName,Name:mname,Title,systemplist',
		),
		"class_on_type"=>array(
			'mapping_type'=> self::HAS_MANY,
			'foreign_key' => 'cid',
			'condition'=>'(typeid=2 or typeid=5)',
			'mapping_fields'=>'typeid,typevalue',
		),
	);	
} 
