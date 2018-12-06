<?php
class userController extends BaseController{
	function showUserAction(){
		$obj = ModelFactory::M('userModel');
		$user = $obj->GetUser();
		
		/** 1.传入页面 **/
		if( !empty($_GET['page']) ){
		 	$page = $_GET['page'];
		}
		else{
			$page = 1;
		}
		$PageSize = 15;	// 每页显示的条数
	 	$ShowPage = 3;	// 显示多少个页数的数字
		
		$to = $obj->GetUserPage();	// 获取的行数
		$to_pages = ceil($to / $PageSize);	// 页数
		$page_banner = "";
 		//计算偏移量
 		$pageffset = ($ShowPage - 1) / 2;
 		if( $page > 1 ){
		 	$page_banner .= "<a href='?p=back&c=user&a=showUser&page=1'>首页</a>";
		 	$page_banner .= "<a href='?p=back&c=user&a=showUser&page=".($page-1)."'>上一页</a>";
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
			$page_banner .= "<a href='?p=back&c=user&a=showUser&page=".($i)."'>{$i}</a>";
		}
		//尾部省略
		if ( $to_pages > $ShowPage && $to_pages > $page + $pageffset){
			$page_banner .= "...";
		}
		if ( $page < $to_pages ){
			$page_banner .= "<a href='?p=back&c=user&a=showUser&page=".($page+1)."'>下一页</a>";
			$page_banner .= "<a href='?p=back&c=user&a=showUser&page=".($to_pages)."'>尾页</a>";
		}
		$page_banner .= "共{$to_pages}页";
	
		include VIEW_PATH . 'user.html';
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
		$obj = ModelFactory::M('userModel');
		$user = $obj->GetSearch($keyword);
		
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
		 	$page_banner .= "<a href='?p=back&c=user&a=search&page=1'>首页</a>";
		 	$page_banner .= "<a href='?p=back&c=user&a=search&page=".($page-1)."'>上一页</a>";
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
			$page_banner .= "<a href='?p=back&c=user&a=search&page=".($i)."'>{$i}</a>";
		}
		//尾部省略
		if ( $to_pages > $ShowPage && $to_pages > $page + $pageffset){
			$page_banner .= "...";
		}
		if ( $page < $to_pages ){
			$page_banner .= "<a href='?p=back&c=user&a=search&page=".($page+1)."'>下一页</a>";
			$page_banner .= "<a href='?p=back&c=user&a=search&page=".($to_pages)."'>尾页</a>";
		}
		$page_banner .= "共{$to_pages}页";
	
		include VIEW_PATH . 'user.html';
	}
	
	function addAction(){	// 显示添加用户页面
		$obj = ModelFactory::M('userModel');
		$class = $obj->GetClass();
		include VIEW_PATH . 'addUser.html';
	}
	
	function addUserAction(){	// 添加用户 
		$user = $_POST['name'];
		$pwd = $_POST['pwd'];
		$sex = $_POST['sex'];
		$realname = $_POST['realname'];
		$grade = $_POST['grade'];
		$class = $_POST['class'];
		$addr = $_POST['addr'];
		$tel = $_POST['tel'];
		$content = $_POST['content'];
		
		$obj = ModelFactory::M('userModel');
		$userResult = $obj->AddUser($user, $pwd, $sex, $realname, $grade, $class, $addr, $tel, nl2br($content));
		if( $userResult == false ){
			echo "<script>alert('该用户名已存在！'); history.go(-1);</script>";
		}
		else{
			// 处理图片e
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
						$addImg = $obj->addImg($user, $pwd, $img_name);
						echo "<script>alert('添加成功！'); window.location.href = '?p=back&c=user&a=showUser';</script>";
					}
					else{
						echo "<script>alert('上传失败！'); window.location.href = '?p=back&c=user&a=showUser';</script>";
					}
				}
				else{ 
					echo "<script>alert('添加成功！'); window.location.href = '?p=back&c=user&a=showUser';</script>";
				}
			}
			// 处理图片结束
		}
	}
	
	function pwdAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('userModel');
		$user = $obj->GetName($id);
		include VIEW_PATH . 'updateUserPwd.html';
	}
	
	function updatePwdAction(){
		$id = $_POST['id'];
		$pwd = $_POST['pwd'];
		$obj = ModelFactory::M('userModel');
		$user = $obj->UpdatePwd($pwd, $id);
		if($user){
			echo "<script>alert('修改成功！'); window.location.href = '?p=back&c=user&a=showUser';</script>";
		}
	}
	
	function delAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('userModel');
		$delete = $obj->Delete($id);
		if($delete){
			echo "<script>alert('删除成功！'); window.location.href = '?p=back&c=user&a=showUser';</script>";
		}
	}
	
	function delCheckAction(){
		$ids = $_POST['ids'];
		$obj = ModelFactory::M('userModel');
//		echo "<script>alert('你确认要删除选中的用户、包括用户的所有书籍和订单信息吗？');</script>";
		$ids = implode(',', $ids);
		$data = $obj->delChecked($ids);
		if($data){
			echo "<script>alert('删除成功！'); window.location.href = '?p=back&c=user&a=showUser';</script>";
		}
	}
	
	function editAction(){
		$id = $_GET['id'];
		$obj = ModelFactory::M('userModel');
		$edit = $obj->Edit($id);
		$class = $obj->GetClass();
		include VIEW_PATH . 'editUser.html';
	}
	
	function editUserAction(){
		$id = $_POST['id'];
		$user = $_POST['name'];
		$sex = $_POST['sex'];
		$realname = $_POST['realname'];
		$grade = $_POST['grade'];
		$class = $_POST['class'];
		$addr = $_POST['addr'];
		$tel = $_POST['tel'];
		$content = $_POST['content'];
		
		$obj = ModelFactory::M('userModel');
		$editResult = $obj->EditUser($user, $sex, $realname, $grade, $class, $addr, $tel, nl2br($content), $id);
		if($editResult == false){
			echo "<script>alert('该用户名已存在！'); history.go(-1);</script>";
		}
		else{
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
						$updateImg = $obj->updateImg($id, $img_name);
						echo "<script>alert('修改成功！'); window.location.href = '?p=back&c=user&a=showUser';</script>";
					}
					else{
						echo "<script>alert('图片上传失败！'); window.location.href = '?p=back&c=user&a=showUser';</script>";
					}
				}
				else{ 
					echo "<script>alert('修改成功！'); window.location.href = '?p=back&c=user&a=showUser';</script>";
				}
				// 处理图片结束
			}
		}
	}
}
?>