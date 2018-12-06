<?php
class inquiryModel extends BaseModel{
	function GetInquiry(){		// 所有用户
		if( !empty($_GET['page']) ){
			 $page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 15;	// 每页显示的条数
 		$ShowPage = 3;	// 显示多少个页数的数字
 		
		$sql  = "select * from type_second as t inner join inquiry_book as s on t.second_id = s.inquiry_secondtype ";
		$sql .= "inner join user as u on s.user_id = u.user_id order by inquiry_time desc ";
		$sql .= "limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);  //返回一个数据值，表示找到的行数
		return $data;
	}
	function GetInquiryPage(){		//所有用户 的页数
		$sql = "select count(*) from inquiry_book";
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
 		
 		$sql  = "select * from type_second as t inner join inquiry_book as s on t.second_id = s.inquiry_secondtype ";
		$sql .= "inner join user as u on s.user_id = u.user_id  where inquiry_name like '%{$keyword}%' order by inquiry_time desc ";
		$sql .= "limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);  //返回一个数据值，表示找到的行数
		return $data;
	}
	function GetSearchPage($keyword){		//所有用户 的页数
		$sql = "select count(*) from inquiry_book where inquiry_name like '%{$keyword}%' ";
		$result = $this->_dao->GetOneData($sql);
		return $result;
	}
	
	function GetType(){
		$sql = "select * from type_second";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
	
	function GetUser(){
		$sql = "select * from user";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
	
	function AddInquiry($inquiry_isbn, $inquiry_name, $author, $publishing, $beprice, $afprice, $num, $page, $degrees, $type, $content, $attach, $id){
		$sql  = "insert into inquiry_book(inquiry_isbn, inquiry_name, inquiry_author, inquiry_publishing, inquiry_minprice, inquiry_maxprice, ";
		$sql .= "inquiry_num, inquiry_page, inquiry_degrees, inquiry_secondtype, inquiry_content, inquiry_attach, inquiry_time, user_id) ";
		$sql .= "values ('$inquiry_isbn', '$inquiry_name', '$author', '$publishing', '$beprice', '$afprice', $num, '$page', '$degrees', '$type', '$content', '$attach', now(), $id)";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	function addImg($isbn, $name, $author, $publishing, $img_name, $id){	// 处理图片
		$sql  = "update inquiry_book set inquiry_img = '$img_name' ";
		$sql .="where inquiry_isbn = '$isbn' and inquiry_name = '$name' and inquiry_author = '$author' and inquiry_publishing = '$publishing' and user_id = $id";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function DeleteInquiry($id){
		$sql = "delete from scomment where sbook_id = $id";
		$data = $this->_dao->exec($sql);
		$sql = "delete from inquiry_book where inquiry_id = $id";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function delChecked($ids){
		$sql = "delete from scomment where sbook_id in ($ids)";
		$data = $this->_dao->exec($sql);
		$sql = "delete from inquiry_book where inquiry_id in ($ids)";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function Edit($id){
		$sql = "select * from user as u inner join inquiry_book as s on u.user_id = s.user_id ";
		$sql .= "inner join type_second as t on s.inquiry_secondtype = t.second_id where s.inquiry_id = $id";
		$data = $this->_dao->GetOneRow($sql);
		return $data;
	}
	
	function EditInquiry($id, $isbn, $name, $author, $publishing, $beprice, $afprice, $num, $page, $degrees, $type, $content, $user_id){
		$sql  = "update inquiry_book set inquiry_isbn = '$isbn', inquiry_name = '$name', inquiry_author = '$author', inquiry_publishing = '$publishing', ";
		$sql .= "inquiry_minprice = '$beprice', inquiry_maxprice = '$afprice', inquiry_num = '$num', inquiry_page = '$page', ";
		$sql .= "inquiry_degrees = '$degrees', inquiry_secondtype = $type, inquiry_content = '$content', user_id = $user_id where inquiry_id = $id";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function EditImg($id, $img_name){
		$sql = "update inquiry_book set inquiry_img = '$img_name' where inquiry_id = $id";
		$data = $this->_dao->exec($sql);
		return $data;
	}
}
?>