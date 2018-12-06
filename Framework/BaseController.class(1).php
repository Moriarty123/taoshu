<?php
class BaseController{
	function __construct(){
		header("content-type:text/html; charset=utf-8");
	}
	//显示一定的简短提示文字，然后自动跳转（可以设定停留的时间秒数）
	function GoToUrl($msg, $url, $time=3){  //停留的时间默认为3秒
		echo "<font color=red>$msg</font>";
		echo "<br><a href='$url'>返回</a>";
		echo "页面将在{$time}秒之后自动跳转...</a>";
		header("refresh: $time; url=$url"); //自动定时跳转
	}
}
?>