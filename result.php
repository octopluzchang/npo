<?php
header("Content-Type: text/html; charset=utf-8");
include ("connMysql.php");


//設定字元編碼
mysql_query("SET NAMES UTF8");
$seldb = @mysql_select_db("npo");
if (!$seldb)
	die("Could not find database!");

//待解決問題
//$s_SEARCH_CODE = str_replace(ARRAY(',', '，', ';', '　', //全型空白
//'  '), ' ', $_POST["input"]);
//$m_SERACH_CODE = explode(" ",$s_SEARCH_CODE);

//$sql_query = "SELECT * FROM board WHERE (0=1";
//for($i=0,$max_i= COUNT($s_SERACH_CODE); $i < $max_i ; $i++)
//{
//  $sql_query .= " OR CONCAT(`boardsubject`,`name`) LIKE '%{$m_SEARCH_CODE[$i]}%' ";
//}
//$sql_query.= " ) ";
//echo $sql_query;

$sql_query = " SELECT * FROM board WHERE boardsubject LIKE '%" . $_POST["input"] . "%'
OR name LIKE '%" . $_POST["input"] . "%' ";

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
			<p align="center">
				<a href="member_center.php">回首頁</a>
			</p>
			<?php while ($row_result = mysql_fetch_assoc($result)) {
			?>

			<!-- Single Project-->
			<div class="panel panel-default">

			<!-- Project Title-->
			<div class="panel-heading">
			<a data-toggle="modal" data-target="#projectModal">
			<h2><?php echo $row_result["boardsubject"]?>
			</h2>
			</a>
			</div>
			<div class="panel-body">
			<!-- Project Status-->
			<span aria-hidden="true" class="glyphicon glyphicon-user"></span><span aria-hidden="true" class="glyphicon glyphicon-time"></span><?php echo $row_result["boardtime"]
			?>

			<!-- Project Tags-->

			<span class="label label-info">設計</span> <span class="label label-info">行銷</span> <span class="label label-info">網站</span>

			<div class="media">
			<div class="media-left"> <img data-src="holder.js/40x40/text:K" class="img-circle"><br> <?php echo $row_result["name"]; ?>
			</div>
			<div class="media-body"> <?php echo nl2br($row_result["boardcontent"]); ?>
			</div>
			</div>
			</div>

			</div>

			<!-- Single Project-->
			<?php } ?>
		</div>

		<?php
		include ("modalProject.php");
		?>
		<?php
		include ("modalFilter.php");
		?>
		<?php
		include ("modalSignup.php");
		?>
		<?php
		include ("modalSignin.php");
		?>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
