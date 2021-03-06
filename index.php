<?php
header("Content-Type: text/html; charset=utf-8");
require_once ("connMysql.php");
session_start();
//檢查是否有經過登入，如有將重新導向至會員中心
if (isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"] != "")) {
    //若帳號等級為member，則導向會員中心
    if ($_SESSION["memberLevel"] == "member") {
        header("Location: profile.php");
    }else{
        header("Location: member_admin.php");
    }
}
//執行會員登入
if (isset($_POST["username"]) && isset($_POST["passwd"])) {
    //連結登入會員資料
    $query_RecLogin = "SELECT * FROM `memberdata` WHERE `m_username` ='" . $_POST["username"] . "'";
    $RecLogin = mysql_query($query_RecLogin);
    //取出帳號及密碼的值
    $row_RecLogin = mysql_fetch_assoc($RecLogin);
    $username = $row_RecLogin["m_username"];
    $passwd = $row_RecLogin["m_passwd"];
    $level = $row_RecLogin["m_level"];
    //比對密碼，若成功則進入登入狀態
    if (md5($_POST["passwd"]) == $passwd) {
        //計算登入次數及更新登入時間
        $query_RecLoginUpdate = "UPDATE `memberdata` SET `m_login` +1, `m_logintime`=NOW() WHERE `m_username`='" . $_POST["username"] . "'";
        mysql_query($query_RecLoginUpdate);
        //設定登入者的名稱及等級
        $_SESSION["loginMember"] = $username;
        $_SESSION["memberLevel"] = $level;
        //使用Cookie紀錄登入資料
        if (isset($_POST["rememberme"]) && ($_POST["rememberme"] == "true")) {
            setcookie("remUser", $_POST["username"], time() + 365 * 24 * 60);
            setcookie("remPass", $_POST["passwd"], time() + 365 * 24 * 60);
        }
        else{
            if (isset($_COOKIE["remUser"])) {
                setcookie("remUser", $_POST["username"], time() - 100);
                setcookie("remPass", $_POST["passwd"], time() - 100);
            }
        }
        //若帳號等級為member，導向會員中心
        if ($_SESSION["memberLevel"] == "member") {
            header("Location: profile.php");
        }
        else{
            header("Location: member_admin.php");
        }
    }
    else{
        header("Location: index.php?errMsg=1");
    }
}

if (isset($_POST["action"]) && ($_POST["action"] == "join")) {
    //確認帳號是否已經註冊
    $query_RecFindUser = "SELECT `m_username` FROM `memberdata` WHERE `m_username`='" . $_POST["m_username"] . "'";
    $RecFindUser = mysql_query($query_RecFindUser);
    if (mysql_num_rows($RecFindUser) > 0) {
        header("Location: profile.php?errMsg=1&username=" . $_POST["m_username"]);
    }
    else{
        //若沒有執行新增的動作
        $query_insert = "INSERT INTO `memberdata` (`m_name` ,`m_username` ,`m_passwd` ,`m_sex` ,`m_skill` ,`m_birthday` ,`m_phone`,`m_address`, `m_academic`, `m_description`, `m_jointime`) VALUES (";
        $query_insert .= "'" . $_POST["m_name"] . "',";
        $query_insert .= "'" . $_POST["m_username"] . "',";
        $query_insert .= "'" . md5($_POST["m_passwd"]) . "',";
        $query_insert .= "'" . $_POST["m_sex"] . "',";
        //$query_insert .= "'" . $_POST["m_profilepic"] . "',";
        $query_insert .= "'" . $_POST["m_skill"] . "',";
        $query_insert .= "'" . $_POST["m_birthday"] . "',";
        $query_insert .= "'" . $_POST["m_phone"] . "',";
        $query_insert .= "'" . $_POST["m_address"] . "',";
        $query_insert .= "'" . $_POST["m_academic"] . "',";
        $query_insert .= "'" . $_POST["m_description"] . "',";
        $query_insert .= "NOW())";
        //echo $query_insert;
        mysql_query($query_insert);
        header("Location: profile.php");
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <script src="js/jquery-2.1.1.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="stylesheet" href="css/home.css" type="text/css">
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/landing.js"></script>
</head>

<body>
    <div id="homeNav">
        <div class="wrapper">
           <!-- <a href="#landing" id="homeLogo"><span>NPO Lab</span></a>-->
            
            <a href="#joinUs"><span id="signupNav">加入我們</span></a>
            <a href="#landing"><span id="loginNav">登入公益實驗室</span></a>
        </div>
    </div>
    <div class="section" id="landing">
        <div class="wrapper">
            <div class="center">
                <div class="content">
                    <h1>公益實驗室 NPO Lab</h1>
                    <h3>你的力量，足以改變世界</h3>

                    <form name="form1" method="post" action="">

                        <table>
                            <tbody>

                                <tr>
                                    <td>
                                        <input name="username" type="text" class="" placeholder="電子郵件或暱稱" id="username" value="<?php
								if (isset($_COOKIE[" remUser "])) {echo $_COOKIE["remUser "];
								}
								?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input name="passwd" type="password" class="" placeholder="密碼" id="passwd" value="<?php
								if (isset($_COOKIE[" remPass "])) {echo $_COOKIE["remPass "];
								}
								?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                     <input type="submit" name="login" id="loginBtn" class="main" value="登入">
                                    </td>
                                </tr>
                                


                            </tbody>
                        </table>
                        
                        <a href="admin_passmail.php">
                                            <p>忘記密碼？</p>
                                        </a>
                       
                        <?php if(isset($_GET[ "errMsg"]) && ($_GET[ "errMsg"]=="1" )){?>
                                        <p class="detail">登入帳號或密碼錯誤！</p>
                                        <?php } ?>
                    </form>
                </div>
            </div>
            <video autoplay loop poster="homevideo.png" id="bgvid" muted>
                <source src="polina.webm" type="video/webm">
                <source src="homevideo.mp4" type="video/mp4">
            </video>
            <div id="aboutNav">
            <a href="#about">我們是誰？</a>
            </div>
        </div>
    </div>
    <div class="section" id="about">
        <div class="wrapper">
            <div class="left">
            </div>
            <div class="right">
                <div class="content">
                    <h1>我們是誰？</h1>我們是一群為了社會公益而努力的人。
                    <br> 公益實驗室將公益組織與想幫助他們的人結合在一起，創造更多改變的機會。
                </div>
            </div>
        </div>
    </div>
    <div class="section" id="doSomething">
        <div class="wrapper">
            <div class="left">
                <div class="content">
                    <h1>你可以做什麼？</h1> 透過公益實驗室，你可以與其他一樣熱血的人一起貢獻你的專業技能給需要的公益組織。
                </div>
            </div>
            <div class="right">
            </div>
        </div>
    </div>
    <div class="section" id="getSomething">
        <div class="wrapper">
            <div class="left">
            </div>
            <div class="right">
                <div class="content">
                    <h1>你可以得到什麼？</h1> 透過完成專案，你可以完成個人專屬的成就，幫助你在日後的求職上更順利！
                </div>
            </div>
        </div>
    </div>
    <div class="section" id="joinUs">
        <div class="wrapper">
            <div class="center">
                <?php if(isset($_GET[ "loginStats"]) && ($_GET[ "loginStats"]=="1" )){ ?>
                <script language="javascript">
                    alert('會員新增成功\n請用申請的帳號密碼登入。');
                    window.location.href = 'profile.php';
                </script>
                <?php } ?>
                <h1>現在就加入我們吧！</h1>
                <hr>
                <form action="" method="POST" name="formJoin" id="formJoin" onSubmit="return checkForm();">
                    <table>
                        <tbody>
                            <tr>
                                <th scope="row" colspan="2">
                                    <div class="detail">
                                        <?php if(isset($_GET[ "errMsg"]) && ($_GET[ "errMsg"]=="1" )){?>
                                        <div>
                                            <?php echo $_GET[ "username"]; ?> 看起來這帳號已經有囉</div>
                                        <hr>
                                    </div>
                                </th>
                                <td></td>


                                <?php } ?>
                            </tr>
                            <tr>
                                <th scope="row">暱稱</th>
                                <td>
                                    <input name="m_name" type="text" class="normalinput" id="m_name">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">電子郵件</th>
                                <td>
                                    <input name="m_username" type="text" class="" id="m_username">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    密碼
                                </th>

                                <td>
                                    <input name="m_passwd" type="password" class="" id="m_passwd" placeholder="請填入5~10個字元">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">再輸入一次密碼</th>
                                <td>
                                    <input name="m_passwdrecheck" type="password" class="" id="m_passwdrecheck">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table>
                        <tbody>



                        </tbody>
                    </table>

                    <hr>
                    <input name="action" type="hidden" id="action" value="join">
                    <input type="submit" name="Submit2" value="送出申請" class="main">

                </form>
            </div>
        </div>
    </div>
    <div id="homeFooter">
        <div class="wrapper">
            NPO Lab 公益實驗室 2015
        </div>
    </div>

    <div class="signIn modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="popUpHeader">
                    <div class="actionContainer">
                        <form name="form1" method="post" action="">
                            <input type="submit" name="login" id="login" class="main" value="登入">
                            <span data-dismiss="modal">關閉</span>
                    </div>
                    <h3>歡迎回來</h3>
                </div>
                <div class="popUpContent">

                    <table>
                        <tbody>

                            <tr>
                                <th>電子信箱</th>
                                <td>
                                    <input name="username" type="text" class="" placeholder="Enter your account" id="username" value="<?php
								if (isset($_COOKIE[" remUser "])) {echo $_COOKIE["remUser "];
								}
								?>">
                                </td>
                            </tr>
                            <tr>
                                <th>密碼</th>
                                <td>
                                    <input name="passwd" type="password" class="" placeholder="Password" id="passwd" value="<?php
								if (isset($_COOKIE[" remPass "])) {echo $_COOKIE["remPass "];
								}
								?>">
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <div>
                        <label>
                            <input name="rememberme" type="checkbox" id="rememberme" value="true" checked>下次記得我
                        </label>
                    </div>
                    <a href="admin_passmail.php">
                        <p>忘記密碼？</p>
                    </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>