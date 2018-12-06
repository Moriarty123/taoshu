<?php
class userController extends BaseController{
	function regAction(){
		include VIEW_PATH . 'register.html';
	}
	function loginAction(){
		session_start();
		$_SESSION['userurl'] = $_SERVER["HTTP_REFERER"];
		include VIEW_PATH . 'login.html';
	}
	function checkLoginAction(){
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$obj = ModelFactory::M("userModel");
		$result = $obj->CheckLogin($user, $pass);
		if ($result == false) {
			echo "<script>alert('登录失败，用户名或密码不正确'); history.go(-1);</script>";
		}
		else{
			session_start();
			$_SESSION['userid'] = $result['user_id'];
			$_SESSION['userimg'] = $result['user_img'];
			if( $result['user_realname'] != null ){
				$_SESSION['username'] = $result['user_realname'];
			}
			else if($result['nickname'] != null){
				$_SESSION['username'] = $result['nickname'];
			}
			else{
				$_SESSION['username'] = $result['user_name'];
			}
			if($result['login_times'] == 1){
				header("location:?c=user&a=showPersonal&id=".$_SESSION['userid']);
			}
			else if( $_SESSION['userurl'] == null || $_SESSION['userurl'] == 'http://www.taoshujie.com/index.php?c=user&a=reg' ){
				header("location:index.php");
			}
			else{
				header("location:".$_SESSION['userurl']);
			}
		}
	}
	function exitLoginAction(){
		session_start();
		session_destroy();
		header("location:index.php");
	}
	
	function addUserAction(){
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$obj = ModelFactory::M("userModel");
		$result = $obj->addUser($user, $pass);
		if($result){
			include VIEW_PATH . 'login.html';
		}
		else{
			echo "<script>alert('该用户名已被注册！'); history.go(-1);</script>";
		}
	}
	
	function showPersonalAction(){
//		session_start();
		$id = $_GET['id'];
		$obj = ModelFactory::M("userModel");
		$user = $obj->showUser($id);
//		$dept = $obj->getDept();
		$class = $obj->getClass($id);
		include VIEW_PATH . 'personal_center.html';
	}
	
	function updateUserAction(){
		session_start();
		$id = $_SESSION['userid'];
		$nickname = $_POST['nickname'];
		if( !isset($nickname) ){
			$nickname = null;
		}
		$realname = $_POST['realname'];
		$sex = $_POST['sex'];
		$grade = $_POST['grade'];
		$class = $_POST['class'];
		$addr = $_POST['addr'];
		$tel = $_POST['tel'];
		$content = $_POST['content'];
		if( !isset($content) ){
			$content = null;
		}
		$obj = ModelFactory::M("userModel");
		$upatePwd = $obj->updateUser($id, $nickname, $realname, $sex, $grade, $class, $tel, $addr, nl2br($content));
		echo "<script>alert('修改成功！'); window.location.href = '?c=user&a=showPersonal&id=$id';</script>";
	}
	
	function updateImgAction(){
		session_start();
		$id = $_SESSION['userid'];
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
					$_SESSION['userimg'] =  $img_name;
					$obj = ModelFactory::M("userModel");
					$upateImg = $obj->updateImg($id, $img_name);
					echo "<script>alert('修改成功！'); window.location.href = '?c=user&a=showPersonal&id=$id';</script>";
				}
				else{
				    echo "<script>alert('上传图片失败！'); history.go(-1);</script>";
				}
			}
			else{ 
				echo "<script>alert('不是图片类型！'); history.go(-1);</script>";
			}
		}
	}
	
	function showUpdatePwdAction(){
		include VIEW_PATH . 'personal_updatePwd.html';
	}
	
	function updatePwdAction(){
		session_start();
		$id = $_SESSION['userid'];
		$prePwd = $_POST['prepwd'];
		$newPwd = $_POST['newPwd'];
		$obj = ModelFactory::M("userModel");
		$upatePwd = $obj->updatePwd($id, $prePwd, $newPwd);
		if($upatePwd){
			session_destroy();
			header("location:index.php");
		}
		else{
			echo "<script>alert('原始密码错误！'); history.go(-1);</script>";
		}
	}
	
	function showSaleUserAction(){
		session_start();
		//做判断,如果没有登录,跳转到登录页面  
        if( !isset($_SESSION['username']) || $_SESSION['username'] == '' ){  
           	header("location:?c=user&a=login");
        } 
        else{
			$user_id = $_GET['id'];
			$obj = ModelFactory::M("userModel");
			$saleUser = $obj->GetSaleUser($user_id);
			$saleUserBook = $obj->GetSaleUserBook($user_id);
			$inquiryUserBook = $obj->GetInquiryUserBook($user_id);
			include VIEW_PATH . 'personal_salecenter.html';
		}
	}
}
?>