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
//重新導向頁面
$redirectUrl = "member_center.php";

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `memberdata` WHERE `m_username`='" . $_SESSION["loginMember"] . "'";
$RecMember = mysql_query($query_RecMember);
$row_RecMember = mysql_fetch_assoc($RecMember);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="js/holder.js"></script>
<script language="javascript">
	function checkForm() {
		if (document.formJoin.m_passwd.value != "" || document.formJoin.m_passwdrecheck.value != "") {
			if (!check_passwd(document.formJoin.m_passwd.value, document.formJoin.m_passwdrecheck.value)) {
				document.formJoin.m_passwd.focus();
				return false;
			}
		}
		if (document.formJoin.m_name.value == "") {
			alert("請填寫姓名!");
			document.formJoin.m_name.focus();
			return false;
		}
		if (document.formJoin.m_birthday.value == "") {
			alert("請填寫生日!");
			document.formJoin.m_birthday.focus();
			return false;
		}
		if (document.formJoin.m_email.value == "") {
			alert("請填寫電子郵件!");
			document.formJoin.m_email.focus();
			return false;
		}
		if (!checkmail(document.formJoin.m_email)) {
			document.formJoin.m_email.focus();
			return false;
		}
		return confirm('確定送出嗎？');
	}

	function check_passwd(pw1, pw2) {
		if (pw1 == '') {
			alert("密碼不可以空白!");
			return false;
		}
		for (var idx = 0; idx < pw1.length; idx++) {
			if (pw1.charAt(idx) == ' ' || pw1.charAt(idx) == '\"') {
				alert("密碼不可以含有空白或雙引號 !\n");
				return false;
			}
			if (pw1.length < 5 || pw1.length > 10) {
				alert("密碼長度只能5到10個字母 !\n");
				return false;
			}
			if (pw1 != pw2) {
				alert("密碼二次輸入不一樣,請重新輸入 !\n");
				return false;
			}
		}
		return true;
	}

	function checkmail(myEmail) {
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (filter.test(myEmail.value)) {
			return true;
		}
		alert("電子郵件格式不正確");
		return false;
	}
    </script>
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
	<?php include ("navbar_login.php");?>
    <div class="container">
  		<div class="row">
    		<div class="col-md-4"></div>
      			<div class="col-md-4 text-center"><img data-src="holder.js/40x40/text:K" class="img-circle"><h1><?php echo $row_RecMember["m_name"]; ?></h1></div>
      				<div class="col-md-4">
                     <button class="btn btn-default pull-right" type="submit" data-toggle="modal" data-target="#editprofileModal">編輯個人檔案</button>
                    </div>
    	</div>
 
    	<ul class="nav nav-tabs text-center">
      		<li role="presentation" class="active"><a href="#">已完成的專案</a></li>
      		<li role="presentation" ><a href="#">正在進行的專案</a></li>
        	<li role="presentation" ><a href="#">追蹤中的專案</a></li>
 		</ul>		
   		<div class="row">
   		 	<div class="col-sm-6 col-md-4">
<!-- Single Project-->

		<?php include ("singleProject.php");?>

<!-- Single Project-->

<!-- Project Modal -->
		
		<?php include("modalProject.php");?>

<!-- Filter Modal -->
		<?php include("modalFilter.php");?>
        <?php include("modalEditprofile.php");?>
        	</div>
    	</div>
      
    </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.min.js"></script>
</body>
</html>
