<?php
class saleBookModel extends BaseModel{
	function GetSaleBookById($id){	// 根据id获取一本出售书籍
		$sql  = "select s.*,u.user_realname, u.nickname, u.user_name from user as u ";
		$sql .= "inner join sale_book as s on u.user_id = s.user_id ";
		$sql .= "where sale_id = $id;";
		$data = $this->_dao->GetOneRow($sql);
		return $data;
	}
	function GetSaleSecTypeById($id){	// 根据id获取出售书籍的二级类型
		$sql = "select sale_secondtype from sale_book where sale_id = $id;";
		$data = $this->_dao->GetOneData($sql);
		$sql1 = "select * from type_second where second_id = $data";
		$data1 = $this->_dao->GetOneRow($sql1);
		return $data1;
	}
	function GetSaleBookTypeById($id){	// 根据id获取出售书籍的一级类型
		$sql = "select sale_secondtype from sale_book where sale_id = $id;";
		$data = $this->_dao->GetOneData($sql);
		$sql1 = "select * from type_second where second_id = $data";
		$data1 = $this->_dao->GetOneRow($sql1);
		$sql2 = "select * from book_type where type_id = {$data1['type_id']}; ";
		$data2 = $this->_dao->GetOneRow($sql2);
		return $data2;
	}
	
	function GetSearchByName($keyword){		// 根据输入的内容搜索出售书籍
		$sql = "select count(*) from sale_book where sale_state = 0 and sale_name like '%{$keyword}%'";
		$result = $this->_dao->GetOneData($sql);
		if($result == 0){
			return false;
		}
		else{
			/** 1.传入页面 **/
			if( !empty($_GET['page']) ){
			 	$page = $_GET['page'];
			}
			else{
				$page = 1;
			}
			$PageSize = 8;	// 每页显示的条数
	 		$ShowPage = 3;	// 显示多少个页数的数字
	 		
			$sql  = "select distinct(s.sale_name), s.*, u.user_name, u.user_realname, u.grade, u.class_id, d.*, c.* ";
			$sql .= "from       dept      as d ";
			$sql .= "inner join class     as c on d.dept_id  = c.dept_id ";
			$sql .= "inner join user      as u on c.class_id = u.class_id ";
			$sql .= "inner join sale_book as s on u.user_id  = s.user_id where s.sale_state = 0 and s.sale_name like '%{$keyword}%' order by sale_time desc";
			$sql .= " limit ".($page - 1) * $PageSize .", $PageSize";
			$data = $this->_dao->GetRows($sql); 
			return $data;
		}
	}
	
	function GetSearchByNamePage($keyword){		// 分页显示搜索
		$sql = "select count(*) from sale_book where sale_state = 0 and sale_name like '%{$keyword}%'";
		$result = $this->_dao->GetOneData($sql);
		return $result;
	}
	
	function GetTypeSale($id){		// 根据second_id获取该二级类别的所有出售书籍
		if( !empty($_GET['page']) ){
		 	$page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 8;	// 每页显示的条数
	 	$ShowPage = 3;	// 显示多少个页数的数字
		$sql  = "select distinct(s.sale_name), s.*, u.user_name, u.user_realname, u.grade, u.class_id, d.*, c.* ";
		$sql .= "from       dept        as d ";
		$sql .= "inner join class       as c on d.dept_id         = c.dept_id ";
		$sql .= "inner join user        as u on c.class_id        = u.class_id ";
		$sql .= "inner join sale_book   as s on u.user_id         = s.user_id ";
		$sql .= "inner join type_second as t on s.sale_secondtype = $id where s.sale_state = 0 order by sale_time desc ";
		$sql .= "limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
	
	function GetTypeSalePage($id){		// 分页显示该二级类别的所有出售书籍
		$sql = "select count(*) from sale_book where sale_secondtype = $id and sale_state = 0 ";
		$result = $this->_dao->GetOneData($sql);
		return $result;
	}
	
	function GetFirstType($id){		// 根据second_id获取其一级类别的类别名称
		$sql = "select type_id from type_second where second_id = $id";
		$data = $this->_dao->GetOneData($sql);
		$sql1 = "select type_name from book_type where type_id = $data;";
		$data1 = $this->_dao->GetOneData($sql1);
		return $data1;
	}
	
	function GetSecType($id){		// 根据second_id获取其二级类别的所有信息，多行(左侧的目录导航)
		$sql = "select type_id from type_second where second_id = $id";
		$data = $this->_dao->GetOneData($sql);
		$sql1 = "select * from type_second where type_id = $data;";
		$data1 = $this->_dao->GetRows($sql1);
		return $data1;
	}
	
	function GetSecNameById($id){	// 根据点击的second_id获取second_name
		$sql = "select second_name from type_second where second_id = $id";
		$data = $this->_dao->GetOneData($sql);
		return $data;
	}
	
	function GetCountById($id){		// 根据点击的second_id获取属于该类别的出售书籍的数目
		$sql = "select second_id from type_second where second_id = $id";
		$data = $this->_dao->GetOneData($sql);
		$sql1 = "select count(*) from sale_book where sale_state = 0 and sale_secondtype = $data;";
		$data1 = $this->_dao->GetOneData($sql1);
		return $data1;
	}
	
	function GetAllSale_book(){		// 获取所有没卖出去的出售书籍
		/** 1.传入页面 **/
		if( !empty($_GET['page']) ){
		 	$page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 8;	// 每页显示的条数
 		$ShowPage = 3;	// 显示多少个页数的数字
 		
		/** 2.取出数据   limit 起始位置 , 显示条数  **/
		$sql  = "select distinct(s.sale_name), s.*, u.user_name, u.user_realname, u.nickname, u.grade, u.class_id, d.*, c.* ";
		$sql .= "from       dept        as d ";
		$sql .= "inner join class       as c on d.dept_id  = c.dept_id ";
		$sql .= "inner join user        as u on c.class_id = u.class_id ";
		$sql .= "inner join sale_book   as s on u.user_id  = s.user_id ";
		$sql .= "inner join type_second as t where sale_state = 0 ";
		$sql .= "order by sale_time desc limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
	
	function GetAllSale_bookPage(){		//分页显示所有出售书籍
 		$sql = "select count(*) from sale_book where sale_state = 0";
 		$data = $this->_dao->GetOneData($sql);
 		return $data;
	}
	
	function GetAllType(){
		$sql = "select * from type_second";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
	
	function AddSale($sale_isbn, $name, $author, $publishing, $beprice, $afprice, $num, $page, $degrees, $type, $content, $id){
		$sql  = "insert into sale_book(sale_isbn, sale_name, sale_author, sale_publishing, sale_beprice, sale_afprice, ";
		$sql .= "sale_num, sale_page, sale_degrees, sale_secondtype, sale_content, sale_time, user_id) ";
		$sql .= "values ('$sale_isbn', '$name', '$author', '$publishing', '$beprice', '$afprice', $num, '$page', '$degrees', '$type', '$content', now(), $id)";
		$data = $this->_dao->exec($sql);
		return $data;	
	}
	function addImg($isbn, $name, $author, $publishing, $img_name, $id){	// 处理图片
		$sql  = "update sale_book set sale_img = '$img_name' ";
		$sql .="where sale_isbn = '$isbn' and sale_name = '$name' and sale_author = '$author' and sale_publishing = '$publishing' and user_id = $id";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function GetMySaleBook($id){	// 个人中心 - 我的出售
		$sql = "select * from sale_book where user_id = $id";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
}
?>