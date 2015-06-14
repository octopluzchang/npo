<?php if ($_SESSION["loginMember"]){ ?>
<link rel="stylesheet" href="chat/style.css">
<script src="chat/client.js"></script>
<div class="chatbox-list">
	<div class="chatbox template">
		<div class="title"></div>
		<div class="messages"></div>
		<input type="text"/>
		<button type="button">送出</button>
	</div>
</div>
<?php
  //繫結登入會員資料
  $query_RecMember = "SELECT * FROM `memberdata` WHERE `m_username`='" . $_SESSION["loginMember"] . "'";
  $RecMember = mysql_query($query_RecMember);
  $row_RecMember = mysql_fetch_assoc($RecMember);
 ?>
 <script>
	login({
		id: <?php echo $row_RecMember["m_id"]; ?>,
		name: '<?php echo $row_RecMember["m_name"]; ?>'
	});
</script>
<?php } ?>