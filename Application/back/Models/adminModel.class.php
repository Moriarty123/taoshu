<?php
class adminModel extends BaseModel{
	function GetAdmin($user, $pass){
		$sql = "select * from admin where name='$user' and pwd=md5('$pass');";
		$result = $this->_dao->GetOneRow($sql);  //返回一个数据值，表示找到的行数
		return $result;
	}
	function CheckLogin($user, $pass){
		$sql = "select count(*) from admin where name='$user' and pwd=md5('$pass');";
		$result = $this->_dao->GetOneData($sql);  //返回一个数据值，表示找到的行数
		if ($result == 1) { //表示找到一条数据，就是正确的身份验证
			//登陆成功后，应该去修改（更改）该条数据
			$sql = "update admin set times = times+1, last_time = now()";
			$sql .= " where name='$user' and pwd = md5('$pass');";
			$result = $this->_dao->exec($sql);
			return true;
		}
		else{ //其他都是错的，通常情况 $result == 0
			return false;
		}
	}
	
	function GetTimes($id){
		$sql = "select times from admin where id = $id";
		$result = $this->_dao->GetOneData($sql);
		return $result;
	}
	
	function UpdatePwd($pre, $pwd, $id){
		$sql = "select pwd from admin where id = $id";
		$data = $this->_dao->GetOneData($sql);
		if( $data == (md5($pre)) ){
			$sql = "update admin set pwd = md5('$pwd') where id = $id";
			$data = $this->_dao->exec($sql);
			return $data;
		}
		else{
			return false;
		}
	}
	
	function AddAdmin($name, $pwd){
		$sql = "select count(*) from admin where name = '$name'";
		$data = $this->_dao->GetOneData($sql);
		if($data == 0){
			$sql = "insert into admin(name, pwd) values('$name', md5('$pwd'))";
			$data = $this->_dao->exec($sql);
			return $data;
		}
		else{
			return false;
		}
	}
}
?>