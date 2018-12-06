<?php
class userModel extends BaseModel{
	function GetUser(){		// 所有用户
		if( !empty($_GET['page']) ){
			 $page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 15;	// 每页显示的条数
 		$ShowPage = 3;	// 显示多少个页数的数字
 		
		$sql  = "select * from user inner join class on user.class_id = class.class_id order by user_id desc ";
		$sql .= "limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);  //返回一个数据值，表示找到的行数
		return $data;
	}
	function GetUserPage(){		//所有用户 的页数
		$sql = "select count(*) from user";
		$result = $this->_dao->GetOneData($sql);
		return $result;
	}
	
	
	function GetSearch($keyword){	// 用户名 搜索
		if( !empty($_GET['page']) ){
			 $page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 15;	// 每页显示的条数
 		$ShowPage = 3;	// 显示多少个页数的数字
 		
		$sql  = "select * from user inner join class on user.class_id = class.class_id where user_name like '%{$keyword}%' order by user_id desc ";
		$sql .= "limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);  //返回一个数据值，表示找到的行数
		return $data;
	}
	function GetSearchPage($keyword){		//所有用户 的页数
		$sql = "select count(*) from user where user_name like '%{$keyword}%' ";
		$result = $this->_dao->GetOneData($sql);
		return $result;
	}
	
	function GetClass(){	// 获取所有专业
		$sql = "select * from class";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
	
	function AddUser($user, $pwd, $sex, $realname, $grade, $class, $addr, $tel, $content){
		$sql = "select count(*) from user where user_name = '$user'";
		$result = $this->_dao->GetOneData($sql);
		if( $result == 0 ){
			$sql  = "insert into user(user_name, user_pwd, user_sex, user_realname, user_tel, user_addr, grade, class_id, user_content) ";
			$sql .= "values('$user', md5('$pwd'), '$sex', '$realname', '$tel', '$addr', '$grade', '$class', '$content')";
			$data = $this->_dao->exec($sql);
			return $data;
		}
		else{
			return false;
		}
	}
	
	function addImg($user, $pwd, $img_name){
		$sql = "update user set user_img = '$img_name' where user_name = '$user' and user_pwd = md5('$pwd')";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function GetName($id){
		$sql = "select * from user where user_id = $id";
		$data = $this->_dao->GetOneRow($sql);
		return $data;
	}
	
	function UpdatePwd($pwd, $id){
		$sql = "update user set user_pwd = md5('$pwd') where user_id = $id";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function Delete($id){
		$sql = "delete from shopcar where user_id = $id";
		$data = $this->_dao->exec($sql);
		$sql = "delete from shoporder where user_id = $id";
		$data = $this->_dao->exec($sql);
		$sql = "delete from scomment where user_id = $id";
		$data = $this->_dao->exec($sql);
		$sql = "delete from inquiry_book where user_id = $id";
		$data = $this->_dao->exec($sql);
		$sql = "delete from bcomment where user_id = $id";
		$data = $this->_dao->exec($sql);
		$sql = "delete from sale_book where user_id = $id";
		$data = $this->_dao->exec($sql);
		$sql = "delete from user where user_id = $id";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function delChecked($ids){
		$sql = "delete from shopcar where user_id in ($ids)";
		$data = $this->_dao->exec($sql);
		$sql = "delete from shoporder where user_id in ($ids)";
		$data = $this->_dao->exec($sql);
		$sql = "delete from bcomment where user_id in ($ids)";
		$data = $this->_dao->exec($sql);
		$sql = "delete from sale_book where user_id in ($ids)";
		$data = $this->_dao->exec($sql);
		$sql = "delete from scomment where user_id in ($ids)";
		$data = $this->_dao->exec($sql);
		$sql = "delete from inquiry_book where user_id in ($ids)";
		$data = $this->_dao->exec($sql);
		$sql = "delete from user where user_id in ($ids)";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function Edit($id){
		$sql = "select * from user as u inner join class as c on u.class_id = c.class_id where user_id = $id";
		$data = $this->_dao->GetOneRow($sql);
		return $data;
	}
	
	function EditUser($name, $sex, $realname, $grade, $class, $addr, $tel, $content, $id){
		$sql = "select user_name from user where user_id not in ($id)";
		$data = $this->_dao->GetRows($sql);
		foreach($data as $key => $value){
			if($value[0] == $name){
				return false;
			}
		}
		
		$sql  = "update user set user_name = '$name', user_sex = '$sex', user_realname = '$realname', user_tel = '$tel', ";
		$sql .= " user_addr = '$addr', grade = '$grade', class_id = '$class', user_content = '$content' where user_id = $id";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function updateImg($id, $img_name){
		$sql = "update user set user_img = '$img_name' where user_id = $id";
		$data = $this->_dao->exec($sql);
		return $data;
	}
}
?>