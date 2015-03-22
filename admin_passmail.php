<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");
session_start();
//函式：自動產生指定長度的密碼
function MakePass($length) { 
	$possible = "0123456789!@#$%^&*()_+abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
	$str = ""; 
	while(strlen($str)<$length){ 
	  $str .= substr($possible, rand(0, strlen($possible)), 1); 
	}
	return($str); 
}
//檢查是否經過登入，若有登入則重新導向
if(isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"]!="")){
	//若帳號等級為 member 則導向會員中心
	if($_SESSION["memberLevel"]=="member"){
		header("Location: member_center.php");
	//否則則導向管理中心
	}else{
		header("Location: member_admin.php");	
	}
}
//檢查是否為會員
if(isset($_POST["m_username"])){	
	//找尋該會員資料
	$query_RecFindUser = "SELECT * FROM `memberdata` WHERE `m_username`='".$_POST["m_username"]."'";
	$RecFindUser = mysql_query($query_RecFindUser);
	if (mysql_num_rows($RecFindUser)==0){
		header("Location: admin_passmail.php?errMsg=1&username=".$_POST["m_username"]);
	}
	//取出帳號密碼的值
	$row_RecFindUser=mysql_fetch_assoc($RecFindUser);
	$username = $row_RecFindUser["m_username"];
	$usermail = $row_RecFindUser["m_email"];	
	//產生新密碼並更新
	$newpasswd = MakePass(10);
	$query_update = "UPDATE `memberdata` SET `m_passwd`='".md5($newpasswd)."' WHERE `m_username`='".$username."'";
	mysql_query($query_update);
	//補寄密碼信
	$mailcontent ="您好，<br />您的帳號為：$username <br/>您的新密碼為：$newpasswd <br/>";
	$mailFrom="=?UTF-8?B?" . base64_encode("會員管理系統") . "?= <service@e-happy.com.tw>";
	$mailto=$usermail;
	$mailSubject="=?UTF-8?B?" . base64_encode("補寄密碼信"). "?=";
	$mailHeader="From:".$mailFrom."\r\n";
	$mailHeader.="Content-type:text/html;charset=UTF-8";
	mail($mailto,$mailSubject,$mailcontent,$mailHeader);	
	header("Location: admin_passmail.php?mailStats=1");		
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>網站會員系統</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php if(isset($_GET["mailStats"]) && ($_GET["mailStats"]=="1")){?>
<script>
alert('密碼信補寄成功！');
window.location.href='index.php';		  
</script>
<?php }?>

<div class="regbox">
          <?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"]=="1")){?>
          <div class="errDiv">帳號「 <strong><?php echo $_GET["username"];?></strong> 
            」
            沒有人使用！</div>
          <?php }?>
          <p class="heading">忘記密碼？</p>
          <form name="form1" method="post" action="">
            <p>請輸入您申請的帳號，系統將自動產生一個十位數的密碼寄到您註冊的信箱。</p>
            <p><strong>帳號</strong>：
              <br>
              <input name="m_username" type="text" class="logintextbox" id="m_mail">
            </p>
            <p>
              <input type="submit" name="button" id="button" value="寄密碼信">
              <input type="button" name="button2" id="button2" value="回上一頁" onClick="window.history.back();">
            </p>
            </form>
          <hr size="1" />
          <p class="heading">還沒有會員帳號?</p>
          <p>註冊帳號免費又容易</p>
          <p ><a href="member_join.php">馬上申請會員</a></p>
</div>
        
</body>
</html>
