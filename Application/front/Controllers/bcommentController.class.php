<?php
class bcommentController extends BaseController{
	function addCommentAction(){
		session_start();
		//做判断,如果没有登录,跳转到登录页面  
        if( !isset($_SESSION['username']) || $_SESSION['username'] == '' ){  
           	header("location:?c=user&a=login");
        } 
        else{
			$book_id = $_POST['book_id'];
			$content = $_POST['content'];
			
			$obj = ModelFactory::M('bcommentModel');
			$addComment = $obj->addComment($_SESSION['userid'], $book_id, $content);
			if($addComment){
				echo "<script>alert('留言成功！'); window.location.href = '?c=saleBook&a=each&id=$book_id';</script>";
			}
		}
	}
	
	function myBCommentAction(){
		session_start();
		$obj = ModelFactory::M('bcommentModel');
		$myBComment = $obj->myBComment($_SESSION['userid']);
		include VIEW_PATH . 'personal_bcomment.html';
	}
}
?>