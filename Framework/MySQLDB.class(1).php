<meta charset="utf-8">
<?php
/*
数据库工具类
*/
class MySQLDB{
	public $link = null;
	private $host;
	private $port;
	private $user;
	private $pwd;
	private $charset;
	private $dbname;

	//实现单例第 2 步
	private static $instance = null;  // 用于存储唯一的单例对象
	//实现单例第 3 步
	static function GetInstance( $config ){
		//if ( !isset(self::$instance) ) {  //还没有该对象
		if ( !(self::$instance instanceof self) ) {  //代替上一行的判断，常见
			self::$instance = new self($config); //创建一个对象并保存起来
		}
		return self::$instance;
	}
	//实现单例第 4 步：私有化这个克隆的魔术方法
	private function __clone(){}

	//实现单例第 1 步
	private function __construct($cfg){
		//先将这些基本的连接信息，保存起来
		$this->host = !empty($cfg['host']) ? $cfg['host'] : "localhost"; //考虑空值情况，使用默认值代替
		$this->port = !empty($cfg['port']) ? $cfg['port'] : "3306"; //考虑空值情况，使用默认值代替
		$this->user = !empty($cfg['user']) ? $cfg['user'] : "root"; //考虑空值情况，使用默认值代替
		$this->pwd = !empty($cfg['pwd']) ? $cfg['pwd'] : "root"; //考虑空值情况，使用默认值代替
		$this->charset = !empty($cfg['charset']) ? $cfg['charset'] : "utf8"; //考虑空值情况，使用默认值代替
		$this->dbname = !empty($cfg['dbname']) ? $cfg['dbname'] : "aa"; //考虑空值情况，使用默认值代替

		//连接数据库
		$this->link = @mysql_connect("{$cfg['host']}:{$cfg['port']}", "{$cfg['user']}", "{$cfg['pwd']}") or die("连接失败");

		//设定编码
		//mysql_query("set  names  {$cfg['charset']}");
		$this->setCharSet( $this->charset ); //这一行代替上一行

		//选定要使用的数据库名
		//mysql_query("use  {$cfg['dbname']}");
		$this->selectDB( $this->dbname ); //这一行代替上一行

	}
	//可以设定要使用的连接编码
	function setCharSet($charset){
		mysql_query("set  names  $charset");
	}
	//可以设定要使用的数据库
	function selectDB($dbname){
		mysql_query("use  $dbname");
	}
	//关闭数据库
	function closeDB(){
		mysql_close($this->link);
	}

	//执行一条增删改语句，它返回真假结果
	function exec($sql){
		// $result = $this->query($sql);
		// return true;
		return $this->query($sql);  //可以用这一行代替上面的两行
	}

	//执行一条返回一条数据的语句，它返回一维数组
	function GetOneRow($sql){
		$result = $this->query($sql);

		//此时 $result 是一个结果集
		$rec = mysql_fetch_array($result);//取出一行数据（其实也只有一行）
		mysql_free_result($result);  //提前释放资源（销毁结果集），否则需要等到页面结束才自动销毁
		return $rec;
	}

	//执行一条返回多条数据的语句，它返回二维数组
	function GetRows($sql){
		$result = $this->query($sql);

		//此时 $result 是一个多行数据
		$arr = array();  //空数组，用于存放要返回的结果数组（二维）
		while( $rec = mysql_fetch_array($result) ){
			// $rec 是一个一维数组，把 $rec数组 存到 $arr数组中，$arr 编程二维数组
			$arr[] = $rec;
		}
		mysql_free_result($result);  //提前释放资源（销毁结果集），否则需要等到页面结束才自动销毁
		return $arr;
	}
	
//	//执行返回多个结果集数据的语句，如存储过程数据
//	function GetResultSets($sql){
//		$mysqli = new MySQLi("localhost","root","root","tao_shu");
//		if($mysqli->connect_error){
//		 	die($mysqli->connect_error);
//		}
//		$mysqli->query("set names 'utf8'");
////		$arr = array();
//		if(mysqli_multi_query($mysqli, $sql)){
//			do{
//				//存储第一个结果集
//				if( $result = mysqli_store_result($mysqli) ){
//					while($row = mysqli_fetch_row($result)){
//					}
//					mysqli_free_result($result);
//				}
//			} while( mysqli_next_result( $mysqli ) && mysqli_more_results( $mysqli ) );
//			echo "MySQLDB的值为：";
//			var_dump($row);
//			return $row;
//		}
//	}

	//执行一条返回一个数据的语句，它返回一个数据值
	function GetOneData($sql){
		$result = $this->query($sql);

		//此时 $result 是一个数据值
		$rec = mysql_fetch_row($result);//这里最好使用 mysql_fetch_row 这个函数
										//这里得到 $rec 仍然是一个数组，但其类似这样
										// array( 0 => 5);或者 array( 0 => 'user1');
		$data = $rec[0];
		mysql_free_result($result);  //提前释放资源（销毁结果集），否则需要等到页面结束才自动销毁
		return $data;
	}

	// 此方法用于执行任何sql语句，并进行错误处理，或返回执行结果
	private function query($sql){
		$result = mysql_query($sql , $this->link);
		if ($result === false) {
			//对任何语句执行失败，则需要处理这种失败情况
			echo "<p>sql语句执行失败，参考如下信息：";
			echo "<br>语句代号：".mysql_errno();
			echo "<br>语句信息：".mysql_error();
			echo "<br>语句：".$sql;
			die();
		}
		return $result;  //返回的是 “执行的结果” ，又可能是 真假 ，有可能是 结果集
	}
}
?>