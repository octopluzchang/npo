<?php
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
$redirectUrl = "profile.php";

//執行更新動作
if (isset($_POST["action"]) && ($_POST["action"] == "update")) {
	$query_update = "UPDATE `memberdata` SET ";
	//若有修改密碼，則更新密碼。
	if (($_POST["m_passwd"] != "") && ($_POST["m_passwd"] == $_POST["m_passwdrecheck"])) {
		$query_update .= "`m_passwd`='" . md5($_POST["m_passwd"]) . "',";
	}
	$query_update .= "`m_name`='" . $_POST["m_name"] . "',";
	$query_update .= "`m_sex`='" . $_POST["m_sex"] . "',";
	$query_update .= "`m_skill`='" . $_POST["m_skill"] . "',";
	$query_update .= "`m_birthday`='" . $_POST["m_birthday"] . "',";
	//$query_update .= "`m_url`='" . $_POST["m_url"] . "',";
	$query_update .= "`m_phone`='" . $_POST["m_phone"] . "',";
	$query_update .= "`m_address`='" . $_POST["m_address"] . "', ";
	$query_update .= "`m_academic`='" . $_POST["m_academic"] . "', ";
	$query_update .= "`m_description`='" . $_POST["m_description"] . "' ";
	$query_update .= "WHERE `m_id`=" . $_POST["m_id"];
	mysql_query($query_update);
	//echo $query_update;

	if ($_FILES["m_profilepic"]["error"] > 0) {
		//echo "Error: " . $_FILES["m_profilepic"]["error"];
	} else {
		//echo "檔案名稱: " . $_FILES["m_profilepic"]["name"] . "<br/>";
		//echo "檔案類型: " . $_FILES["m_profilepic"]["type"] . "<br/>";
		//echo "檔案大小: " . ($_FILES["m_profilepic"]["size"] / 1024) . " Kb<br />";
		//echo "暫存名稱: " . $_FILES["m_profilepic"]["tmp_name"];
		move_uploaded_file($_FILES["m_profilepic"]["tmp_name"], "profilepic/" . $_FILES["m_profilepic"]["name"]);
		$path = $_FILES["m_profilepic"]["name"];
		$query_update = "UPDATE memberdata SET m_profilepic = '" . $path . "' WHERE `m_id`=" . $_POST["m_id"];
		//echo $query_update;
		mysql_query($query_update);
	}
	//若有修改密碼，則登出回到首頁。
	if (($_POST["m_passwd"] != "") && ($_POST["m_passwd"] == $_POST["m_passwdrecheck"])) {
		unset($_SESSION["loginMember"]);
		unset($_SESSION["memberLevel"]);
		$redirectUrl = "index.php";
	}
	//重新導向
	//header("Location: $redirectUrl");

}

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `memberdata` WHERE `m_username`='" . $_SESSION["loginMember"] . "'";
$RecMember = mysql_query($query_RecMember);
$row_RecMember = mysql_fetch_assoc($RecMember);
	
//建立搜尋SQL字串
$sql_query = " SELECT * FROM board WHERE username='" . $_SESSION["loginMember"] . "'";
//echo $sql_query;
$result = mysql_query($sql_query);

//預設每頁筆數
$board_pageRow_records = 5;
//預設頁數
$board_num_pages = 1;
//若已經有翻頁，將頁數更新
if (isset($_GET['page'])) {
	$board_num_pages = $_GET['page'];
}
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$board_startRow_records = ($board_num_pages - 1) * $board_pageRow_records;
//未加限制顯示筆數的SQL敘述句
$board_query_RecBoard = "SELECT * FROM `board` WHERE username ='" . $_SESSION["loginMember"] . "' ORDER BY `boardtime` DESC";
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
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="js/holder.js"></script>
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
    <script language="javascript">
    function checkForm() {
        if (document.search.input.value == "") {
          alert("請填寫搜尋欄!");
          document.search.input.focus();
          return false;
        }
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
      			<div class="col-md-4 text-center"><img data-src="holder.js/40x40/text:K" class="img-circle" height="100px" width="100px" src="profilepic/<?php echo $row_RecMember["m_profilepic"]; ?>">
      				<h1><?php echo $row_RecMember["m_name"]; ?></h1></div>
      				<div class="col-md-4">
      				<button class="btn btn-default pull-right" type="submit" data-toggle="modal" data-target="#boardPost">張貼新專案</button>
                     <button class="btn btn-default pull-right" type="submit" data-toggle="modal" data-target="#editprofileModal">編輯個人檔案</button>
                    </div>
    	</div>

<!--自己張貼的專宴的修改及刪除-->
    	<ul class="nav nav-tabs text-center">
      		<li role="presentation" class="active"><a href="#">自己張貼的專案</a>

<?php while($board_row_RecBoard=mysql_fetch_assoc($board_RecBoard)){ ?>
		
		
		
 		<a href="board_update.php?id=<?php echo $board_row_RecBoard["boardid"]; ?>">[修改]</a>

			<?php include("modalEditPost.php"); ?>

			<?php } ?>
			<div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div>

      		</li>
      		<li role="presentation" ><a href="#">正在進行的專案</a></li>
        	<li role="presentation" ><a href="#">追蹤中的專案</a></li>
 		</ul>


 		<!-- modalEditprofile.php -->
        <!-- Project Modal -->
<div class="modal fade" id="editPost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>

<div class="content-title">
  				自己張貼的專案
  				<hr>
  			</div>
			<div class="formarea">
				<form name="form1" method="post" action="">          
				<p>
					標題
                </p>
                <p>
                	<input name="boardsubject" type="text" id="boardsubject" class="span3" value="<?php echo $result["boardsubject"]; ?>">
				</p>
                <p>
                	內容
                </p>
              	<p>
                  <textarea name="boardcontent" id="boardcontent" cols="8" rows="8" class="span3"><?php echo $result["boardcontent"]; ?></textarea>
                </p>
                <p>
                  <input name="boardid" type="hidden" id="boardid" value="<?php echo $result["boardid"]; ?>">
                  <input name="action" type="hidden" id="action" value="update">
                  <input type="submit" name="button" id="button" value="更新資料">
                  <input type="button" name="button3" id="button3" value="回上一頁" onClick="window.history.back();">
                </p>
        	</form>
		</div>


			</div>
		</div>
	</div>
</div>
   		
		
<!-- modalEditprofile.php -->
        <!-- Project Modal -->
<div class="modal fade" id="editprofileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">編輯個人資料</h4>
			</div>
			<div class="modal-body">
				<div class="formarea">
					<form action="" method="POST" enctype="multipart/form-data" name="formJoin" id="formJoin" onSubmit="return checkForm();">
						<div class="boardtopic">
							<p>
								肖像照片：
							</p>
							<input type="file" name="m_profilepic" id="m_profilepic" />
							<p>

								<h4> 帳號資料 </h4>
						</div>
						<br>
						<p>
							使用帳號：<?php echo $row_RecMember["m_username"]; ?>
						</p>
						<p>
							更新密碼：
							<input name="m_passwd" type="password" class="normalinput" id="m_passwd">
							<br>
						</p>
						<p>
							確認密碼：
							<input name="m_passwdrecheck" type="password" class="normalinput" id="m_passwdrecheck">
							<br>
							若不修改密碼，請不要填寫。若要修改，請輸入密碼二次。
							<br>
							若修改密碼，系統會自動登出，請用新密碼登入。
						</p>
						<hr>
						<div class="boardtopic">
							<h4> 個人資料 </h4>
						</div>
						<br>
						<p>
							姓　　名：
							<input name="m_name" type="text" class="normalinput" id="m_name" value="<?php echo $row_RecMember["m_name"]; ?>">
							<font color="#FF0000">*</font>
						</p>
						<p>
							性　　別：
							<input name="m_sex" type="radio" value="女" <?php
							if ($row_RecMember["m_sex"] == "女")
								echo "checked";
							?>>
							女
							<input name="m_sex" type="radio" value="男" <?php
							if ($row_RecMember["m_sex"] == "男")
								echo "checked";
							?>>
							男
							<font color="#FF0000">*</font>
						</p>
						<p>
							生　　日：
							<input name="m_birthday" type="date" class="normalinput" id="m_birthday" value="<?php echo $row_RecMember["m_birthday"]; ?>">
							<font color="#FF0000">*</font>
							<br>
							為西元格式(YYYY-MM-DD)。
						</p>
						<p>
							請確定此電子郵件為可使用狀態，以方便未來如補寄會員密碼信。
						</p>
						<p>
							電　　話：
							<input name="m_phone" type="text" class="normalinput" id="m_phone" value="<?php echo $row_RecMember["m_phone"]; ?>">
						</p>
						<p>
							住　　址：
							<input name="m_address" type="text" class="normalinput" id="m_address" value="<?php echo $row_RecMember["m_address"]; ?>" size="40">
						</p>

						<div class="boardtopic">
							<h4> 專業資料 </h4>
						</div>
						<br>
						<p>
							技　　能：
							<input name="m_skill" type="text" class="normalinput" id="m_skill" value="<?php echo $row_RecMember["m_skill"]; ?>">
						</p>
						<p>
						學　　歷：
						<input name="m_academic" type="text" class="normalinput" id="m_academic" value="<?php echo $row_RecMember["m_academic"]; ?>">
						</p>
						<p>
						自　　介：
						<textarea name="m_description" id="m_description" cols="40" rows="4" class="span3"><?php echo $row_RecMember["m_description"]; ?></textarea>
						</p>
						<hr>
						<p>
							<font color="#FF0000">*</font> 表示為必填的欄位
						</p>
						<p>
							<input name="m_id" type="hidden" id="m_id" value="<?php echo $row_RecMember["m_id"]; ?>">
							<input name="action" type="hidden" id="action" value="update">
							<input type="submit" name="Submit2" class="btn btn-info" value="修改資料">
							<input type="reset" name="Submit3" class="btn btn-primary" value="重設資料">
							<input type="button" name="Submit" class="btn btn-warning" value="回上一頁" onClick="window.history.back();">
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include("board_post.php");?>

        	</div>
    	</div>
    </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.min.js"></script>
</body>
</html>
