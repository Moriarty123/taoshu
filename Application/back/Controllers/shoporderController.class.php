<?php
class shoporderController extends BaseController{
	function showOrderAction(){
		$obj = ModelFactory::M('shoporderModel');
		$order = $obj->GetOrder();
		
		/** 1.传入页面 **/
		if( !empty($_GET['page']) ){
		 	$page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 15;	// 每页显示的条数
	 	$ShowPage = 3;	// 显示多少个页数的数字
		
		$to = $obj->GetOrderPage();	// 获取的行数
		$to_pages = ceil($to / $PageSize);	// 页数
		$page_banner = "";
 		//计算偏移量
 		$pageffset = ($ShowPage - 1) / 2;
 		if( $page > 1 ){
		 	$page_banner .= "<a href='?p=back&c=shoporder&a=showOrder&page=1'>首页</a>";
		 	$page_banner .= "<a href='?p=back&c=shoporder&a=showOrder&page=".($page-1)."'>上一页</a>";
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
			$page_banner .= "<a href='?p=back&c=shoporder&a=showOrder&page=".($i)."'>{$i}</a>";
		}
		//尾部省略
		if ( $to_pages > $ShowPage && $to_pages > $page + $pageffset){
			$page_banner .= "...";
		}
		if ( $page < $to_pages ){
			$page_banner .= "<a href='?p=back&c=shoporder&a=showOrder&page=".($page+1)."'>下一页</a>";
			$page_banner .= "<a href='?p=back&c=shoporder&a=showOrder&page=".($to_pages)."'>尾页</a>";
		}
		$page_banner .= "共{$to_pages}页";
	
		include VIEW_PATH . 'order.html';
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
		$obj = ModelFactory::M('shoporderModel');
		$order = $obj->GetSearch($keyword);
		
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
		 	$page_banner .= "<a href='?p=back&c=shoporder&a=search&page=1'>首页</a>";
		 	$page_banner .= "<a href='?p=back&c=shoporder&a=search&page=".($page-1)."'>上一页</a>";
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
			$page_banner .= "<a href='?p=back&c=shoporder&a=search&page=".($i)."'>{$i}</a>";
		}
		//尾部省略
		if ( $to_pages > $ShowPage && $to_pages > $page + $pageffset){
			$page_banner .= "...";
		}
		if ( $page < $to_pages ){
			$page_banner .= "<a href='?p=back&c=shoporder&a=search&page=".($page+1)."'>下一页</a>";
			$page_banner .= "<a href='?p=back&c=shoporder&a=search&page=".($to_pages)."'>尾页</a>";
		}
		$page_banner .= "共{$to_pages}页";
	
		include VIEW_PATH . 'order.html';
	}
	
	function addAction(){
		$obj = ModelFactory::M('shoporderModel');
		$user = $obj->GetUser();
		$book = $obj->GetBook();
		include VIEW_PATH . 'addOrder.html';
	}
	
	function addOrderAction(){
		$user = $_POST['user'];
		
		$order_id = date("Y-m-dH-i-s");
		$order_id = str_replace("-","",$order_id);
		$order_id .= $user;
		$order_id .= rand(1000,999999);
		
		$name = $_POST['name'];
		$num = $_POST['num'];
		$price = $_POST['price'];
		$obj = ModelFactory::M('shoporderModel');
		$owner = $obj->Owner($name);
		if($owner == $user){
			echo "<script type='text/javascript'>alert('不能购买自己出售的书籍！'); history.go(-1);</script>";
		}
		else{
			$add = $obj->addOrder($order_id, $user, $name, $num, $price);
			if($add){
				echo "<script>alert('添加订单成功！'); window.location.href = '?p=back&c=shoporder&a=showOrder';</script>";
			}
		}
	}
	
	function delAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('shoporderModel');
		$delete = $obj->Delete($id);
		if($delete){
			echo "<script>alert('删除成功！'); window.location.href = '?p=back&c=shoporder&a=showOrder';</script>";
		}
	}
	
	function delCheckAction(){
		$ids = $_POST['ids'];
		$ids = implode(',', $ids);
		$obj = ModelFactory::M('shoporderModel');
		$data = $obj->delChecked($ids);
		if($data){
			echo "<script>alert('删除成功！'); window.location.href = '?p=back&c=shoporder&a=showOrder';</script>";
		}
	}
	
	function editAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('shoporderModel');
		$user = $obj->GetUser();
		$edit = $obj->Edit($id);
		$book = $obj->GetAllBook();
		include VIEW_PATH . 'editOrder.html';
	}
	
	function editOrderAction(){
		$id = $_POST['id'];
		$user = $_POST['user'];
		$book = $_POST['name'];
		$preBook = $_POST['preBook'];
		$num = $_POST['num'];
		$price = $_POST['price'];
//		echo "<br>id : ".$id;
//		echo "<br>user : ".$user;
//		echo "<br>book : ".$book;
//		echo "<br>book : ".$preBook;
//		echo "<br>num : ".$num;
//		echo "<br>price : ".$price;
		$obj = ModelFactory::M('shoporderModel');
		$editOrder = $obj->editOrder($id, $user, $book, $num, $price, $preBook);
		if($editOrder){
			echo "<script>alert('修改成功！'); window.location.href = '?p=back&c=shoporder&a=showOrder';</script>";
		}
	}
	
	function succeedAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('shoporderModel');
		$succeed = $obj->Succeed($id);
		if($succeed){
			echo "<script>alert('修改成功！'); window.location.href = '?p=back&c=shoporder&a=showOrder';</script>";
		}
	}
	
}
?>