<?php
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
?>
<?php
//專案資料取出開始
//預設每頁筆數
$board_pageRow_records = 20;
//預設頁數
$board_num_pages = 1;
//若已經有翻頁，將頁數更新
if (isset($_GET['page'])) {
	$board_num_pages = $_GET['page'];
}
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$board_startRow_records = ($board_num_pages - 1) * $board_pageRow_records;
//未加限制顯示筆數的SQL敘述句
$board_query_RecBoard = "SELECT * FROM `board` ORDER BY `boardtime` DESC";
//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
$board_query_limit_RecBoard = $board_query_RecBoard . " LIMIT " . $board_startRow_records . ", " . $board_pageRow_records;
//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecBoard 中
$board_RecBoard = mysql_query($board_query_limit_RecBoard);
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecBoard 中
$board_all_RecBoard = mysql_query($board_query_RecBoard);
//計算總筆數
$board_total_records = mysql_num_rows($board_all_RecBoard);
//計算總頁數=(總筆數/每頁筆數)後無條件進位。
$board_total_pages = ceil($board_total_records / $board_pageRow_records);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<link href="style.css" rel="stylesheet" type="text/css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="js/holder.js"></script>
		<script>
		$.getScript('//cdn.jsdelivr.net/isotope/1.5.25/jquery.isotope.min.js',function(){
		/* activate jquery isotope */
		$('#posts').imagesLoaded( function(){
		$('#posts').isotope({
		itemSelector : '.item'
		});
		});
		
		});
		</script>
		<script language="javascript">
				function checkForm() {
						if (document.search.input.value == "") {
							alert("請填寫搜尋欄!");
							document.search.input.focus();
							return false;
						}
					}
		</script>
		<style>
		*, *:before, *:after {box-sizing:  border-box !important;}
		.row {
		-moz-column-width: 25em;
		-webkit-column-width: 25em;
		-moz-column-gap: .5em;
		-webkit-column-gap: .5em;
		
		}
		.panel {
		display: inline-block;
		margin:  .5em;
		padding:  0;
		width:98%;
		}
		/* Isotope Transitions
		------------------------------- */
		.isotope,
		.isotope .item {
		-webkit-transition-duration: 0.8s;
		-moz-transition-duration: 0.8s;
		-ms-transition-duration: 0.8s;
		-o-transition-duration: 0.8s;
		transition-duration: 0.8s;
		}
		.isotope {
		-webkit-transition-property: height, width;
		-moz-transition-property: height, width;
		-ms-transition-property: height, width;
		-o-transition-property: height, width;
		transition-property: height, width;
		}
		.isotope .item {
		-webkit-transition-property: -webkit-transform, opacity;
		-moz-transition-property:    -moz-transform, opacity;
		-ms-transition-property:     -ms-transform, opacity;
		-o-transition-property:         top, left, opacity;
		transition-property:         transform, opacity;
		}
		
		
		/* responsive media queries */
		@media (max-width: 992px) {
		header h1 small {
		display: block;
		}
		header div.description {
		padding-top: 9px;
		padding-bottom: 4px;
		}
		.isotope .item {
		position: static ! important;
		-webkit-transform: translate(0px, 0px) ! important;
		-moz-transform: translate(0px, 0px) ! important;
		transform: translate(0px, 0px) ! important;
		}
		}
		</style>
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
		<?php include("navbar.php");?>
		<div class="container">
			<?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"]=="1")){?>
			<div class="errDiv">
				<h3 align="center"><font color="red">登入帳號或密碼錯誤！</font></h3>
			</div>
			<?php } ?>
			<!--<p>資料筆數：<?php echo $board_total_records; ?></p>-->
			<div class="row">
				<?php while($board_row_RecBoard=mysql_fetch_assoc($board_RecBoard)){ ?>
					<!-- Single Project-->
					<?php include("singleProject.php");?>
					<!-- Single Project-->
				<?php } ?>
			</div>
			<?php include("modalFilter.php"); ?>
			<?php include("modalSignup.php"); ?>
			<?php include("modalSignin.php"); ?>
			<div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			</div>
		</div>
		
		<?php include("chat.php"); ?>
		

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
		
	</body>
</html>