<?php
class noticeController extends BaseController{
	function showNoticeAction(){
		$obj = ModelFactory::M('noticeModel');
		$notice = $obj->GetNotice();
		
		/** 1.传入页面 **/
		if( !empty($_GET['page']) ){
		 	$page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 15;	// 每页显示的条数
	 	$ShowPage = 3;	// 显示多少个页数的数字
		
		$to = $obj->GetNoticePage();	// 获取的行数
		$to_pages = ceil($to / $PageSize);	// 页数
		$page_banner = "";
 		//计算偏移量
 		$pageffset = ($ShowPage - 1) / 2;
 		if( $page > 1 ){
		 	$page_banner .= "<a href='?p=back&c=notice&a=showNotice&page=1'>首页</a>";
		 	$page_banner .= "<a href='?p=back&c=notice&a=showNotice&page=".($page-1)."'>上一页</a>";
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
			$page_banner .= "<a href='?p=back&c=notice&a=showNotice&page=".($i)."'>{$i}</a>";
		}
		//尾部省略
		if ( $to_pages > $ShowPage && $to_pages > $page + $pageffset){
			$page_banner .= "...";
		}
		if ( $page < $to_pages ){
			$page_banner .= "<a href='?p=back&c=notice&a=showNotice&page=".($page+1)."'>下一页</a>";
			$page_banner .= "<a href='?p=back&c=notice&a=showNotice&page=".($to_pages)."'>尾页</a>";
		}
		$page_banner .= "共{$to_pages}页";
	
		include VIEW_PATH . 'notice.html';
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
		$obj = ModelFactory::M('noticeModel');
		$notice = $obj->GetSearch($keyword);
		
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
		 	$page_banner .= "<a href='?p=back&c=notice&a=search&page=1'>首页</a>";
		 	$page_banner .= "<a href='?p=back&c=notice&a=search&page=".($page-1)."'>上一页</a>";
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
			$page_banner .= "<a href='?p=back&c=notice&a=search&page=".($i)."'>{$i}</a>";
		}
		//尾部省略
		if ( $to_pages > $ShowPage && $to_pages > $page + $pageffset){
			$page_banner .= "...";
		}
		if ( $page < $to_pages ){
			$page_banner .= "<a href='?p=back&c=notice&a=search&page=".($page+1)."'>下一页</a>";
			$page_banner .= "<a href='?p=back&c=notice&a=search&page=".($to_pages)."'>尾页</a>";
		}
		$page_banner .= "共{$to_pages}页";
	
		include VIEW_PATH . 'notice.html';
	}
	
	function delAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('noticeModel');
		$del = $obj->Delete($id);
		if($del){
			echo "<script>alert('删除成功！'); window.location.href = '?p=back&c=notice&a=showNotice';</script>";
		}
	}
	
	function delCheckAction(){
		$ids = $_POST['ids'];
		$ids = implode(',', $ids);
		$obj = ModelFactory::M('noticeModel');
		$data = $obj->delChecked($ids);
		if($data){
			echo "<script>alert('删除成功！'); window.location.href = '?p=back&c=notice&a=showNotice';</script>";
		}
	}
	
	function editAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('noticeModel');
		$edit = $obj->Edit($id);
		$admin = $obj->GetAdmin();
		include VIEW_PATH . 'editNotice.html';
	}
	
	function editNoticeAction(){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$content = $_POST['content'];
		$admin = $_POST['admin'];
		$obj = ModelFactory::M('noticeModel');
		$edit = $obj->EditNotice($id,$name,$content,$admin);
		if($edit){
			echo "<script>alert('修改成功！'); window.location.href = '?p=back&c=notice&a=showNotice';</script>";
		}
	}
}
?>