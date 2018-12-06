<?php
class bcommentController extends BaseController{
	function showBCommentAction(){
		$obj = ModelFactory::M('bcommentModel');
		$bcomment = $obj->GetBComment();
		
		/** 1.传入页面 **/
		if( !empty($_GET['page']) ){
		 	$page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 15;	// 每页显示的条数
	 	$ShowPage = 3;	// 显示多少个页数的数字
		
		$to = $obj->GetBCommentPage();	// 获取的行数
		$to_pages = ceil($to / $PageSize);	// 页数
		$page_banner = "";
 		//计算偏移量
 		$pageffset = ($ShowPage - 1) / 2;
 		if( $page > 1 ){
		 	$page_banner .= "<a href='?p=back&c=bcomment&a=showBComment&page=1'>首页</a>";
		 	$page_banner .= "<a href='?p=back&c=bcomment&a=showBComment&page=".($page-1)."'>上一页</a>";
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
			$page_banner .= "<a href='?p=back&c=bcomment&a=showBComment&page=".($i)."'>{$i}</a>";
		}
		//尾部省略
		if ( $to_pages > $ShowPage && $to_pages > $page + $pageffset){
			$page_banner .= "...";
		}
		if ( $page < $to_pages ){
			$page_banner .= "<a href='?p=back&c=bcomment&a=showBComment&page=".($page+1)."'>下一页</a>";
			$page_banner .= "<a href='?p=back&c=bcomment&a=showBComment&page=".($to_pages)."'>尾页</a>";
		}
		$page_banner .= "共{$to_pages}页";
	
		include VIEW_PATH . 'bcomment.html';
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
		$obj = ModelFactory::M('bcommentModel');
		$bcomment = $obj->GetSearch($keyword);
		
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
		 	$page_banner .= "<a href='?p=back&c=bcomment&a=search&page=1'>首页</a>";
		 	$page_banner .= "<a href='?p=back&c=bcomment&a=search&page=".($page-1)."'>上一页</a>";
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
			$page_banner .= "<a href='?p=back&c=bcomment&a=search&page=".($i)."'>{$i}</a>";
		}
		//尾部省略
		if ( $to_pages > $ShowPage && $to_pages > $page + $pageffset){
			$page_banner .= "...";
		}
		if ( $page < $to_pages ){
			$page_banner .= "<a href='?p=back&c=bcomment&a=search&page=".($page+1)."'>下一页</a>";
			$page_banner .= "<a href='?p=back&c=bcomment&a=search&page=".($to_pages)."'>尾页</a>";
		}
		$page_banner .= "共{$to_pages}页";
	
		include VIEW_PATH . 'bcomment.html';
	}
	
	function addAction(){
		$obj = ModelFactory::M('bcommentModel');
		$book = $obj->GetBook();
		$user = $obj->GetUser();
		include VIEW_PATH . 'addBComment.html';
	}
	
	function addBCommentAction(){
		$name = $_POST['name'];
		$user = $_POST['user'];
		$content = $_POST['content'];
		$obj = ModelFactory::M('bcommentModel');
		$add = $obj->addBComment( $name, $user, nl2br($content) );
		if($add){
			echo "<script>alert('添加留言成功！'); window.location.href = '?p=back&c=bcomment&a=showBComment';</script>";
		}
	}
	
	function delAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('bcommentModel');
		$del = $obj->Delete($id);
		if($del){
			echo "<script>alert('删除留言成功！'); window.location.href = '?p=back&c=bcomment&a=showBComment';</script>";
		}
	}
	
	function delCheckAction(){
		$ids = $_POST['ids'];
		$ids = implode(',', $ids);
		$obj = ModelFactory::M('bcommentModel');
		$data = $obj->delChecked($ids);
		if($data){
			echo "<script>alert('删除留言成功！'); window.location.href = '?p=back&c=bcomment&a=showBComment';</script>";
		}
	}
	
	function editAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('bcommentModel');
		$sale = $obj->GetBook();
		$edit = $obj->Edit($id);
		$user = $obj->GetUser();
		include VIEW_PATH . 'editBComment.html';
	}
	
	function editBCommentAction(){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$user = $_POST['user'];
		$content = $_POST['content'];
		$obj = ModelFactory::M('bcommentModel');
		$editResult = $obj->EditBComment( $name, $user, nl2br($content), $id );
		if($editResult){
			echo "<script>alert('修改留言成功！'); window.location.href = '?p=back&c=bcomment&a=showBComment';</script>";
		}
	}
}
?>