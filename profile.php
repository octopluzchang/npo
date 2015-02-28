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
      <div class="col-md-4"></div>
    </div>
 
    <ul class="nav nav-tabs text-center">
      <li role="presentation" class="active"><a href="#">已完成的專案</a></li>
      <li role="presentation" ><a href="#">正在進行的專案</a></li>
        <li role="presentation" ><a href="#">追蹤中的專案</a></li>
  </ul>
    <div class="row">

        <div class="col-sm-6 col-md-4">
          <!-- Single Project-->
          <div class="list-group">
            <div class="thumbnail">
              <img data-toggle="modal" data-target="#projectModal" data-src="holder.js/100%x200">
              <div class="caption list-group-item">
                <span aria-hidden="true" class="glyphicon glyphicon-user"></span> 9/10 <span aria-hidden="true" class="glyphicon glyphicon-time"></span> 2015/10/20 <a data-toggle="modal" data-target="#projectModal"><h2>專案名稱</h2></a>
                <span class="label label-info">設計</span>
                <span class="label label-info">行銷</span>
                <span class="label label-info">網站</span>
              </div>

              <div class="list-group-item">
                <div class="media">
                  <div class="media-left">
                    <img data-src="holder.js/40x40/text:K" class="img-circle">
                  </div>
                  <div class="media-body">
                    專案說明專案說明專案說明專案說明專案說明案說明案說明案說明
                  </div>
                </div>
              </div>

            </div>

          </div><!-- Single Project-->

          <!-- Project Modal -->
          <div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="btn btn-default">
                    <span aria-hidden="true" class="glyphicon glyphicon-user"> 加入專案
                  </button>
                  <button type="button" class="btn btn-default">
                    <span aria-hidden="true" class="glyphicon glyphicon-bookmark"> 追蹤
                  </button>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <img data-src="holder.js/568x300">
                  <h4 class="modal-title" id="myModalLabel">專案名稱 <small>12091288</small></h4>
                  <p>
                    專案日期 2015/10/10
                  </p>

                </div>
                <div class="modal-footer">
                  <div class="media">
                    <div class="media-left">
                      <img data-src="holder.js/40x40/text:K" class="img-circle">
                    </div>
                    <div class="media-body">
                      <h5 class="media-left">NPOK <small> - 2 天前</small></h5>
                      <p>
                        專案說明專案說明專案說明專案說明專案說明專案說明
                      </p>
                    </div>
                  </div>
                  <div class="media">
                    <div class="media-left">
                      <img data-src="holder.js/40x40/text:S" class="img-circle">
                    </div>
                    <div class="media-body">
                      <h5 class="media-left">SOMEONE <small> - 2 天前</small></h5>
                      <p>
                        專案說明專案說明專案說明專案說明專案說明專案說明
                      </p>
                    </div>
                  </div>

                  <div class="media">
                    <div class="media-left">
                      <img data-src="holder.js/40x40/text:M" class="img-circle">
                    </div>
                    <div class="media-body">
                      <h5 class="media-left">ME</h5>
                      <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="問問題" aria-describedby="basic-addon2">
                        <span class="input-group-addon" id="basic-addon2">Send</span>
                      </div>
                    </div>

                  </div>

                </div>
              </div>
            </div>
          </div>

          <!-- Filter Modal -->
          <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel">選擇要新增的類別</h4>
                </div>
                <div class="modal-body">
                  <button type="button" class="btn btn-default">
                    類別標籤
                  </button>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">
                    關閉
                  </button>
                  <button type="button" class="btn btn-primary">
                    新增
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

    <?php include ("modalSignin.php");?>  
      
    </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.min.js"></script>
</body>
</html>
