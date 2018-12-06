<?php
class scommentModel extends BaseModel{
	function GetSComment(){		// 所有用户
		if( !empty($_GET['page']) ){
			 $page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 15;	// 每页显示的条数
 		$ShowPage = 3;	// 显示多少个页数的数字
 		
		$sql  = "select * from user as u inner join scomment as b on u.user_id = b.user_id ";
		$sql .= "inner join inquiry_book as s on b.sbook_id = s.inquiry_id order by scomment_time desc ";
		$sql .= "limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);  //返回一个数据值，表示找到的行数
		return $data;
	}
	function GetSCommentPage(){		//所有用户 的页数
		$sql = "select count(*) from scomment";
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
 		
 		$sql  = "select * from user as u inner join scomment as b on u.user_id = b.user_id ";
		$sql .= "inner join inquiry_book as s on b.sbook_id = s.inquiry_id where scomment_content like '%{$keyword}%' order by scomment_time desc ";
		$sql .= "limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);  //返回一个数据值，表示找到的行数
		return $data;
	}
	function GetSearchPage($keyword){		//所有用户 的页数
		$sql = "select count(*) from scomment where scomment_content like '%{$keyword}%' ";
		$result = $this->_dao->GetOneData($sql);
		return $result;
	}
	
	function GetBook(){
		$sql = "select * from inquiry_book where inquiry_state = 0";
		$data = $this->_dao->GetRows($sql); 
		return $data;
	}
	function GetUser(){
		$sql = "select * from user";
		$data = $this->_dao->GetRows($sql); 
		return $data;
	}
	
	function addSComment($name, $user, $content){
		$sql  = "insert into scomment(user_id, scomment_content, scomment_time, sbook_id) ";
		$sql .= "values($user, '$content', now(), $name) ";
		$data = $this->_dao->exec($sql); 
		return $data;
	}
	
	function Delete($id){
		$sql = "delete from scomment where scomment_id = $id";
		$data = $this->_dao->exec($sql); 
		return $data;
	}
	
	function delChecked($ids){
		$sql = "delete from scomment where scomment_id in ($ids)";
		$data = $this->_dao->exec($sql); 
		return $data;
	}
	
	function Edit($id){
		$sql  = "select * from user as u inner join scomment as b on u.user_id = b.user_id ";
		$sql .= "inner join inquiry_book as s on b.sbook_id = s.inquiry_id where scomment_id = $id";
		$data = $this->_dao->GetOneRow($sql); 
		return $data;
	}
	
	function EditSComment( $name, $user, $content, $id ){
		$sql  = "update scomment set sbook_id = $name, user_id = $user, scomment_content = '$content' where scomment_id = $id ";
		$data = $this->_dao->exec($sql); 
		return $data;
	}
}
?>