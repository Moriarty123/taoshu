<?php
class shoporderController extends BaseController{
	// 我下的订单
	function myorderAction(){
		session_start();
		$obj = ModelFactory::M('shoporderModel');
        $myorder = $obj->showMyOrder($_SESSION['userid']);
		include VIEW_PATH . "personal_order.html";
	}
	
	// 删除我下的订单
	function delAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('shoporderModel');
		$data = $obj->delShopOrderById($id);
		header("location:?c=shoporder&a=myorder");
	}
	
	// 显示购买该出售书籍的确认订单页面
	function showAddShopOrderAction(){
		session_start();
		//做判断,如果没有登录,跳转到登录页面  
        if( !isset($_SESSION['username']) || $_SESSION['username'] == '' ){  
           	header("location:?c=user&a=login");
        } 
        else{
        	$id = $_GET['id'];
        	$obj = ModelFactory::M('shoporderModel');
        	$addUser = $obj->showAddUser($_SESSION['userid']);
        	$addBook = $obj->showAddBook($id);
        	$buyOrNot = $obj->buyOrNot($id);
        	if($buyOrNot){
        		$owner = $obj->Owner($id, $_SESSION['userid']);
        		if($owner){
        			include VIEW_PATH . "order_send.html"; //提交订单页面
        		}
        		else{
        			echo "<script type='text/javascript'>alert('不能购买自己出售的书籍！'); history.go(-1);</script>";
        		}
        	}
        	else{
        		echo "<script type='text/javascript'>alert('该书籍库存量不足，请购买其他书籍！'); window.location.href = '?c=saleBook&a=showAllSale_book';</script>";
        	}
        }
	}
	
	function addShopOrderAction(){	// 购买书籍  单买
		session_start();
		$order_id = date("Y-m-dH-i-s");
		$order_id = str_replace("-","",$order_id);
		$order_id .= $_SESSION['userid'];
		$order_id .= rand(1000,999999);
			
		$book_id = $_GET['id'];
       	$obj = ModelFactory::M('shoporderModel');
       	$price = $obj->getBookPrice($book_id);
       	$buyOrNot = $obj->buyOrNot($book_id);
       	if($buyOrNot){
       		$addShopOrder = $obj->addShopOrder($order_id, $book_id, $_SESSION['userid'], $price);
       		header("location:?c=shoporder&a=myorder");
       	}
       	else{
       		echo "<script type='text/javascript'>alert('该书籍已下架，请购买其他书籍！'); window.location.href = '?c=saleBook&a=showAllSale_book';</script>";
       	}
	}
	
	function receiveorderAction(){	//我收到的订单
		session_start();
		$obj = ModelFactory::M('shoporderModel');
        $receiveorder = $obj->receiveOrder($_SESSION['userid']);
		include VIEW_PATH . "personal_order_receive.html"; //提交订单页面
	}
	
	function delReceiveAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('shoporderModel');
		$data = $obj->delReceiveById($id);
		header("location:?c=shoporder&a=receiveorder");
	}
	
	function addCheckShopOrderAction(){	// 购物车 多选 提交订单
		session_start();
		$shopcar_ids = $_POST['shopcar_ids'];
		$book_ids = $_POST['book_ids'];
		$obj = ModelFactory::M('shoporderModel');
		foreach ($shopcar_ids as $key => $shopcar) {
			$Enough = $obj->Enough($shopcar);		//库存量是否充足
			if($Enough){
				$order_id = date("Y-m-dH-i-s");
				$order_id = str_replace("-","",$order_id);
				$order_id .= $_SESSION['userid'];
				$order_id .= rand(1000,999999);
				
				$addCheckShopOrder = $obj->addCheckShopOrder($order_id, $_SESSION['userid'], $shopcar);
			}
			else{
				echo "<script type='text/javascript'>alert('库存量不足！');</script>";
			}
		}
		echo "<script type='text/javascript'>window.location.href = '?c=shoporder&a=myorder';</script>";
		
//		}
//		foreach ($shopcar_ids as $key => $value) {
//			$order_id = date("Y-m-dH-i-s");
//			$order_id = str_replace("-","",$order_id);
//			$order_id .= $_SESSION['userid'];
//			$order_id .= rand(1000,999999);
//			
//			$addCheckShopOrder = $obj->addCheckShopOrder($order_id, $_SESSION['userid'], $value);
//			header("location:?c=shoporder&a=myorder");
//		}
		
	}
	
	function succeedReceiveAction(){
		$id = $_GET['order_id'];
		$obj = ModelFactory::M('shoporderModel');
		$succeed = $obj->Succeed($id);
		if($succeed){
			echo "<script type='text/javascript'>window.location.href = '?c=shoporder&a=myorder';</script>";
		}
	}
	
}
?>