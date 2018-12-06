<?php
class saleBookController extends BaseController{
	function eachAction(){	// 点击一本书
		$id = $_GET['id'];
		$obj = ModelFactory::M('saleBookModel');
		$eachSaleBook = $obj->GetSaleBookById($id);
		$eachSecType = $obj->GetSaleSecTypeById($id);
		$eachBookType = $obj->GetSaleBookTypeById($id);
		
		$obj1 = ModelFactory::M('bcommentModel');
		$bcomment = $obj1->GetBcommentById($id);
		include VIEW_PATH . 'sale_detail.html';
	}
	
	function searchAction(){	// 搜索
		session_start();
		if(count($_POST) == 0){
			$keyword = $_SESSION['keyword'];
		}
		else{
			$keyword = $_POST['keyword'];
			$_SESSION['keyword'] = $keyword;
		}
//		$keyword = $_POST['keyword'];
		$obj = ModelFactory::M('saleBookModel');
		$search = $obj->GetSearchByName($keyword);
		if($search == false){
			include VIEW_PATH . 'search_no.html';
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
			 	$page_banner .= "<a href='?c=saleBook&a=search&page=1'>首页</a>";
			 	$page_banner .= "<a href='?c=saleBook&a=search&page=".($page-1)."'>上一页</a>";
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
				$page_banner .= "<a href='?c=saleBook&a=search&page=".($i)."'>{$i}</a>";
			}
			//尾部省略
			if ( $to_pages > $ShowPage && $to_pages > $page + $pageffset){
				$page_banner .= "...";
			}
			if ( $page < $to_pages ){
				$page_banner .= "<a href='?c=saleBook&a=search&page=".($page+1)."'>下一页</a>";
				$page_banner .= "<a href='?c=saleBook&a=search&page=".($to_pages)."'>尾页</a>";
			}
			$page_banner .= "共{$to_pages}页";
			
			include VIEW_PATH . 'search_yes.html';
		}
	}
	function detailAction(){	// 点击一类书
		$id = $_GET['id'];
		$obj = ModelFactory::M('saleBookModel');
		$detailSaleBook = $obj->GetTypeSale($id);	// 根据id获取某二级类别的所有出售书籍
		$firstType = $obj->GetFirstType($id);		// 根据second_id获取其一级类别的类别名称
		$secType = $obj->GetSecType($id);			// 根据second_id获取其二级类别的所有信息，多行(左侧的目录导航)
		$secName = $obj->GetSecNameById($id);		// 根据点击的second_id获取second_name
		$countBook =  $obj->GetCountById($id);
		
		/** 1.传入页面 **/
		if( !empty($_GET['page']) ){
		 	$page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 8;	// 每页显示的条数
 		$ShowPage = 3;	// 显示多少个页数的数字
		
		$to = $obj->GetTypeSalePage($id);	// 获取的行数
		$to_pages = ceil($to / $PageSize);	// 页数
		$page_banner = "";
 		//计算偏移量
 		$pageffset = ($ShowPage - 1) / 2;
 		if( $page > 1 ){
		 	$page_banner .= "<a href='?c=saleBook&a=detail&id=$id&page=1'>首页</a>";
		 	$page_banner .= "<a href='?c=saleBook&a=detail&id=$id&page=".($page-1)."'>上一页</a>";
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
			$page_banner .= "<a href='?c=saleBook&a=detail&id=$id&page=".($i)."'>{$i}</a>";
		}
		//尾部省略
		if ( $to_pages > $ShowPage && $to_pages > $page + $pageffset){
			$page_banner .= "...";
		}
		if ( $page < $to_pages ){
			$page_banner .= "<a href='?c=saleBook&a=detail&id=$id&page=".($page+1)."'>下一页</a>";
			$page_banner .= "<a href='?c=saleBook&a=detail&id=$id&page=".($to_pages)."'>尾页</a>";
		}
		$page_banner .= "共{$to_pages}页";
		
		include VIEW_PATH . 'classify_detail.html';
	}
	
	function showAllSale_bookAction(){
		/** 1.传入页面 **/
		if( !empty($_GET['page']) ){
		 	$page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 8;	// 每页显示的条数
 		$ShowPage = 3;	// 显示多少个页数的数字
 		
		$obj = ModelFactory::M('saleBookModel');
		$allSale_book = $obj->GetAllSale_book();
		
		$to = $obj->GetAllSale_bookPage();	// 获取的行数
		$to_pages = ceil($to / $PageSize);	// 页数
		$page_banner = "";
 		//计算偏移量
 		$pageffset = ($ShowPage - 1) / 2;
 		if( $page > 1 ){
		 	$page_banner .= "<a href='?c=saleBook&a=showAllSale_book&page=1'>首页</a>";
		 	$page_banner .= "<a href='?c=saleBook&a=showAllSale_book&page=".($page-1)."'>上一页</a>";
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
			$page_banner .= "<a href='?c=saleBook&a=showAllSale_book&page=".($i)."'>{$i}</a>";
		}
		//尾部省略
		if ( $to_pages > $ShowPage && $to_pages > $page + $pageffset){
			$page_banner .= "...";
		}
		if ( $page < $to_pages ){
			$page_banner .= "<a href='?c=saleBook&a=showAllSale_book&page=".($page+1)."'>下一页</a>";
			$page_banner .= "<a href='?c=saleBook&a=showAllSale_book&page=".($to_pages)."'>尾页</a>";
		}
		$page_banner .= "共{$to_pages}页";
	
		include VIEW_PATH . 'sale.html';
	}
	
	function addSaleAction(){
		session_start();
		//做判断,如果没有登录,跳转到登录页面  
        if( !isset($_SESSION['username']) || $_SESSION['username'] == '' ){  
           	header("location:?c=user&a=login");
        } 
        else{
			$obj = ModelFactory::M('saleBookModel');
			$allType = $obj->GetAllType();
			include VIEW_PATH . 'addSaleBook.html';
		}
	}
	
	function addAction(){
		session_start();
		$id = $_SESSION['userid'];
		$sale_isbn = $_POST['isbn'];
		$sale_name = $_POST['name'];
		$author = $_POST['author'];
		$publishing = $_POST['publishing'];
		$beprice = $_POST['beprice'];
		$afprice = $_POST['afprice'];
		$num = $_POST['num'];
		$page = $_POST['page'];
		$degrees = $_POST['degrees'];
		$type = $_POST['type'];
		$content = $_POST['content'];
		
		$obj = ModelFactory::M('saleBookModel');
		$saleResult = $obj->AddSale($sale_isbn, $sale_name, $author, $publishing, $beprice, $afprice, $num, $page, $degrees, $type, nl2br($content), $id);
		if($saleResult){
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
						$addImg = $obj->addImg($sale_isbn, $sale_name, $author, $publishing, $img_name, $id);
						echo "<script>alert('发布成功！'); window.location.href = '?c=saleBook&a=showAllSale_book';</script>";
					}
					else{
						echo "<script>alert('上传图片失败！'); window.location.href = '?c=saleBook&a=showAllSale_book';</script>";
					}
				}
				else{ 
					echo "<script>alert('发布成功！'); window.location.href = '?c=saleBook&a=showAllSale_book';</script>";
				}
			}
			// 处理图片结束
		}
	}
	
	function mySaleBookAction(){	// 我的出售书籍
		session_start();
		$obj = ModelFactory::M('saleBookModel');
		$mySaleBook = $obj->GetMySaleBook($_SESSION['userid']);
		include VIEW_PATH . 'personal_sale.html';
	}
}
?>