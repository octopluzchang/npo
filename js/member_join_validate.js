function checkForm(){
  if (document.formJoin.m_username.value == "") {
    alert("請填寫電子郵件");
    document.formJoin.m_username.focus();
    return false;
  };
  if (!check_passwd(document.formJoin.m_passwd.value, document.formJoin.m_passwdrecheck.value)) {
    document.formJoin.m_passwd.focus();
    return false;
  };
  if (document.formJoin.m_name.value == "") {
    alert("請填寫姓名");
    return false;
  };
  if (document.formJoin.m_birthday.value == "") {
    alert("請填寫生日");
    return false;
  };
  if (!checkmail(document.formJoin.m_username)) {
    document.formJoin.m_username.focus();
    return false;
  };
  return confirm("確定送出嗎？");
}

function check_passwd(pw1, pw2){
  if (pw1 == '') {
    alert("密碼不可空白");
    return false;
  };
  for (var idx = 0; idx < pw1.length; idx++){
    if (pw1.charAt(idx) == ' ' || pw1.charAt(idx) == '\"') {
      alert("密碼不可以含有空白或雙引號！");
      return false;
    };
    if (pw1.length < 5 || pw1.length > 10) {
      alert("密碼長度只能5到10個字母");
      return false;
    };
    if (pw1 != pw2) {
      alert("密碼二次輸入不一樣，請重新輸入");
      return false;
    };
  };
  return true;
}

function checkmail(myEmail){
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if (filter.test(myEmail.value)) {
    return true;
  };
  alert("電子郵件格式不正確");
  return false;
}











