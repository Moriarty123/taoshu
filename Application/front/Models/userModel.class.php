<?php
class userModel extends BaseModel{
	function CheckLogin($user, $pass){
		$sql = "select count(*) from user where user_name='$user' and user_pwd=md5('$pass');";
		$result = $this->_dao->GetOneData($sql);  //返回一个数据值，表示找到的行数
		
		if ($result == 1) { //表示找到一条数据，就是正确的身份验证
			$sql = "update user set login_times = login_times+1 where user_name='$user' and user_pwd=md5('$pass');";
			$data = $this->_dao->exec($sql);
			$sql = "select * from user where user_name='$user' and user_pwd=md5('$pass'); ";
			$data = $this->_dao->GetOneRow($sql);
			return $data;
		}
		//其他都是错的，通常情况 $result == 0
		return false;
		
	}
	
	function addUser($user, $pass){
		$sql = "select count(*) from user where user_name = '$user'";
		$result = $this->_dao->GetOneData($sql);
		if( $result == 0 ){
			$sql = "insert into user(user_name, user_pwd) values ('$user', md5('$pass'));";
			$data = $this->_dao->exec($sql);
			return $data;
		}
		return false;
	}
	
	function showUser($id){
		$sql  = "select * from dept inner join class on dept.dept_id = class.dept_id ";
		$sql .= "inner join user on class.class_id = user.class_id where user_id = $id";
		$data = $this->_dao->GetOneRow($sql);
		return $data;
	}
	
	function getClass($id){
		$sql = "select class_id from user where user_id = $id";
		$data = $this->_dao->GetOneData($sql);
		$sql  = "select * from class";
		$data = $this->_dao->GetRows($sql); 
		return $data;
	}
	
	function updateUser($id, $nickname, $realname, $sex, $grade, $class, $tel, $addr, $content){
		$sql  = "update user set nickname = '$nickname', user_realname = '$realname', user_sex = '$sex', ";
		$sql .= "grade = '$grade', class_id = '$class', user_tel = '$tel', user_addr = '$addr', user_content ='$content' ";
		$sql .= "where user_id = $id";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function updateImg($id, $img_name){
		$sql = "update user set user_img = '$img_name' where user_id = $id";
		$data = $this->_dao->exec($sql);
		return $data;
	}

	function updatePwd($id, $prePwd, $newPwd){
		$sql = "select user_pwd from user where user_id = $id";
		$data = $this->_dao->GetOneData($sql);
		if( $data == (md5($prePwd)) ){
			$sql = "update user set user_pwd = md5('$newPwd') where user_id = $id";
			$data = $this->_dao->exec($sql);
			return $data;
		}
		else{
			return false;
		}
	}
	
	function GetSaleUser($user_id){
		$sql = "select * from user inner join class on user.class_id = class.class_id where user_id = $user_id";
		$data = $this->_dao->GetOneRow($sql);
		return $data;
	}
	
	function GetSaleUserBook($user_id){
		$sql  = "select * from sale_book where sale_state = 0 and user_id = $user_id order by sale_time desc";
		$data = $this->_dao->GetRows($sql); 
		return $data;
	}
	
	function GetInquiryUserBook($user_id){
		$sql  = "select * from inquiry_book where inquiry_state = 0 and user_id = $user_id order by inquiry_time desc";
		$data = $this->_dao->GetRows($sql); 
		return $data;
	}
}
?>