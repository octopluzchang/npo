<?php
header("Content-Type: text/html; charset=utf-8");
require_once ("connMysql.php");

session_start();
//檢查是否經過登入
if (!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"] == "")) {
	header("Location: index.php");
}
//執行登出動作
if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
	unset($_SESSION["loginMember"]);
	unset($_SESSION["memberLevel"]);
	header("Location: index.php");
}
//繫結登入會員資料
$query_RecMember = "SELECT * FROM `memberdata` WHERE `m_username`='" . $_SESSION["loginMember"] . "'";
$RecMember = mysql_query($query_RecMember);
$row_RecMember = mysql_fetch_assoc($RecMember);

//執行專案更新動作
if (isset($_POST["action"]) && ($_POST["action"] == "update")) {
	$query_update = "UPDATE `board` SET ";
	$query_update .= "`boardname`='" . $_POST["boardname"] . "',";
	//$query_update .= "`boardsex`='".$_POST["boardsex"]."',";
	$query_update .= "`boardsubject`='" . $_POST["boardsubject"] . "',";
	$query_update .= "`boardmail`='" . $_POST["boardmail"] . "',";
	$query_update .= "`boardweb`='" . $_POST["boardweb"] . "',";
	$query_update .= "`boardcontent`='" . $_POST["boardcontent"] . "' ";
	$query_update .= "WHERE `boardid`=" . $_POST["boardid"];
	mysql_query($query_update);
	//重新導向回到主畫面
	header("Location: index.php");
}
$query_RecBoard = "SELECT * FROM `board` WHERE `boardid`=" . $_GET["id"];
$RecBoard = mysql_query($query_RecBoard);
$row_RecBoard = mysql_fetch_assoc($RecBoard);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="style.css" rel="stylesheet" type="text/css">
		<!-- Loading Bootstrap -->
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<!-- Loading Flat UI -->
		<link href="css/flat-ui.css" rel="stylesheet">
		<link rel="shortcut icon" href="images/favicon.ico">
		<title>Crack the TERM</title>
</head>
<body>
	
<!--board start-->
	<div class="wrapper">	
  		<div class="main">
  			<div class="content-title">
  				塗鴉牆
  				<hr>
  				修改塗鴉牆
  				<hr>
  			</div>
			<div class="formarea">
				<form name="form1" method="post" action="">          
				<p>
					標題
                </p>
                <p>
                	<input name="boardsubject" type="text" id="boardsubject" class="span3" value="<?php echo $row_RecBoard["boardsubject"]; ?>">
				</p>
                <p>
                	內容
                </p>
              	<p>
                  <textarea name="boardcontent" id="boardcontent" cols="8" rows="8" class="span3"><?php echo $row_RecBoard["boardcontent"]; ?></textarea>
                </p>
                <p>
                  <input name="boardid" type="hidden" id="boardid" value="<?php echo $row_RecBoard["boardid"]; ?>">
                  <input name="action" type="hidden" id="action" value="update">
                  <input type="submit" name="button" id="button" value="更新資料">
                  <input type="button" name="button3" id="button3" value="回上一頁" onClick="window.history.back();">
                </p>
        	</form>
		</div>
	</div>
			

</body>
</html>
