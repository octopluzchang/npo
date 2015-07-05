<?php 
require_once ("connMysql.php");
session_start();

//檢查是否有經過登入，如有將重新導向至會員中心
if (isset($_SESSION)["loginMember"]) && ($_SESSION["loginMember"] != ""){
	//若帳號等級為member，則導向會員中心
	if ($_SESSION["memberLevel"] == "member") {
		header("Location: profile.php");
	}else{
		header("Location: member_admin.php");
	}
}
//執行會員登入
if (isset($_POST["username"]) && isset($_POST["passwd"])) {
	//連結登入會員資料
	$query_RecLogin = "SELECT * FROM `memberdata` WHERE `m_username` ='" . $_POST["username"] . "'";
	$RecLogin = mysql_query($query_RecLogin);
	//取出帳號及密碼的值
	$row_RecLogin = mysql_fetch_assoc($RecLogin);
	$username = $row_RecLogin["m_username"];
	$passwd = $row_RecLogin["m_passwd"];
	$level = $row_RecLogin["m_level"];
	//比對密碼，若成功則進入登入狀態
	if (md5($_POST["passwd"]) == $passwd) {
		//計算登入次數及更新登入時間
		$query_RecLoginUpdate = "UPDATE `memberdata` SET `m_login` +1, `m_logintime`=NOW() WHERE `m_username`='" . $_POST["username"] . "'";
		mysql_query($query_RecLoginUpdate);
		//設定登入者的名稱及等級
		$_SESSION["loginMember"] = $username;
		$_SESSION["memberLevel"] = $level;
		//使用Cookie紀錄登入資料
		if (isset($_POST["rememberme"]) && ($_POST["rememberme"] == "true")) {
			setcookie("remUser", $_POST["username"], time() + 365 * 24 * 60);
			setcookie("remPass", $_POST["passwd"], time() + 365 * 24 * 60);
		}
		else{
			if (isset($_COOKIE["remUser"])) {
				setcookie("remUser", $_POST["username"], time() - 100);
				setcookie("remPass", $_POST["passwd"], time() - 100);
			}
		}
		//若帳號等級為member，導向會員中心
		if ($_SESSION["memberLevel"] == "member") {
			header("Location: profile.php");
		}
		else{
			header("Location: member_admin.php");
		}
	}
	else{
		header("Location: index.php?errMsg=1");
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <script src="js/jquery-2.1.1.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="stylesheet" href="css/home.css" type="text/css">
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/landing.js"></script>	
</head>
<body>
	<div id="homeNav">
		<div class="wrapper">
			<a href="#landing" id="homeLogo"><span>NPO Lab</span></a>
            <a href="#joinUs"><span>加入我們</span></a>
            <a href="#getSomething"><span>我可以得到什麼</span></a>
            <a href="#doSomething"><span>我可以做什麼</span></a>
            <a href="#about"><span>關於我們</span></a>
        </div>
    </div>
    <div class="section" id="landing">
    	<div class="wrapper">
    		<div class="left">
    			<div class="content">
    				<h1>公益實驗室 NPO Lab</h1>
                    <h3>你的力量，足以改變世界</h3>
                    <a href="#" data-toggle="modal" data-target=".signIn">
                    	<button>登入公益實驗室</button>
                    </a>                	
				</div>
            </div>
            <div class="right">
            	<video autoplay loop poster="polina.jpg" id="bgvid">
            		<source src="polina.webm" type="video/webm">
            		<source src="polina.mp4" type="video/mp4">
            	</video>
            </div>
        </div>
	</div>






<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
		
</body>
</html>