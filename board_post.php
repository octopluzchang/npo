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

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `memberdata` WHERE `m_username`='" . $_SESSION["loginMember"] . "'";
$RecMember = mysql_query($query_RecMember);
$row_RecMember = mysql_fetch_assoc($RecMember);

if (isset($_POST["action"]) && ($_POST["action"] == "add")) {
	$query_insert = "INSERT INTO board (boardname, boardsubject , boardtime , boardcontent , username, name ) VALUES (";
	$query_insert .= "'" . $row_RecMember["m_name"] . "',";
	//$query_insert .= "'" . $_POST["boardsex"] . "',";
	$query_insert .= "'" . $_POST["boardsubject"] . "',";
	$query_insert .= "NOW(),";
	//$query_insert .= "'" . $_POST["boardmail"] . "',";
	//$query_insert .= "'" . $_POST["boardweb"] . "',";
	$query_insert .= "'" . $_POST["boardcontent"] . "',";
	$query_insert .= "'" . $_SESSION["loginMember"] . "',";
	$query_insert .= "'" . $row_RecMember["m_name"] . "')";
	mysql_query($query_insert);

	//驗證mysql_query資訊
	//echo $query_insert;
	//echo $_SESSION["loginMember"];
	//重新導向回到主畫面
	//header("Location: member_center.php");

}
?>
		<!-- board_post.php -->
        <!-- Project Modal -->
<div class="modal fade" id="boardPost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">張貼新專案</h4>
			</div>
			<div class="modal-body">
			<div class="formarea">
				<form action="" method="post" name="formPost" id="formPost" onSubmit="return checkForm();">
					<p>
						標題
					</p>
					<p>
						<input type="text" class="form-control" name="boardsubject" id="boardsubject" required="required">
					</p>
					<p>
						專案介紹
					</p>
					<p>
						<textarea name="boardcontent" id="boardcontent" class="form-control" rows="10"></textarea>
					</p>
					
						<div class="sumit">
							<input name="action" type="hidden" id="action" value="add">
							<input type="submit" name="button" id="button" value="張貼新專案">
							<input type="reset" name="button2" id="button2" value="重設資料">
							<input type="button" name="button3" id="button3" value="回上一頁" onClick="window.history.back();">
						</div>
					
				</form>
			</div>
		</div>
	</div>

