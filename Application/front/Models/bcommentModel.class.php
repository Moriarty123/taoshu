<?php
class bcommentModel extends BaseModel{
	function GetBcommentById($id){
		$sql = "select * from bcomment as b inner join user as u on b.user_id = u.user_id ";
		$sql .= "where b.bbook_id = $id order by b.bcomment_time desc";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
	
	function addComment($user_id, $book_id, $content){
		$sql  = "insert into bcomment(user_id, bcomment_content, bcomment_time, bbook_id) ";
		$sql .= "values('$user_id', '$content', now(), '$book_id') ";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function myBComment($id){
		$sql  = "select b.*, s.sale_id, s.sale_name from bcomment as b inner join sale_book as s ";
		$sql .= "on b.bbook_id = s.sale_id where b.user_id = $id order by bcomment_time desc";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
}
?>