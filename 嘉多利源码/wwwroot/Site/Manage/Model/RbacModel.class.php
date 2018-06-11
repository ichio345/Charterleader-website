<?php 
namespace Manage\Model;
use Think\Model;
use Think\Model\RelationModel;
class RbacModel extends RelationModel{
	protected $tableName = 'role';
	protected $_link=array(
		 "access"=>array(
			'mapping_type'=>  self::HAS_MANY,    
			'foreign_key'   => 'role_id'
		),
	);
} 
