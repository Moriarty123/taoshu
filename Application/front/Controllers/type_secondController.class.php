<?php
class type_secondController extends BaseController{
	function showAllType_secondAction(){
		$obj = ModelFactory::M('type_secondModel');
		$type_second_jj = $obj->GetAllTypeSecond_jj();	//经济金融
		$type_second_jsj = $obj->GetAllTypeSecond_jsj();//计算机与网络
		$type_second_gl = $obj->GetAllTypeSecond_gl();	//管理
		$type_second_yy = $obj->GetAllTypeSecond_yy();	//语言学习
		$type_second_wx = $obj->GetAllTypeSecond_wx();	//文学小说
		$type_second_yx = $obj->GetAllTypeSecond_yx();	//医学卫生
		$type_second_jy = $obj->GetAllTypeSecond_jy();	//教育考试
		$type_second_zr = $obj->GetAllTypeSecond_zr();	//自然科学
		$type_second_fl = $obj->GetAllTypeSecond_fl();	//法律
		$type_second_ty = $obj->GetAllTypeSecond_ty();	//体育保健
		$type_second_xl = $obj->GetAllTypeSecond_xl();	//心理
		$type_second_xw = $obj->GetAllTypeSecond_xw();	//新闻传播
		$type_second_cg = $obj->GetAllTypeSecond_cg();	//成功励志
		$type_second_sh = $obj->GetAllTypeSecond_sh();	//生活时尚
		
		include VIEW_PATH . 'classify.html';
	}
}
?>