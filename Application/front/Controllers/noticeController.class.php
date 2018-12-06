<?php
class noticeController extends BaseController{
	function detailAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('noticeModel');
		$allNotice = $obj->GetAllNotice();
		$notice = $obj->GeteachNotice($id);
		include VIEW_PATH . 'notice_detail.html';
	}
}
?>