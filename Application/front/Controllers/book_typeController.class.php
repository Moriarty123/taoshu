<?php
class book_typeController extends BaseController{
	function indexAction(){
		$obj = ModelFactory::M('book_typeModel');
		$data = $obj->GetAllBookType();
		include VIEW_PATH . 'index.html';
	}
}
?>