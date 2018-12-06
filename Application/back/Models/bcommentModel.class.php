<?php
class bcommentModel extends BaseModel{
	function GetBComment(){		// 所有用户
		if( !empty($_GET['page']) ){
			 $page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 15;	// 每页显示的条数
 		$ShowPage = 3;	// 显示多少个页数的数字
 		
		$sql  = "select * from user as u inner join bcomment as b on u.user_id = b.user_id ";
		$sql .= "inner join sale_book as s on b.bbook_id = s.sale_id order by bcomment_time desc ";
		$sql .= "limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);  //返回一个数据值，表示找到的行数
		return $data;
	}
	function GetBCommentPage(){		//所有用户 的页数
		$sql = "select count(*) from bcomment";
		$result = $this->_dao->GetOneData($sql);
		return $result;
	}
	
	function GetSearch($keyword){	// 书名 搜索
		if( !empty($_GET['page']) ){
			 $page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 15;	// 每页显示的条数
 		$ShowPage = 3;	// 显示多少个页数的数字
 		
 		$sql  = "select * from user as u inner join bcomment as b on u.user_id = b.user_id ";
		$sql .= "inner join sale_book as s on b.bbook_id = s.sale_id where bcomment_content like '%{$keyword}%' order by bcomment_time desc ";
		$sql .= "limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);  //返回一个数据值，表示找到的行数
		return $data;
	}
	function GetSearchPage($keyword){		//所有用户 的页数
		$sql = "select count(*) from bcomment where bcomment_content like '%{$keyword}%' ";
		$result = $this->_dao->GetOneData($sql);
		return $result;
	}
	
	function GetBook(){
		$sql = "select * from sale_book where sale_state = 0";
		$data = $this->_dao->GetRows($sql); 
		return $data;
	}
	function GetUser(){
		$sql = "select * from user";
		$data = $this->_dao->GetRows($sql); 
		return $data;
	}
	
	function addBComment($name, $user, $content){
		$sql  = "insert into bcomment(user_id, bcomment_content, bcomment_time, bbook_id) ";
		$sql .= "values($user, '$content', now(), $name) ";
		$data = $this->_dao->exec($sql); 
		return $data;
	}
	
	function Delete($id){
		$sql = "delete from bcomment where bcomment_id = $id";
		$data = $this->_dao->exec($sql); 
		return $data;
	}
	
	function delChecked($ids){
		$sql = "delete from bcomment where bcomment_id in ($ids)";
		$data = $this->_dao->exec($sql); 
		return $data;
	}
	
	function Edit($id){
		$sql  = "select * from user as u inner join bcomment as b on u.user_id = b.user_id ";
		$sql .= "inner join sale_book as s on b.bbook_id = s.sale_id where bcomment_id = $id";
		$data = $this->_dao->GetOneRow($sql); 
		return $data;
	}
	
	function EditBComment( $name, $user, $content, $id ){
		$sql  = "update bcomment set bbook_id = $name, user_id = $user, bcomment_content = '$content' where bcomment_id = $id ";
		$data = $this->_dao->exec($sql); 
		return $data;
	}
}
?>