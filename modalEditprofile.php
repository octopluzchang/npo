<!-- Project Modal -->
    <div class="modal fade" id="editprofileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">編輯個人資料</h4>
      </div>
          <div class="modal-body"> <div class="formarea">
				<form action="" method="POST" enctype="multipart/form-data" name="formJoin" id="formJoin" onSubmit="return checkForm();">
					<div class="boardtopic">
					<p>肖像照片：</p>
					<input type="file" name="m_profilepic" id="m_profilepic" />
					<p>

					<h4>
						帳號資料
					</h4>
					</div>
					<br>
					<p>
						使用帳號：<?php echo $row_RecMember["m_username"]; ?>
					</p>
					<p>
						使用密碼：
						<input name="m_passwd" type="password" class="normalinput" id="m_passwd">
						<br>
					</p>
					<p>
						確認密碼 ：
						<input name="m_passwdrecheck" type="password" class="normalinput" id="m_passwdrecheck">
						<br>
						若不修改密碼，請不要填寫。若要修改，請輸入密碼二次。
						<br>
						若修改密碼，系統會自動登出，請用新密碼登入。
					</p>
					<hr>
					<div class="boardtopic">
					<h4>
						個人資料
					</h4>
					</div>
					<br>
					<p>
						真實姓名：
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
						<input name="m_birthday" type="text" class="normalinput" id="m_birthday" value="<?php echo $row_RecMember["m_birthday"]; ?>">
						<font color="#FF0000">*</font>
						<br>
						為西元格式(YYYY-MM-DD)。
					</p>
					<p>
						電子郵件：
						<input name="m_email" type="text" class="normalinput" id="m_email" value="<?php echo $row_RecMember["m_email"]; ?>">
						<font color="#FF0000">*</font>
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
					<h4>
						技能資料
					</h4>
					</div>
					<br>
					<p>
						My Skill：
						<input name="m_skill" type="text" class="normalinput" id="m_skill" value="<?php echo $row_RecMember["m_skill"]; ?>">
					</p>
					<p>
						My Swap：
						<input name="m_swap" type="text" class="normalinput" id="m_swap" value="<?php echo $row_RecMember["m_swap"]; ?>">
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