<?php
class shopcarModel extends BaseModel{
	function showShopCarById($id){
		$sql = "select count(*) from shopcar where user_id = $id";
		$result = $this->_dao->GetOneData($sql);
		if($result == 0){
			return false;
		}
		else{
			$sql  = "select a.*, b.user_id, b.sale_id, b.sale_name, b.sale_img, b.sale_beprice, b.sale_afprice, b.sale_num, u.user_name, u.user_realname ";
			$sql .= "from shopcar as a inner join sale_book as b on a.book_id = b.sale_id ";
			$sql .= "inner join user as u on b.user_id = u.user_id ";
			$sql .= "where a.user_id = $id and sale_state = 0 order by create_time desc;";
			$data = $this->_dao->GetRows($sql);
			return $data;
		}
	}
	
	function delShopCarById($id){	// 每行的删除按钮
		$sql = "delete from shopcar where id = $id";
		$data = $this->_dao->exec($sql); 
		return $data;
	}
	
	function delChecked($ids){	// 删除选中按钮
		$sql = "delete from shopcar where id in ($ids)";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	// 减数量
	function subNum($id){
		$sql = "select book_num from shopcar where id = $id";
		$data = $this->_dao->GetOneData($sql);
		if($data == 1){
			$sql = "delete from shopcar where id = $id";
			$result = $this->_dao->exec($sql);
			return $result;
		}
		else{
			$sql = "update shopcar set book_num = ({$data}-1) where id = $id;";
			$result = $this->_dao->exec($sql);
			return $result;
		}
	}
	
	// 加数量
	function addNum($id){
		$sql = "select book_num from shopcar where id = $id";
		$data = $this->_dao->GetOneData($sql);
		$sql = "update shopcar set book_num = ({$data}+1) where id = $id;";
		$result = $this->_dao->exec($sql);
		return $result;
	}
	
	//点击收藏 加入购物车
	function addShopCar($book_id, $user_id){
		$sql = "select count(*) from shopcar where book_id = $book_id and user_id = $user_id";
		$data = $this->_dao->GetOneData($sql);
		if( $data == 1 ){
			$sql = "select book_num, sale_num from shopcar inner join sale_book on sale_id = book_id where book_id = $book_id";
			$data = $this->_dao->GetOneRow($sql);
			if( $data['book_num'] < $data['sale_num'] ){ // 购买数量小于库存量
				$sql  = "update shopcar set book_num = ({$data['book_num']}+1) ";
				$sql .= "where book_id = $book_id and user_id = $user_id";
				$data = $this->_dao->exec($sql);
				return $data;
			}
			else{
				return false;
			}
		}
		else{
			$sql = "insert into shopcar(user_id, book_id, create_time) values({$user_id}, {$book_id},now())";
			$result = $this->_dao->exec($sql);
			return $result;
		}
	}
	
	// 判断是否是本人发布出售的信息
	function addShopCarBySame($book_id, $user_id){
		$sql = "select user_id from sale_book where sale_id = $book_id";
		$data = $this->_dao->GetOneData($sql);
		if($data == $user_id){
			return false;
		}
		else{
			return true;
		}
	}
}
?>