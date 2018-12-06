<?php
class scommentModel extends BaseModel{
	function GetBcommentById($id){
		$sql = "select * from scomment as b inner join user as u on b.user_id = u.user_id ";
		$sql .= "where b.sbook_id = $id order by b.scomment_time desc";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
	
	function addComment($user_id, $book_id, $content){
		$sql  = "insert into scomment(user_id, scomment_content, scomment_time, sbook_id) ";
		$sql .= "values('$user_id', '$content', now(), '$book_id') ";
		$data = $this->_dao->exec($sql);
		return $data;
	}
	
	function mySComment($id){
		$sql  = "select s.*, i.inquiry_id, i.inquiry_name from scomment as s inner join inquiry_book as i ";
		$sql .= "on s.sbook_id = i.inquiry_id where s.user_id = $id order by scomment_time desc";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
}
?>