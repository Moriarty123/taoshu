<?php
class inquiryController extends BaseController{
	function showAllInquiryAction(){	// 显示求购书籍
		/** 1.传入页面 **/
		if( !empty($_GET['page']) ){
		 	$page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 8;	// 每页显示的条数
 		$ShowPage = 3;	// 显示多少个页数的数字
 		
		$obj = ModelFactory::M('inquiryModel');
		$allInquiry = $obj->GetAllInquiry();
		
		$to = $obj->GetAllInquiryPage();	// 获取的行数
		$to_pages = ceil($to / $PageSize);	// 页数
		$page_banner = "";
 		//计算偏移量
 		$pageffset = ($ShowPage - 1) / 2;
 		if( $page > 1 ){
		 	$page_banner .= "<a href='?c=inquiry&a=showAllInquiry&page=1'>首页</a>";
		 	$page_banner .= "<a href='?c=inquiry&a=showAllInquiry&page=".($page-1)."'>上一页</a>";
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
			$page_banner .= "<a href='?c=inquiry&a=showAllInquiry&page=".($i)."'>{$i}</a>";
		}
		//尾部省略
		if ( $to_pages > $ShowPage && $to_pages > $page + $pageffset){
			$page_banner .= "...";
		}
		if ( $page < $to_pages ){
			$page_banner .= "<a href='?c=inquiry&a=showAllInquiry&page=".($page+1)."'>下一页</a>";
			$page_banner .= "<a href='?c=inquiry&a=showAllInquiry&page=".($to_pages)."'>尾页</a>";
		}
		$page_banner .= "共{$to_pages}页";
	
		include VIEW_PATH . 'inquiry.html';
	}
	
	function addInquiryAction(){	// 显示添加求购书籍页面
		session_start();
		//做判断,如果没有登录,跳转到登录页面  
        if( !isset($_SESSION['username']) || $_SESSION['username'] == '' ){  
           	header("location:?c=user&a=login");
        } 
        else{
        	$obj = ModelFactory::M('saleBookModel');
			$allType = $obj->GetAllType();
			include VIEW_PATH . 'addInquiryBook.html';
		}
	}
	
	function addAction(){	// 添加求购书籍
		session_start();
		$id = $_SESSION['userid'];
		$inquiry_isbn = $_POST['isbn'];
		$inquiry_name = $_POST['name'];
		$author = $_POST['author'];
		$publishing = $_POST['publishing'];
		$minprice = $_POST['beprice'];
		$maxprice = $_POST['afprice'];
		$num = $_POST['num'];
		$page = $_POST['page'];
		$degrees = $_POST['degrees'];
		$type = $_POST['type'];
		$content = $_POST['content'];
		$attach = $_POST['attach'];
		
		$obj = ModelFactory::M('inquiryModel');
		$inquiryResult = $obj->AddInquiry($inquiry_isbn, $inquiry_name, $author, $publishing, $minprice, $maxprice, $num, $page, $degrees, $type, nl2br($content), nl2br($attach), $id);
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
						echo "<script>alert('发布成功！'); window.location.href = '?c=inquiry&a=showAllInquiry';</script>";
					}
					else{
					    echo "<script>alert('上传图片失败！'); window.location.href = '?c=inquiry&a=showAllInquiry';</script>";
					}
				}
				else{ 
					echo "<script>alert('发布成功！'); window.location.href = '?c=inquiry&a=showAllInquiry';</script>";
				}
			}
			// 处理图片结束
		}
	}
	
	// 详细信息
	function eachAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('inquiryModel');
		$eachInquiry = $obj->GetInquiryById($id);
		$eachSecType = $obj->GetInquirySecTypeById($id);
		$eachBookType = $obj->GetInquiryTypeById($id);
		
		$obj1 = ModelFactory::M('scommentModel');
		$scomment = $obj1->GetBcommentById($id);
		include VIEW_PATH . 'inquiry_detail.html';
	}
	
	// 搜索求购书籍
	function searchAction(){
		session_start();
		if(count($_POST) == 0){
			$keyword = $_SESSION['keyword'];
		}
		else{
			$keyword = $_POST['keyword'];
			$_SESSION['keyword'] = $keyword;
		}
//		$keyword = $_POST['keyword'];
		$obj = ModelFactory::M('inquiryModel');
		$search = $obj->GetSearchByName($keyword);
		if($search == false){
			include VIEW_PATH . 'search_no_inquiry.html';
		}
		else{
			/** 1.传入页面 **/
			if( !empty($_GET['page']) ){
			 	$page = $_GET['page'];
			}
			else{
				$page = 1;
			}
			$PageSize = 8;	// 每页显示的条数
	 		$ShowPage = 3;	// 显示多少个页数的数字
			
			$to = $obj->GetSearchByNamePage($keyword);	// 获取的行数
			$to_pages = ceil($to / $PageSize);	// 页数
			$page_banner = "";
 			//计算偏移量
 			$pageffset = ($ShowPage - 1) / 2;
 			if( $page > 1 ){
			 	$page_banner .= "<a href='?c=inquiry&a=search&page=1'>首页</a>";
			 	$page_banner .= "<a href='?c=inquiry&a=search&page=".($page-1)."'>上一页</a>";
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
				$page_banner .= "<a href='?c=inquiry&a=search&page=".($i)."'>{$i}</a>";
			}
			//尾部省略
			if ( $to_pages > $ShowPage && $to_pages > $page + $pageffset){
				$page_banner .= "...";
			}
			if ( $page < $to_pages ){
				$page_banner .= "<a href='?c=inquiry&a=search&page=".($page+1)."'>下一页</a>";
				$page_banner .= "<a href='?c=inquiry&a=search&page=".($to_pages)."'>尾页</a>";
			}
			$page_banner .= "共{$to_pages}页";
			
			include VIEW_PATH . 'search_yes_inquiry.html';
		}
	}
	
	function myInquiryAction(){	// 我的求购书籍
		session_start();
		$obj = ModelFactory::M('inquiryModel');
		$myInquiry = $obj->GetMyInquiry($_SESSION['userid']);
		include VIEW_PATH . 'personal_inquiry.html';
	}
	
}
?>