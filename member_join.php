<?php
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

if (isset($_POST["action"]) && ($_POST["action"] == "join")) {
	//找尋帳號是否已經註冊
	$query_RecFindUser = "SELECT `m_username` FROM `memberdata` WHERE `m_username`='" . $_POST["m_username"] . "'";
	$RecFindUser = mysql_query($query_RecFindUser);
	if (mysql_num_rows($RecFindUser) > 0) {
		header("Location: member_join.php?errMsg=1&username=" . $_POST["m_username"]);
	} else {
		//若沒有執行新增的動作
		$query_insert = "INSERT INTO `memberdata` (`m_name` ,`m_username` ,`m_passwd` ,`m_sex` ,`m_skill` ,`m_birthday` ,`m_phone`,`m_address`, `m_academic`, `m_description`, `m_jointime`) VALUES (";
		$query_insert .= "'" . $_POST["m_name"] . "',";
		$query_insert .= "'" . $_POST["m_username"] . "',";
		$query_insert .= "'" . md5($_POST["m_passwd"]) . "',";
		$query_insert .= "'" . $_POST["m_sex"] . "',";
		//$query_insert .= "'" . $_POST["m_profilepic"] . "',";
		$query_insert .= "'" . $_POST["m_skill"] . "',";
		$query_insert .= "'" . $_POST["m_birthday"] . "',";
		$query_insert .= "'" . $_POST["m_phone"] . "',";
		$query_insert .= "'" . $_POST["m_address"] . "',";
		$query_insert .= "'" . $_POST["m_academic"] . "',";
		$query_insert .= "'" . $_POST["m_description"] . "',";
		$query_insert .= "NOW())";
		//echo $query_insert;
		mysql_query($query_insert);
		header("Location: member_join.php?loginStats=1");
	}
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
		<script language="javascript">
			function checkForm() {
				if (document.formJoin.m_username.value == "") {
					alert("請填寫電子郵件!");
					document.formJoin.m_username.focus();
					return false;
				}
				if (!check_passwd(document.formJoin.m_passwd.value, document.formJoin.m_passwdrecheck.value)) {
					document.formJoin.m_passwd.focus();
					return false;
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
				if (!checkmail(document.formJoin.m_username)) {
					document.formJoin.m_username.focus();
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
	</head>
	<body>
		<?php if(isset($_GET["loginStats"]) && ($_GET["loginStats"]=="1")){
		?>
		<script language="javascript">
			alert('會員新增成功\n請用申請的帳號密碼登入。');
			window.location.href = 'index.php';
		</script>
		<?php } ?>

		<?php include ("navbar.php");?>
		<?php include ("modalSignin.php");?>
		<?php include ("modalSignup.php");?>

		<div class="container">
			<form action="" method="POST" name="formJoin" id="formJoin" onSubmit="return checkForm();">
				<h3> 加入會員 </h3>
				<?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"]=="1")){
				?>
				<div class="errDiv"><font color="red">
					帳號 <?php echo $_GET["username"]; ?> 已經有人使用！</font>
				</div>
				<?php } ?>
				<div class="dataDiv">
					<hr size="1" />
					<p class="heading">
						帳號資料
					</p>
					<p>
						<strong>電子郵件</strong>：
						<input name="m_username" type="text" class="" id="m_username">
						<font color="#FF0000">*</font>
						<br>
						<span class="smalltext">請填入您的電子郵件信箱</span>
					</p>

					<p>
						<strong>使用密碼</strong>：
						<input name="m_passwd" type="password" class="" id="m_passwd">
						<font color="#FF0000">*</font>
						<br>
						<span class="smalltext">請填入5~10個字元以內的英文字母、數字、以及各種符號組合，</span>
					</p>
					<p>
						<strong>確認密碼</strong>：
						<input name="m_passwdrecheck" type="password" class="" id="m_passwdrecheck">
						<font color="#FF0000">*</font>
						<br>
						<span class="smalltext">請再輸入一次密碼</span>
					</p>
					<hr size="1" />
					<p>
						個人資料
					</p>
					<p>
						<strong>姓　　名</strong>：
						<input name="m_name" type="text" class="normalinput" id="m_name">
						<font color="#FF0000">*</font>
					</p>
					<p>
						<strong>性　　別</strong>：
						<input name="m_sex" type="radio" value="女" checked>
						女
						<input name="m_sex" type="radio" value="男">
						男 <font color="#FF0000">*</font>
					</p>
					<p>
						<strong>生　　日</strong>：
						<input name="m_birthday" type="date" class="normalinput" id="m_birthday">
						<font color="#FF0000">*</font>
						<br>
						<span class="smalltext">為西元格式(YYYY-MM-DD)。</span>
					</p>
					<p>
						<strong>電　　話</strong>：
						<input name="m_phone" type="text" class="normalinput" id="m_phone">
					</p>
					<p>
						<strong>住　　址</strong>：
						<input name="m_address" type="text" class="normalinput" id="m_address" size="50">
					</p>
					<hr size="1" />
					<p>
						專業資料
					</p>
					<p>
						<strong>技　　能</strong>：
						<input name="m_skill" type="text" class="" id="m_skill">
					</p>
					<p>
						<strong>學　　歷</strong>：
						<input name="m_academic" type="text" class="" id="m_academic">
					</p>
					<p>
						<strong>自　　介</strong>：
						<textarea name="m_description" type="text" class="normalinput" id="m_description" rows="4" cols="40"></textarea>
					</p>

					
					<hr size="1" />
					<p>
						<font color="#FF0000">*</font> 表示為必填的欄位
					</p>
				</div>
				<hr size="1" />
				<p>
					<input name="action" type="hidden" id="action" value="join">
					<input type="submit" name="Submit2" class="btn btn-primary" value="送出申請">
					<input type="reset" name="Submit3" class="btn btn-default" value="重設資料">
					<input type="button" name="Submit" class="btn btn-default" value="回上一頁" onClick="window.history.back();">
				</p>
			</form>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>

	</body>
</html>
