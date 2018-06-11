<?php 
namespace Manage\Model;
use Think\Model;
use Think\Model\RelationModel;
class ColumnModel extends RelationModel{
	protected $tableName = 'class';
	protected $_link=array(
		"model"=>array(
			'mapping_type'=> self::BELONGS_TO,
			'foreign_key' => 'ModelID',
			 'mapping_fields'=>'TableName,Name,Title',
			 'as_fields'=>'TableName,Name:mname,Title',
		),
		
	);	
} 
