<?php
class shoporderModel extends BaseModel{
	// 我下的订单
	function showMyOrder( $id ){
//		$sql  = "select * from sale_book as a inner join shoporder as b on a.sale_id = b.book_id ";
//		$sql .= "inner join user as c on b.user_id = c.user_id  where b.user_id = $id and order_buy = 0 order by order_state, create_time desc";
		
		
		$sql  = "select * from user as u inner join sale_book as a on u.user_id = a.user_id ";
		$sql .= "inner join shoporder as s on a.sale_id = s.book_id where s.user_id = $id and order_buy = 0 order by order_state, create_time desc";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
	
	function Owner($book_id, $user_id){
		$sql = "select user_id from sale_book where sale_id = $book_id";
		$data = $this->_dao->GetOneData($sql);
		if($data == $user_id){
			return false;
		}
		else{
			return true;
		}
	}
	
	// 删除我下的订单
	function delShopOrderById($id){
		$sql = "update shoporder set order_buy = 1 where order_id = $id";
		$data = $this->_dao->exec($sql); 
		return $data;
	}
	
	// 获取书籍的售价
	function getBookPrice($book_id){
		$sql = "select sale_afprice from sale_book where sale_id = $book_id";
		$data = $this->_dao->GetOneData($sql);
		return $data;
	}
	
	function buyOrNot($book_id){	// 判断是否已被别人成功购买
		$sql = "select sale_state from sale_book where sale_id = $book_id";
		$data = $this->_dao->GetOneData($sql);
		if( $data == 1 ){
			return false;
		}
		else{
			return true;
		}
	}
	
	function showAddUser($id){	// 购买人信息
		$sql = "select * from user where user_id = $id";
		$data = $this->_dao->GetOneRow($sql);
		return $data;
	}
	
	function showAddBook($id){	// 购买的书籍信息，单买
		$sql = "select * from sale_book inner join user on sale_book.user_id = user.user_id where sale_id = $id";
		$data = $this->_dao->GetOneRow($sql);
		return $data;
	}
	
	// 购买出售书籍 单买
	function addShopOrder($order_id, $book_id, $user_id, $price){
		$sql = "insert into shoporder values ('$order_id', '$user_id', '$book_id', now(), '$price', 0, 1, 0, 0)";
		$data = $this->_dao->exec($sql);
		
		$sql = "select sale_num from sale_book where sale_id = $book_id";
		$data1 = $this->_dao->GetOneData($sql);
		echo $data1;
		if( $data1 == 1 ){
			$sql = "update sale_book set sale_state = 1, sale_num = 0 where sale_id = $book_id";
			$data = $this->_dao->exec($sql);
			return $data;
		}
		else{
			// 修改出售书籍的库存
			$sql = "update sale_book set sale_num = $data1 - 1 where sale_id = $book_id";
			$data = $this->_dao->exec($sql);
			
			// 修改购物车表里的数据
			$sql = "select sale_num from sale_book where sale_id = $book_id";
			$data1 = $this->_dao->GetOneData($sql);
			
			$sql = "select book_num from shopcar where book_id = $book_id";
			$data5 = $this->_dao->GetRows($sql);
			
			foreach($data5 as $key => $value){
				if($data1 < $value[0]){
					$sql = "update shopcar set book_num = $data1 where book_id = $book_id";
					$data = $this->_dao->exec($sql);
				}
			}
			return $data;
		}
	}
	
	function receiveOrder($user_id){	// 我收到的订单
		$sql  = "select * from sale_book as a inner join shoporder as b on a.sale_id = b.book_id ";
		$sql .= "inner join user as c on b.user_id = c.user_id  where a.user_id = $user_id and order_sale = 0 order by order_state, create_time desc";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
	
	function delReceiveById($id){	//删除我收到的订单
		$sql = "update shoporder set order_sale = 1 where order_id = $id";
		$data = $this->_dao->exec($sql); 
		return $data;
	}
	
	function showAddCheck($ids){	//购买书籍信息，购物车里多选
		$sql  = "select * from shopcar as a inner join sale_book as b on a.book_id = b.sale_id ";
		$sql .= "inner join user as u on b.user_id = u.user_id where a.id in ($ids) order by a.create_time desc";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
	
	function Enough($shopcar){
		$sql = "select * from shopcar where id = $shopcar";
		$data = $this->_dao->GetOneRow($sql);
		$sql = "select sale_num from sale_book where sale_id = {$data['book_id']}";
		$data1 = $this->_dao->GetOneData($sql);
		if($data['book_num'] > $data1){
			return false;
		}
		else{
			return true;
		}
	}
	
	function addCheckShopOrder($order_id, $user_id, $value){	// 购买书籍  购物车多选
		// 根据购物车编号 查出书籍信息
		$sql = "select book_id, sale_afprice, book_num, sale_num from shopcar as a inner join sale_book as b on a.book_id = b.sale_id where id = $value";
		$data = $this->_dao->GetOneRow($sql);
		
		// 插入 订单 数据
		$price = $data['sale_afprice']*$data['book_num'];
		$sql  = "insert into shoporder values ('$order_id', '$user_id', {$data['book_id']}, now(), $price, 0, {$data['book_num']}, 0, 0 )";
		$data1 = $this->_dao->exec($sql);
		
		// 删除购物车对应的书籍
		$sql = "delete from shopcar where id = {$value}";
		$data1 = $this->_dao->exec($sql);
		
		// 修改 出售书籍 的信息
		if( $data['book_num'] == $data['sale_num'] ){	// 如果购买数量和库存量一致，就把出售状态改为1，数量为0
			$sql = "update sale_book set sale_state = 1, sale_num = 0 where sale_id = {$data['book_id']}";
			$data2 = $this->_dao->exec($sql);
			return $data2;
		}
		else{	// 如果购买数量 小于 库存量，出售书籍数量 减 购买数量
			$sql = "update sale_book set sale_num = {$data['sale_num']}-{$data['book_num']} where sale_id = {$data['book_id']}";
			$data3 = $this->_dao->exec($sql);
			
			$sql = "select sale_num from sale_book where sale_id = {$data['book_id']}";
			$data4 = $this->_dao->GetOneData($sql);
			
			$sql = "select book_num from shopcar where book_id = {$data['book_id']}";
			$data5 = $this->_dao->GetRows($sql);
			
			foreach($data5 as $key => $value){
				if($data4 < $value[0]){
					$sql = "update shopcar set book_num = $data4 where book_id = {$data['book_id']}";
					$data = $this->_dao->exec($sql);
				}
			}
			return $data;
		}
	}
	
//	确认收货
	function Succeed($id){
		$sql = "update shoporder set order_state = 1 where order_id = '$id'";
		$data = $this->_dao->exec($sql);
		return $data;
	}
}
?>