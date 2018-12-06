<?php
class noticeModel extends BaseModel{
	function GetAllNotice(){
		$sql = "select * from notice  order by notice_time desc";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
	
	function GeteachNotice($id){
		$sql = "select view_time from notice where notice_id = $id";
		$result = $this->_dao->GetOneData($sql);
		$sql = "update notice set view_time = $result + 1 where notice_id = $id";
		$result = $this->_dao->exec($sql);
		$sql = "select * from notice as n inner join admin as a on n.admin_id = a.id where n.notice_id = $id;";
		$data = $this->_dao->GetOneRow($sql);
		return $data;
	}
}
?>