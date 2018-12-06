<?php
class inquiryModel extends BaseModel{
	function GetAllInquiry(){
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
		$sql  = "select distinct(i.inquiry_name), i.*, u.user_name, u.user_realname, u.nickname, u.grade, u.class_id, d.*, c.* ";
		$sql .= "from       dept        as d ";
		$sql .= "inner join class       as c on d.dept_id  = c.dept_id ";
		$sql .= "inner join user        as u on c.class_id = u.class_id ";
		$sql .= "inner join inquiry_book   as i on u.user_id  = i.user_id ";
		$sql .= "inner join type_second as t where inquiry_state = 0 ";
		$sql .= "order by inquiry_time desc limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
	function GetAllInquiryPage(){		//分页显示所有求购书籍
 		$sql = "select count(*) from inquiry_book where inquiry_state = 0";
 		$data = $this->_dao->GetOneData($sql);
 		return $data;
	}
	
	function GetInquiryById($id){	// 根据id显示该求购书籍的信息
		$sql  = "select s.*,u.user_realname, u.nickname, u.user_name from user as u ";
		$sql .= "inner join inquiry_book as s on u.user_id = s.user_id ";
		$sql .= "where inquiry_id = $id;";
		$data = $this->_dao->GetOneRow($sql);
		return $data;
	}
	
	function GetInquirySecTypeById($id){	// 根据id获取求购书籍的二级类型
		$sql = "select inquiry_secondtype from inquiry_book where inquiry_id = $id;";
		$data = $this->_dao->GetOneData($sql);
		$sql1 = "select * from type_second where second_id = $data";
		$data1 = $this->_dao->GetOneRow($sql1);
		return $data1;
	}
	
	function GetInquiryTypeById($id){	// 根据id获取求购书籍的一级类型
		$sql = "select inquiry_secondtype from inquiry_book where inquiry_id = $id;";
		$data = $this->_dao->GetOneData($sql);
		$sql1 = "select * from type_second where second_id = $data";
		$data1 = $this->_dao->GetOneRow($sql1);
		$sql2 = "select * from book_type where type_id = {$data1['type_id']}; ";
		$data2 = $this->_dao->GetOneRow($sql2);
		return $data2;
	}
	
	function AddInquiry($isbn, $inquiry_name, $author, $publishing, $minprice, $maxprice, $num, $page, $degrees, $type, $content, $attach, $id){
		$sql  = "insert into inquiry_book(inquiry_isbn, inquiry_name, inquiry_author, inquiry_publishing, inquiry_minprice, inquiry_maxprice, ";
		$sql .= "inquiry_num, inquiry_page, inquiry_degrees, inquiry_secondtype, inquiry_content, inquiry_time, user_id, inquiry_attach) ";
		$sql .= "values ('$isbn', '$inquiry_name', '$author', '$publishing', '$minprice', '$maxprice', $num, '$page', '$degrees', '$type', '$content', now(), $id, '$attach')";
		$data = $this->_dao->exec($sql);
		return $data;			
	}
	
	function addImg($isbn, $name, $author, $publishing, $img_name, $id){	// 处理图片
		$sql  = "update inquiry_book set inquiry_img = '$img_name' ";
		$sql .= "where inquiry_isbn = '$isbn' and inquiry_name = '$name' and inquiry_author = '$author' and inquiry_publishing = '$publishing' and user_id = $id";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function GetSearchByName($keyword){		// 根据输入的内容搜索出售书籍
		$sql = "select count(*) from inquiry_book where inquiry_state = 0 and inquiry_name like '%{$keyword}%'";
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
	 		
			$sql  = "select distinct(s.inquiry_name), s.*, u.user_name, u.user_realname, u.grade, u.class_id, d.*, c.* ";
			$sql .= "from       dept      as d ";
			$sql .= "inner join class     as c on d.dept_id  = c.dept_id ";
			$sql .= "inner join user      as u on c.class_id = u.class_id ";
			$sql .= "inner join inquiry_book as s on u.user_id  = s.user_id where s.inquiry_state = 0 and s.inquiry_name like '%{$keyword}%' order by inquiry_time desc";
			$sql .= " limit ".($page - 1) * $PageSize .", $PageSize";
			$data = $this->_dao->GetRows($sql); 
			return $data;
		}
	}
	
	function GetSearchByNamePage($keyword){		// 分页显示搜索
		$sql = "select count(*) from inquiry_book where inquiry_state = 0 and inquiry_name like '%{$keyword}%'";
		$result = $this->_dao->GetOneData($sql);
		return $result;
	}
	
	function GetMyInquiry($id){	// 个人中心 - 我的出售
		$sql = "select * from inquiry_book where user_id = $id";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
}
?>