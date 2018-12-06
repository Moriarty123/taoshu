<?php
class indexController extends BaseController{
	function indexAction(){
		$obj = ModelFactory::M('indexModel');
		$book_type = $obj->GetAllBookType();
		
		$type_second_jj = $obj->GetTypeSecond_jj();	//经济金融
		$type_second_jsj = $obj->GetTypeSecond_jsj();	//计算机与网络
		$type_second_gl = $obj->GetTypeSecond_gl();	//管理
		$type_second_yy = $obj->GetTypeSecond_yy();	//语言学习
		$type_second_wx = $obj->GetTypeSecond_wx();	//文学小说
		$type_second_yx = $obj->GetTypeSecond_yx();	//医学卫生
		$type_second_jy = $obj->GetTypeSecond_jy();	//教育考试
		
		$type_second_ajj = $obj->GetAllTypeSecond_jj();	//经济金融
		$type_second_ajsj = $obj->GetAllTypeSecond_jsj();	//计算机与网络
		$type_second_agl = $obj->GetAllTypeSecond_gl();	//管理
		$type_second_ayy = $obj->GetAllTypeSecond_yy();	//语言学习
		$type_second_awx = $obj->GetAllTypeSecond_wx();	//文学小说
		$type_second_ayx = $obj->GetAllTypeSecond_yx();	//医学卫生
		$type_second_ajy = $obj->GetAllTypeSecond_jy();	//教育考试
		
		$sale_book = $obj->GetNewSaleBook();	//获取最新出售书籍
		$inquiry_book = $obj->GetNewInquiry();	//获取最新求购书籍
		
		$notice = $obj->GetNotice();	// 获取公告信息
		
		include VIEW_PATH . 'index.html';
	}
}
?>