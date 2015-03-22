<?php
header("Content-Type: text/html; charset=utf-8");
include ("connMysql.php");

header("Content-Type: text/html; charset=utf-8");
require_once ("connMysql.php");
session_start();
//檢查是否經過登入，若有登入則重新導向
if (isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"] != "")) {
	//若帳號等級為 member 則導向會員中心
	if ($_SESSION["memberLevel"] == "member") {
		header("Location: member_center.php");
		//否則則導向管理中心
	} else {
		header("Location: member_admin.php");
	}
}
//執行會員登入
if (isset($_POST["username"]) && isset($_POST["passwd"])) {
	//繫結登入會員資料
	$query_RecLogin = "SELECT * FROM `memberdata` WHERE `m_username`='" . $_POST["username"] . "'";
	$RecLogin = mysql_query($query_RecLogin);
	//取出帳號密碼的值
	$row_RecLogin = mysql_fetch_assoc($RecLogin);
	$username = $row_RecLogin["m_username"];
	$passwd = $row_RecLogin["m_passwd"];
	$level = $row_RecLogin["m_level"];
	//比對密碼，若登入成功則呈現登入狀態
	if (md5($_POST["passwd"]) == $passwd) {
		//計算登入次數及更新登入時間
		$query_RecLoginUpdate = "UPDATE `memberdata` SET `m_login`=`m_login`+1, `m_logintime`=NOW() WHERE `m_username`='" . $_POST["username"] . "'";
		mysql_query($query_RecLoginUpdate);
		//設定登入者的名稱及等級
		$_SESSION["loginMember"] = $username;
		$_SESSION["memberLevel"] = $level;
		//使用Cookie記錄登入資料
		if (isset($_POST["rememberme"]) && ($_POST["rememberme"] == "true")) {
			setcookie("remUser", $_POST["username"], time() + 365 * 24 * 60);
			setcookie("remPass", $_POST["passwd"], time() + 365 * 24 * 60);
		} else {
			if (isset($_COOKIE["remUser"])) {
				setcookie("remUser", $_POST["username"], time() - 100);
				setcookie("remPass", $_POST["passwd"], time() - 100);
			}
		}
		//若帳號等級為 member 則導向會員中心
		if ($_SESSION["memberLevel"] == "member") {
			header("Location: member_center.php");
			//否則則導向管理中心
		} else {
			header("Location: member_admin.php");
		}
	} else {
		header("Location: index.php?errMsg=1");
	}
}

//設定字元編碼
mysql_query("SET NAMES UTF8");
$seldb = @mysql_select_db("npo");
if (!$seldb)
	die("Could not find database!");
$sql_query = " SELECT * FROM board WHERE boardsubject LIKE '%" . $_POST["input"] . "%' ";
//OR cEnglish LIKE '%".$_POST["input"]."%'
//OR cJapanese LIKE '%".$_POST["input"]."%' " ;
//測試回傳值是否正確
//echo $sql_query;
$result = mysql_query($sql_query);
if (!$result) {
	echo "Could not successfully run query ($sql_query) from DB: " . mysql_error();
	exit ;
}
if (mysql_num_rows($result) == 0) {
	echo "查無相關資料";
	exit ;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="js/holder.js"></script>

<title>NPO Lab</title>
<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>
<body>
<?php
include ("navbar.php");
?>
<div class="container">

<p align="center"><a href="member_center.php">回首頁</a></p>
	<div class="sexyborder">
	<table class="fancytable" border="1" align="center">
	<!-- 表格表頭 -->
	<tr class="headerrow">
		<th><font color=white>日文</font></th>
		
	</tr>
	<?php while ($row_result = mysql_fetch_assoc($result)) {
	echo "<tr>";
	echo "<td>" . $row_result["boardsubject"] . "</td>";
	echo "</tr>";
	}
	?>
	</table>
	</div>
	
	<?php include("modalProject.php"); ?>
    <?php include("modalFilter.php"); ?>
    <?php include("modalSignup.php"); ?>
    <?php include("modalSignin.php"); ?>
	</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.min.js"></script>
</body>
</html>
