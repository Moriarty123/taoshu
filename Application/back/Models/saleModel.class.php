<?php
class saleModel extends BaseModel{
	function GetSale(){		// 所有用户
		if( !empty($_GET['page']) ){
			 $page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 15;	// 每页显示的条数
 		$ShowPage = 3;	// 显示多少个页数的数字
 		
		$sql  = "select * from type_second as t inner join sale_book as s on t.second_id = s.sale_secondtype ";
		$sql .= "inner join user as u on s.user_id = u.user_id order by sale_time desc ";
		$sql .= "limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);  //返回一个数据值，表示找到的行数
		return $data;
	}
	function GetSalePage(){		//所有用户 的页数
		$sql = "select count(*) from sale_book";
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
 		
 		$sql  = "select * from type_second as t inner join sale_book as s on t.second_id = s.sale_secondtype ";
		$sql .= "inner join user as u on s.user_id = u.user_id  where sale_name like '%{$keyword}%' order by sale_time desc ";
		$sql .= "limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);  //返回一个数据值，表示找到的行数
		return $data;
	}
	function GetSearchPage($keyword){		//所有用户 的页数
		$sql = "select count(*) from sale_book where sale_name like '%{$keyword}%' ";
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
	
	function AddSale($sale_isbn, $sale_name, $author, $publishing, $beprice, $afprice, $num, $page, $degrees, $type, $content, $id){
		$sql  = "insert into sale_book(sale_isbn, sale_name, sale_author, sale_publishing, sale_beprice, sale_afprice, ";
		$sql .= "sale_num, sale_page, sale_degrees, sale_secondtype, sale_content, sale_time, user_id) ";
		$sql .= "values ('$sale_isbn', '$sale_name', '$author', '$publishing', '$beprice', '$afprice', $num, '$page', '$degrees', '$type', '$content', now(), $id)";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	function addImg($isbn, $name, $author, $publishing, $img_name, $id){	// 处理图片
		$sql  = "update sale_book set sale_img = '$img_name' ";
		$sql .="where sale_isbn = '$isbn' and sale_name = '$name' and sale_author = '$author' and sale_publishing = '$publishing' and user_id = $id";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function DeleteSale($id){
		$sql = "delete from shopcar where book_id = $id";
		$data = $this->_dao->exec($sql);
		$sql = "delete from shoporder where book_id = $id";
		$data = $this->_dao->exec($sql);
		$sql = "delete from bcomment where bbook_id = $id";
		$data = $this->_dao->exec($sql);
		$sql = "delete from sale_book where sale_id = $id";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function delChecked($ids){
		$sql = "delete from bcomment where bbook_id in ($ids)";
		$data = $this->_dao->exec($sql); 
		$sql = "delete from shopcar where book_id in ($ids)";
		$data = $this->_dao->exec($sql); 
		$sql = "delete from shoporder where book_id in ($ids)";
		$data = $this->_dao->exec($sql); 
		$sql = "delete from sale_book where sale_id in ($ids)";
		$data = $this->_dao->exec($sql); 
		return $data;
	}
	
	function Edit($id){
		$sql = "select * from user as u inner join sale_book as s on u.user_id = s.user_id ";
		$sql .= "inner join type_second as t on s.sale_secondtype = t.second_id where s.sale_id = $id";
		$data = $this->_dao->GetOneRow($sql);
		return $data;
	}
	
	function EditSale($id, $sale_isbn, $sale_name, $author, $publishing, $beprice, $afprice, $num, $page, $degrees, $type, $content, $user_id){
		if($num > 0){
			$state = 0;
		}
		else{
			$state = 1;
		}
		$sql  = "update sale_book set sale_isbn = '$sale_isbn', sale_name = '$sale_name', sale_author = '$author', sale_publishing = '$publishing', ";
		$sql .= "sale_beprice = '$beprice', sale_afprice = '$afprice', sale_num = '$num', sale_page = '$page', sale_state = $state, ";
		$sql .= "sale_degrees = '$degrees', sale_secondtype = $type, sale_content = '$content', user_id = $user_id where sale_id = $id";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function EditImg($id, $img_name){
		$sql = "update sale_book set sale_img = '$img_name' where sale_id = $id";
		$data = $this->_dao->exec($sql);
		return $data;
	}
}
?>