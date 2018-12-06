<?php
class shopcarController extends BaseController{
	// 点击收藏  加入购物车
	function addShopCarAction(){
		session_start();
		//做判断,如果没有登录,跳转到登录页面  
        if( !isset($_SESSION['username']) || $_SESSION['username'] == '' ){  
           	header("location:?c=user&a=login");
        } 
        else{
			$book_id = $_GET['id'];
        	$obj = ModelFactory::M('shopcarModel');
        	$addResultBySame = $obj->addShopCarBySame($book_id, $_SESSION['userid']); // 判断是否是本人发布出售的信息
			if( $addResultBySame ){
				$addResult = $obj->addShopCar($book_id, $_SESSION['userid']);
				if( $addResult == false ){
					echo "<script type='text/javascript'>alert('你已添加该书籍，可去购物车购买！'); window.location.href = '?c=shopcar&a=showShopCar';</script>";
				}
				else{
					echo "<script type='text/javascript'>alert('加入购物车成功！'); location.href = document.referrer;</script>";
				}
			}
			else{
				echo "<script type='text/javascript'>alert('不能添加自己出售的二手书！');history.go(-1);</script>";
			}
        }
	}
	
	function showShopCarAction(){
		session_start();
		//做判断,如果没有登录,跳转到登录页面  
        if( !isset($_SESSION['username']) || $_SESSION['username'] == '' ){  
           	header("location:?c=user&a=login");
        } 
        else{	// 根据登录成功的id获取其购物车列表
        	$id = $_SESSION['userid'];
        	$obj = ModelFactory::M('shopcarModel');
			$shopCarLists = $obj->showShopCarById($id);
			if( $shopCarLists == false ){
				include VIEW_PATH . 'shopCar_no.html';
			}
			else{
				include VIEW_PATH . 'shopCar.html';
			}
        }
	}
	
	function deleteAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('shopcarModel');
		$data = $obj->delShopCarById($id);
		header("location:?c=shopcar&a=showShopCar");
	}
	
	function delCheckedAction(){
		session_start();
		$submit = $_POST['Submit'];
		$ids = $_POST['ids'];
		if( !isset($ids) || $ids == null ){
			echo "<script>alert('你还没有选中任何项！'); history.go(-1);</script>";
		}
		else{
			if( $submit == '删除选中' ){
				$obj = ModelFactory::M('shopcarModel');
				echo "<script>alert('你确定要删除选中的所有项吗？');</script>";
				$ids = implode(',', $ids);
				$data = $obj->delChecked($ids);
				header("location:?c=shopcar&a=showShopCar");
			}
			if( $submit == '结 算' ){
				$ids = implode(',', $ids);
				$obj1 = ModelFactory::M('shoporderModel');
				$addUser = $obj1->showAddUser($_SESSION['userid']);
				$addCheckOrder = $obj1->showAddCheck($ids);
				include VIEW_PATH . 'orders_send.html';
			}
		}
	}
	
	function subNumAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('shopcarModel');
		$data = $obj->subNum($id);
		header("location:?c=shopcar&a=showShopCar");
	}
	
	function addNumAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('shopcarModel');
		$data = $obj->addNum($id);
		header("location:?c=shopcar&a=showShopCar");
	}
}
?>