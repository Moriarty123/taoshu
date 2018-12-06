<?php
class inquiryController extends BaseController{
	function showInquiryAction(){
		$obj = ModelFactory::M('inquiryModel');
		$inquiry = $obj->GetInquiry();
		
		/** 1.传入页面 **/
		if( !empty($_GET['page']) ){
		 	$page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 15;	// 每页显示的条数
	 	$ShowPage = 3;	// 显示多少个页数的数字
		
		$to = $obj->GetInquiryPage();	// 获取的行数
		$to_pages = ceil($to / $PageSize);	// 页数
		$page_banner = "";
 		//计算偏移量
 		$pageffset = ($ShowPage - 1) / 2;
 		if( $page > 1 ){
		 	$page_banner .= "<a href='?p=back&c=inquiry&a=showInquiry&page=1'>首页</a>";
		 	$page_banner .= "<a href='?p=back&c=inquiry&a=showInquiry&page=".($page-1)."'>上一页</a>";
 		}
 		//初始化数据
 		$start = 1;
 		$end = $to_pages;
 		if ( $to_pages > $ShowPage ){
			if( $page > $pageffset + 1 ){
			 	$page_banner .= "...";
			}
			if ( $page > $pageffset ){
				$start = $page - $pageffset;
				$end = $to_pages > $page + $pageffset ? $page + $pageffset : $to_pages;
			}
			else{
				$start=1;
				$end = $to_pages > $ShowPage ? $ShowPage : $to_pages;
			}
			if ( $page + $pageffset > $to_pages ){
			 	$start = $start - ($page + $pageffset - $end);
			}
		}
		for( $i = $start; $i <= $end; $i++){
			$page_banner .= "<a href='?p=back&c=inquiry&a=showInquiry&page=".($i)."'>{$i}</a>";
		}
		//尾部省略
		if ( $to_pages > $ShowPage && $to_pages > $page + $pageffset){
			$page_banner .= "...";
		}
		if ( $page < $to_pages ){
			$page_banner .= "<a href='?p=back&c=inquiry&a=showInquiry&page=".($page+1)."'>下一页</a>";
			$page_banner .= "<a href='?p=back&c=inquiry&a=showInquiry&page=".($to_pages)."'>尾页</a>";
		}
		$page_banner .= "共{$to_pages}页";
	
		include VIEW_PATH . 'inquiry.html';
	}
	
	function searchAction(){
		session_start();
		if(count($_POST) == 0){
			$keyword = $_SESSION['keyword'];
		}
		else{
			$keyword = $_POST['search'];
			$_SESSION['keyword'] = $keyword;
		}
		$obj = ModelFactory::M('inquiryModel');
		$inquiry = $obj->GetSearch($keyword);
		
		/** 1.传入页面 **/
		if( !empty($_GET['page']) ){
		 	$page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 15;	// 每页显示的条数
	 	$ShowPage = 3;	// 显示多少个页数的数字
		
		$to = $obj->GetSearchPage($keyword);	// 获取的行数
		$to_pages = ceil($to / $PageSize);	// 页数
		$page_banner = "";
 		//计算偏移量
 		$pageffset = ($ShowPage - 1) / 2;
 		if( $page > 1 ){
		 	$page_banner .= "<a href='?p=back&c=inquiry&a=search&page=1'>首页</a>";
		 	$page_banner .= "<a href='?p=back&c=inquiry&a=search&page=".($page-1)."'>上一页</a>";
 		}
 		//初始化数据
 		$start = 1;
 		$end = $to_pages;
 		if ( $to_pages > $ShowPage ){
			if( $page > $pageffset + 1 ){
			 	$page_banner .= "...";
			}
			if ( $page > $pageffset ){
				$start = $page - $pageffset;
				$end = $to_pages > $page + $pageffset ? $page + $pageffset : $to_pages;
			}
			else{
				$start=1;
				$end = $to_pages > $ShowPage ? $ShowPage : $to_pages;
			}
			if ( $page + $pageffset > $to_pages ){
			 	$start = $start - ($page + $pageffset - $end);
			}
		}
		for( $i = $start; $i <= $end; $i++){
			$page_banner .= "<a href='?p=back&c=inquiry&a=search&page=".($i)."'>{$i}</a>";
		}
		//尾部省略
		if ( $to_pages > $ShowPage && $to_pages > $page + $pageffset){
			$page_banner .= "...";
		}
		if ( $page < $to_pages ){
			$page_banner .= "<a href='?p=back&c=inquiry&a=search&page=".($page+1)."'>下一页</a>";
			$page_banner .= "<a href='?p=back&c=inquiry&a=search&page=".($to_pages)."'>尾页</a>";
		}
		$page_banner .= "共{$to_pages}页";
	
		include VIEW_PATH . 'inquiry.html';
	}
	
	function addAction(){	//显示添加出售页面
		$obj = ModelFactory::M('inquiryModel');
		$type = $obj->GetType();
		$user = $obj->GetUser();
		include VIEW_PATH . 'addInquiry.html';
	}
	
	function addInquiryAction(){
		$inquiry_isbn = $_POST['isbn'];
		$inquiry_name = $_POST['name'];
		$author = $_POST['author'];
		$publishing = $_POST['publishing'];
		$beprice = $_POST['beprice'];
		$afprice = $_POST['afprice'];
		$num = $_POST['num'];
		$page = $_POST['page'];
		$degrees = $_POST['degrees'];
		$type = $_POST['type'];
		$content = $_POST['content'];
		$attach = $_POST['attach'];
		$id = $_POST['user'];
		
		$obj = ModelFactory::M('inquiryModel');
		$inquiryResult = $obj->AddInquiry($inquiry_isbn, $inquiry_name, $author, $publishing, $beprice, $afprice, $num, $page, $degrees, $type, nl2br($content), $attach, $id);
		if($inquiryResult){
			// 处理图片
			date_default_timezone_set("PRC");         //设置时区 
			if( count($_FILES) > 0){ 
				$sort = array("image/jpeg","image/jpg","image/gif","image/pdg","image/png"); 
				//判断是否是图片类型
				if( in_array($_FILES['img']['type'], $sort) ){ 
					$img = "img";    //获取上传到的文件夹位置
					//判断文件夹是否存在 ,如果不存在创建一个
					if( !file_exists($img) ){
					  	mkdir("$img",0700);        //0700最高权限
					}
					$time=date("Y_m_d_H_i_s");     //获取当前时间
					$file_name = explode(".", $_FILES['img']['name']);//$_FILES['img']['name'] 上传文件的名称 explode字符串打断转字符串
					$file_name[0] = $time;  
					$name = implode(".",$file_name);    //implode 把数组拼接成字符串
					$img_name = "img/".$name;
					if(move_uploaded_file($_FILES['img']['tmp_name'],$img_name)){   //move_uploaded_file 移动文件
						$addImg = $obj->addImg($inquiry_isbn, $inquiry_name, $author, $publishing, $img_name, $id);
						echo "<script>alert('发布成功！'); window.location.href = '?p=back&c=inquiry&a=showInquiry';</script>";
					}
					else{
						echo "<script>alert('上传图片失败！'); window.location.href = '?p=back&c=inquiry&a=showInquiry';</script>";
					}
				}
				else{ 
					echo "<script>alert('发布成功！'); window.location.href = '?p=back&c=inquiry&a=showInquiry';</script>";
				}
			}
			// 处理图片结束
		}
	}
	
	function delAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('inquiryModel');
		$del = $obj->DeleteInquiry($id);
		if($del){
			echo "<script>alert('删除成功！'); window.location.href = '?p=back&c=inquiry&a=showInquiry';</script>";
		}
	}
	
	function delCheckAction(){
		$ids = $_POST['ids'];
		$ids = implode(',', $ids);
		$obj = ModelFactory::M('inquiryModel');
		$data = $obj->delChecked($ids);
		if($data){
			echo "<script>alert('删除成功！'); window.location.href = '?p=back&c=inquiry&a=showInquiry';</script>";
		}
	}
	
	function editAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('inquiryModel');
		$type = $obj->GetType();
		$user = $obj->GetUser();
		$edit = $obj->Edit($id);
		include VIEW_PATH . 'editInquiry.html';
	}
	
	function editInquiryAction(){
		$id = $_POST['id'];
		$inquiry_isbn = $_POST['isbn'];
		$inquiry_name = $_POST['name'];
		$author = $_POST['author'];
		$publishing = $_POST['publishing'];
		$beprice = $_POST['beprice'];
		$afprice = $_POST['afprice'];
		$num = $_POST['num'];
		$page = $_POST['page'];
		$degrees = $_POST['degrees'];
		$type = $_POST['type'];
		$content = $_POST['content'];
		$user_id = $_POST['user'];
		
		$obj = ModelFactory::M('inquiryModel');
		$inquiryResult = $obj->EditInquiry($id, $inquiry_isbn, $inquiry_name, $author, $publishing, $beprice, $afprice, $num, $page, $degrees, $type, nl2br($content), $user_id);
		if($inquiryResult){
			// 处理图片
			date_default_timezone_set("PRC");         //设置时区 
			if( count($_FILES) > 0){ 
				$sort = array("image/jpeg","image/jpg","image/gif","image/pdg","image/png"); 
				//判断是否是图片类型
				if( in_array($_FILES['img']['type'], $sort) ){ 
					$img = "img";    //获取上传到的文件夹位置
					//判断文件夹是否存在 ,如果不存在创建一个
					if( !file_exists($img) ){
					  	mkdir("$img",0700);        //0700最高权限
					}
					$time=date("Y_m_d_H_i_s");     //获取当前时间
					$file_name = explode(".", $_FILES['img']['name']);//$_FILES['img']['name'] 上传文件的名称 explode字符串打断转字符串
					$file_name[0] = $time;  
					$name = implode(".",$file_name);    //implode 把数组拼接成字符串
					$img_name = "img/".$name;
					if(move_uploaded_file($_FILES['img']['tmp_name'],$img_name)){   //move_uploaded_file 移动文件
						$addImg = $obj->EditImg($id, $img_name);
						echo "<script>alert('修改成功！'); window.location.href = '?p=back&c=inquiry&a=showInquiry';</script>";
					}
					else{
						echo "<script>alert('上传图片失败！'); window.location.href = '?p=back&c=inquiry&a=showInquiry';</script>";
					}
				}
				else{ 
					echo "<script>alert('修改成功！'); window.location.href = '?p=back&c=inquiry&a=showInquiry';</script>";
				}
			}
			// 处理图片结束
		}
	}
}
?>