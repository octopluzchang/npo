<?php
header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");

session_start();
//檢查是否經過登入
if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: index.php");
}
//執行登出動作
if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
	unset($_SESSION["loginMember"]);
	unset($_SESSION["memberLevel"]);
	header("Location: index.php");
}
//繫結登入會員資料
$query_RecMember = "SELECT * FROM `memberdata` WHERE `m_username`='".$_SESSION["loginMember"]."'";
$RecMember = mysql_query($query_RecMember);	
$row_RecMember=mysql_fetch_assoc($RecMember);

//執行刪除動作
if(isset($_POST["action"])&&($_POST["action"]=="delete")){	
	$sql_query = "DELETE FROM `board` WHERE `boardid`=".$_POST["boardid"];	
	mysql_query($sql_query);
	//重新導向回到主畫面
	header("Location: member_center.php");
}
$query_RecBoard = "SELECT * FROM `board` WHERE `boardid`=".$_GET["id"];
$RecBoard = mysql_query($query_RecBoard);
$row_RecBoard=mysql_fetch_assoc($RecBoard);
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
  				刪除塗鴉牆
            <hr>
            </div>
            <div class="formarea">
            	<form name="form1" method="post" action="">
            		<div class="boardtopic">
            		<h3>標題：</h3>
            		</div>
  					<br>
            			<?php echo $row_RecBoard["boardsubject"];?>
            		<br>
            		<br>
                	<div class="boardtopic">
            		<h3>塗鴉內容:</h3>
            		</div>
            		<br>
            		<?php echo nl2br($row_RecBoard["boardcontent"]);?>
            		<br>
            		<br>
                  	<input name="boardid" type="hidden" id="boardid" value="<?php echo $row_RecBoard["boardid"];?>">
                  	<input name="action" type="hidden" id="action" value="delete">
                  	<input type="submit" name="button" id="button" value="確定刪除資料">
                  	<input type="button" name="button3" id="button3" value="回上一頁" onClick="window.history.back();">
        		</form>
			</div>
		</div>
		
s
</body>
</html>

