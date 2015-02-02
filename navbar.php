<nav class="navbar  navbar-default">
	<div class="container">
		<div class="navbar-header">
			<div class="btn-group navbar-btn">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					NPO LAB <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li>
						<a href="#">關於我們</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="#">獎杯室</a>
					</li>
				</ul>
			</div>
		</div>
		<form class="navbar-form navbar-left" role="search">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon2"> <span class="label label-info input">設計 <span class="glyphicon glyphicon-remove"></span></span> <span class="label label-info">行銷 <span class="glyphicon glyphicon-remove"></span></span> <span class="label label-info">網站 <span class="glyphicon glyphicon-remove"></span></span> </span><span class="input-group-addon" id="basic-addon2"> <a data-toggle="modal" data-target="#filterModal"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>新增條件</a> </span>
				<input type="text" class="form-control" placeholder="搜尋專案名稱或代碼" aria-describedby="basic-addon2">
			</div>
			<button type="submit" class="btn btn-info">
				搜尋
			</button>
	
		</form>
		<div id="userStatus">
			<?php
			include ("modalsignin.php");
			?>
			<form name="form1" method="post" action="">
				<input name="username" type="text" class="" placeholder="Enter your account" id="username" value="<?php
				if (isset($_COOKIE["remUser"])) {echo $_COOKIE["remUser"];
				}
				?>">
				<input name="passwd" type="password" class="" placeholder="Password" id="passwd" value="<?php
				if (isset($_COOKIE["remPass"])) {echo $_COOKIE["remPass"];
				}
				?>">
				<input type="submit" name="button" id="button" class="" value="登入系統">
			</form>
		</div>

		<!-- /.container -->
</nav>