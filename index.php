<?php
//有可能是User 也有可能是 Product ，或其他
//默认是是 User
$c = !empty($_GET['c']) ? $_GET['c'] : "index";
//确定平台，默认为 front 前台
$p = !empty($_GET['p']) ? $_GET['p'] : "front";

define("PLAT", $p);  
define("DS", DIRECTORY_SEPARATOR);  //DIRECTORY_SEPARATOR 表示“目录分隔符”
							//它的值只有2个：'/'(unix系统)，'\'(window系统)
define("ROOT", __DIR__ . DS);  //当前MVC框架的根目录
define("APP", ROOT . 'Application' . DS); //application的完整路径
define("FRAMEWORK", ROOT . 'Framework' . DS); //框架基础类所在路径
define("PLAT_PATH", APP . PLAT . DS); //当前平台所在目录
define("CTRL_PATH", PLAT_PATH . 'Controllers' . DS); //当前控制器所在目录
define("MODEL_PATH", PLAT_PATH . 'Models' . DS); //当前模型所在目录
define("VIEW_PATH", PLAT_PATH . 'Views' . DS); //当前视图所在目录

//自动加载函数
function __autoload($class){
	$base_class = array('MySQLDB','BaseModel','BaseController','ModelFactory');
	if ( in_array($class, $base_class) ) {
		require FRAMEWORK . $class . '.class.php';  //加载基础模型类
	}
	else if (substr($class, -5) == "Model") { //所需的类的名字的最后5个字符是Model时
		require MODEL_PATH . $class . '.class.php';
	}
	else if (substr($class, -10) == "Controller") { //所需的类的名字的最后10个字符是Controller时
		require CTRL_PATH . $class . '.class.php';
	}
}
//以下 6 行代码，被上面自动加载所代替
/*
require FRAMEWORK . 'MySQLDB.class.php';					
require FRAMEWORK . 'BaseModel.class.php'; 
require FRAMEWORK . 'BaseController.class.php';
require FRAMEWORK . 'ModelFactory.class.php';

require  MODEL_PATH . $c . 'Model.class.php';
require  CTRL_PATH . $c .'Controller.class.php';
//*/
$controller_name = $c . "Controller";   //构建控制器的类名
$ctrl = new  $controller_name ();   //可变类

$a = !empty($_GET['a']) ? $_GET['a'] : "index";
$action = $a . "Action";
$ctrl->$action();  //可变方法

?>