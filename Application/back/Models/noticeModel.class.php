<?php
class noticeModel extends BaseModel{
	function GetNotice(){		// 所有用户
		if( !empty($_GET['page']) ){
			 $page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 15;	// 每页显示的条数
 		$ShowPage = 3;	// 显示多少个页数的数字
 		
		$sql  = "select * from admin as a inner join notice as n on a.id = n.admin_id order by notice_time desc ";
		$sql .= "limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);  //返回一个数据值，表示找到的行数
		return $data;
	}
	function GetNoticePage(){		//所有用户 的页数
		$sql = "select count(*) from notice";
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
 		
		$sql  = "select * from admin as a inner join notice as n on a.id = n.admin_id where notice_title like '%{$keyword}%' order by notice_time desc ";
		$sql .= "limit ".($page - 1) * $PageSize .", $PageSize";
		$data = $this->_dao->GetRows($sql);  //返回一个数据值，表示找到的行数
		return $data;
	}
	function GetSearchPage($keyword){		//所有用户 的页数
		$sql = "select count(*) from notice where notice_title like '%{$keyword}%' ";
		$result = $this->_dao->GetOneData($sql);
		return $result;
	}
	
	function Delete($id){
		$sql = "delete from notice where notice_id = $id";
		$result = $this->_dao->exec($sql);
		return $result;
	}
	
	function delChecked($ids){
		$sql = "delete from notice where notice_id in ($ids)";
		$data = $this->_dao->exec($sql); 
		return $data;
	}
	
	function Edit($id){
		$sql = "select * from notice as n inner join admin as a on n.admin_id = a.id where notice_id = $id";
		$result = $this->_dao->GetOneRow($sql);
		return $result;
	}
	
	function GetAdmin(){
		$sql = "select * from admin";
		$data = $this->_dao->GetRows($sql);
		return $data;
	}
	function EditNotice($id, $name, $content,$admin){
		$sql = "update notice set notice_title = '$name', notice_content = '$content', admin_id = '$admin' where notice_id = $id";
		$result = $this->_dao->exec($sql);
		return $result;
	}
}
?>