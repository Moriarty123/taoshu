<?php
class adminController extends BaseController{
	function loginAction(){
		include VIEW_PATH . 'login.html';
	}
	
	function checkLoginAction(){
		session_start();
		$user = $_POST['name'];
		$pwd = $_POST['pwd'];
		$obj = ModelFactory::M('adminModel');
		$admin = $obj->GetAdmin($user, $pwd);
		$_SESSION['last_time'] = $admin['last_time'];
		$_SESSION['admin_id'] = $admin['id'];
		$_SESSION['admin_name'] = $admin['name'];
		$result = $obj->CheckLogin($user, $pwd);
		if ($result == true) {
			header("location:?p=back&c=admin");
		}
		else{
			//失败了就是提示，并可以自动跳转到扥估界面
			echo "<script>alert('登录失败，用户名或密码不正确'); history.go(-1);</script>";
		}
	}
	
	function indexAction(){
		session_start();
		$obj = ModelFactory::M('adminModel');
		$times = $obj->GetTimes($_SESSION['admin_id']);
		include VIEW_PATH . 'index.html';
	}
	
	function exitLoginAction(){	// 安全退出
		session_start();
		session_destroy();
		header("location:?p=back&c=admin&a=login");
	}
	
	
	function pwdAction(){
		include VIEW_PATH . 'updateAdminPwd.html';
	}
	
	function updatePwdAction(){
		session_start();
		$pre = $_POST['prepwd'];
		$pwd = $_POST['pwd'];
		$obj = ModelFactory::M('adminModel');
		$update = $obj->UpdatePwd($pre, $pwd, $_SESSION['admin_id']);
		if($update){
			session_destroy();
			echo "<script>alert('修改成功，请重新登录！'); window.location.href = '?p=back&c=admin&a=login';</script>";
		}
		else{
			echo "<script>alert('原始密码错误！'); history.go(-1);</script>";
		}
	}
	
	function addAction(){
		include VIEW_PATH . 'addAdmin.html';
	}
	
	function addAdminAction(){
		$name = $_POST['name'];
		$pwd = $_POST['pwd'];
		$obj = ModelFactory::M('adminModel');
		$add = $obj->AddAdmin($name, $pwd);
		if($add == false){
			echo "<script>alert('该用户名已存在！'); history.go(-1);</script>";
		}
		else{
			echo "<script>alert('添加成功！'); window.location.href = '?p=back&c=admin';</script>";
		}
	}
}
?>