<?php
require_once ("connMysql.php");

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `memberdata` WHERE `m_username`='" . $_SESSION["loginMember"] . "'";
$RecMember = mysql_query($query_RecMember);
$row_RecMember = mysql_fetch_assoc($RecMember);
?>
<ul class="nav navbar-nav navbar-right">
        <li><img data-src="holder.js/40x40/text:K" class="img-circle"></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $row_RecMember["m_username"];?><span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">正在進行的專案</a></li>
            <li><a href="#">已完成的專案</a></li>
            
            <li class="divider"></li>
            <li><a href="member_update.php">個人資料設定</a></li>
            <li><a href="?logout=true">登出帳號</a></li>
          </ul>
        </li>
      </ul>