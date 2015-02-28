<?php
require_once ("connMysql.php");

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `memberdata` WHERE `m_username`='" . $_SESSION["loginMember"] . "'";
$RecMember = mysql_query($query_RecMember);
$row_RecMember = mysql_fetch_assoc($RecMember);
?>
<div class="nav navbar-nav navbar-right navbar-btn">
        <div class="btn-group">
        	<button type="button" class="btn"><a href="profile.php"><?php echo $row_RecMember["m_username"];?></a></button>
            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    		<span class="caret"></span>
    			<span class="sr-only">Toggle Dropdown</span>
  			</button>
          
          
          <ul class="dropdown-menu" role="menu">
            <li><a href="profile.php">正在進行的專案</a></li>
            <li><a href="profile.php">已完成的專案</a></li>
            <li><a href="profile.php">追蹤中的專案的專案</a></li>
            
            <li class="divider"></li>
            <li><a href="?logout=true">登出帳號</a></li>
          </ul>
        </div>
      </div>
      
      
      