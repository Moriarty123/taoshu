<?php
class BaseModel{
	//用于存储数据库工具的实例（对象）
	protected $_dao = null;
	function __construct(){
		$config = array( 
			'host' => "localhost",
			'port' => 3306,
			'user' => "root",
			'pwd' => "",
			'charset' => "utf8",
			'dbname' => "tao_shu"
		);
		$this->_dao = MySQLDB::GetInstance($config);
	}
}
?>