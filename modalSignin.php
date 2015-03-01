<!-- Signin Modal -->
<div class="modal fade" id="signinModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">登入公益實驗室</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" name="form1" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input class="form-control" name="username" id="username" placeholder="Email" value="<?php
							if (isset($_COOKIE["remUser"])) {echo $_COOKIE["remUser"];
							}
							?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">密碼</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" name="passwd" id="passwd" placeholder="Password" value="<?php
							if (isset($_COOKIE["remPass"])) {echo $_COOKIE["remPass"];
							}
							?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
								<label>
									<input type="checkbox">
									記住我 </label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default" name="button" id="button">
								登入
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

