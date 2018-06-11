<?php 
namespace Manage\Model;
use Think\Model;
use Think\Model\RelationModel;
class UserModel extends RelationModel{
	protected $tableName = 'user';
	protected $_link=array(
		"role"=>array(
			'mapping_type'=>  self::MANY_TO_MANY,    
			'foreign_key'=> 'user_id',    
			'relation_foreign_key'=>'role_id',
			'mapping_fields'=>'id,remark',    
			'relation_table' =>  'tp_role_user' 
		),
	);
} 
