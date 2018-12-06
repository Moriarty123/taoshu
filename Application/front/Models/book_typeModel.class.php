<?php
class book_typeModel extends BaseModel{
	function GetAllBookType(){
		$sql = "select type_name from book_type limit 0,8;";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
}
?>