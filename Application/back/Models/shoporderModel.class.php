<?php
class shoporderModel extends BaseModel{
	function GetOrder(){		// 所有用户
		if( !empty($_GET['page']) ){
			 $page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 15;	// 每页显示的条数
 		$ShowPage = 3;	// 显示多少个页数的数字
 		
		$sql  = "select * from user as u inner join shoporder as sh on u.user_id = sh.user_id ";
		$sql .= "inner join sale_book as s on sh.book_id = s.sale_id order by create_time desc ";
		$sql .= "limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);  //返回一个数据值，表示找到的行数
		return $data;
	}
	function GetOrderPage(){		//所有用户 的页数
		$sql = "select count(*) from shoporder";
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
 		
		$sql  = "select * from user as u inner join shoporder as sh on u.user_id = sh.user_id ";
		$sql .= "inner join sale_book as s on sh.book_id = s.sale_id where order_id like '%{$keyword}%' order by create_time desc ";
		$sql .= "limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);  //返回一个数据值，表示找到的行数
		return $data;
	}
	function GetSearchPage($keyword){		//所有用户 的页数
		$sql = "select count(*) from shoporder where order_id like '%{$keyword}%' ";
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
	
	function Delete($id){
		$sql = "delete from shoporder where order_id = $id";
		$data = $this->_dao->exec($sql); 
		return $data;
	}
	
	function delChecked($ids){
		$sql = "delete from shoporder where order_id in ($ids)";
		$data = $this->_dao->exec($sql); 
		return $data;
	}
	
	function Owner($name){
		$sql = "select user_id from sale_book where sale_id = $name";
		$data = $this->_dao->GetOneData($sql); 
		return $data;
	}
	
	function addOrder($order_id, $user, $name, $num, $price){
		$sql = "insert into shoporder values ('$order_id', '$user', '$name', now(), '$price', 1, '$num',0 ,0 )";
		$data1 = $this->_dao->exec($sql);
		
		$sql = "select * from sale_book where sale_id = $name";
		$data = $this->_dao->GetOneRow($sql);
		if( $data['sale_num'] == $num ){	// 如果购买数量和库存量一致，就把出售状态改为1，数量为0
			$sql = "update sale_book set sale_state = 1, sale_num = 0 where sale_id = $name";
			$data2 = $this->_dao->exec($sql);
			return $data2;
		}
		else{	// 如果购买数量 小于 库存量，出售书籍数量 减 购买数量
			$sql = "update sale_book set sale_num = {$data['sale_num']}-$num where sale_id = $name";
			$data3 = $this->_dao->exec($sql);
			
			$sql = "select sale_num from sale_book where sale_id = $name";
			$data4 = $this->_dao->GetOneData($sql);
			
			$sql = "select book_num from shopcar where book_id = $name";
			$data5 = $this->_dao->GetRows($sql);
			
			foreach($data5 as $key => $value){
				if($data4 < $value[0]){
					$sql = "update shopcar set book_num = $data4 where book_id = $name";
					$data = $this->_dao->exec($sql);
				}
			}
			return $data;
		}
	}
	
	function Edit($id){
		$sql = "select * from sale_book as a inner join shoporder as b on a.sale_id = b.book_id ";
		$sql .= "inner join user as u on b.user_id = u.user_id where order_id = $id";
		$data = $this->_dao->GetOneRow($sql);
		return $data;
	}
	function GetAllBook(){
		$sql = "select * from sale_book";
		$data = $this->_dao->GetRows($sql); 
		return $data;
	}
	
	function editOrder($id, $user, $book, $num, $price, $preBook){
		$sql = "select * from shoporder where order_id = $id";
		$data = $this->_dao->GetOneRow($sql);
		
		// 把原订单中的 购买数目 加回出售表中
		$sql = "update sale_book set sale_num = sale_num + {$data['order_sum']}, sale_state = 0 where sale_id = $preBook";
		$data1 = $this->_dao->exec($sql);
		
		// 更新订单表
		$sql = "update shoporder set user_id = $user, book_id = $book, order_sum = $num, order_price = $price where order_id = $id";
		$data1 = $this->_dao->exec($sql);
		
		// 更新出售表
		$sql = "update sale_book set sale_num = sale_num - $num where sale_id = $book";
		$data2 = $this->_dao->exec($sql);
		
		// 更新出售表 的 出售书籍状态
		$sql = "select * from sale_book where sale_id = $book";
		$data3 = $this->_dao->GetOneRow($sql);
		if($data3['sale_num'] == 0){
			$sql = "update sale_book set sale_state = 1 where sale_id = $book";
			$result = $this->_dao->exec($sql);
		}
		
		// 更新购物车数据
		$sql = "select sale_num from sale_book where sale_id = $book";
		$data2 = $this->_dao->GetOneData($sql);
			
		$sql = "select book_num from shopcar where book_id = $book";
		$data5 = $this->_dao->GetRows($sql);
		
		foreach($data5 as $key => $value){
			if( $data2 != 0){
				if($data2 < $value[0]){
					$sql = "update shopcar set book_num = $data2 where book_id = $book";
					$data = $this->_dao->exec($sql);
				}
			}
		}
		return $data1;
	}
	
	function Succeed($id){
		$sql = "update shoporder set order_state = 1 where order_id = '$id'";
		$data = $this->_dao->exec($sql);
		return $data;
	}
}
?>