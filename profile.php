<?php
header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");
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
//連結登入會員資料
$query_RecMember = "SELECT * FROM `memberdata` WHERE `m_username`='" . $_SESSION["loginMember"] . "'";
$RecMember = mysql_query($query_RecMember);
$row_RecMember = mysql_fetch_assoc($RecMember);

//預設每頁筆數
$board_pageRow_records = 20;
//預設頁數
$board_num_pages = 1;
//若已有翻頁，更新頁數
if (isset($_GET['page'])) {
    $board_num_pages = $_GET['page'];
}
//本頁開始記錄筆數 ＝ (頁數-1)*每頁記錄筆數
$board_startRow_records = ($board_num_pages - 1) * $board_pageRow_records;
//未加限制顯示筆數的SQL敘述句
$board_query_RecBoard = "
  SELECT * FROM `board`
  LEFT JOIN `memberdata` on `board`.`boardname` = `m_name`
  ORDER BY `boardtime` DESC
";
//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
$board_query_limit_RecBoard = $board_query_RecBoard . " LIMIT " . $board_startRow_records . ", " . $board_pageRow_records;
//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecBoard 中
$board_RecBoard = mysql_query($board_query_limit_RecBoard);
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecBoard 中
$board_all_RecBoard = mysql_query($board_query_RecBoard);
//計算總筆數
$board_total_records = mysql_num_rows($board_all_RecBoard);
//計算總頁數=(總筆數/每頁筆數)後無條件進位。
$board_total_pages = ceil($board_total_records / $board_pageRow_records);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <script src="js/jquery-2.1.1.js"></script>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="stylesheet" href="css/search.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/dynamicgrid.js"></script>
    <script type="text/javascript" src="js/myFunctions.js"></script>
    <script type="text/javascript" src="js/search.js"></script>
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
</head>

<body>
    <div class="navigationBar">
        <span class="left">
                <span class="logo">
                    NPO Lab
                </span>
        </span>
        <span class="searchBar">
                <div class="searchBorder">
                    <input class="searchInput" type="text" placeholder="輸入專案名稱或類別">
                    <i class="searchIcon fa fa-search"></i>
                </div>
                <div class="dropdownTagList">
                    <ul>
                    </ul>
                </div>
            </span>
        <span class="right">
            <!--設定按鈕，暫時先拿掉-->
            <!--<a href="#" data-toggle="modal" data-target=".edit">
            <span id="editProfile" >
            <img src="images/ic_setting.png">
            </span>
        </a>-->
        <a href="#" data-toggle="modal" data-target=".new">
            <span id="newProject">
            <img src="images/ic_newProject.png">
            </span>
        </a>
        </span>
    </div>
    <div id="profile">
        <a href="#" data-toggle="modal" data-target=".edit">
            <div class="userAvator big">
               <img class="img-circle" height="100px" width="100px" src="profilepic/<?php echo $row_RecMember["m_profilepic"]; ?>">
            </div>
        </a>
        <div class="userName"><?php echo $row_RecMember["m_name"];?></div>
        <div class="userTitle">一般使用者的稱號，可省略。</div>
        <ul class="tab">
            <a href="#">
                <li class="selected">找專案</li>
            </a>
            <a href="#">
                <li>進行中的專案</li>
            </a>
            <a href="#">
                <li>已完成的專案</li>
            </a>
            <a href="#">
                <li>追蹤的專案</li>
            </a>
            <a href="#">
                <li>我建立的專案</li>
            </a>
        </ul>
    </div>
    <div class="pool js-masonry">

        <?php while($board_row_RecBoard = mysql_fetch_assoc($board_RecBoard)){ ?>

        <div class="project">
            <div class="projectImage">
                <img src="images/<?php echo $board_row_RecBoard["boardImg"]; ?>" alt="" />
            </div>
            <div class="projectHeader">
                <a href="#" data-toggle="modal" data-target=".singleProject" onclick="readDetail(this)" data-id="<?php echo $board_row_RecBoard['boardid']; ?>">
                    <h3 class="projectName"><?php echo $board_row_RecBoard["boardsubject"]; ?></h3></a>
                <ul class="tagContainer">
                    <?php if ($board_row_RecBoard["boardtag"] == "設計" )  {?>
                        <li>設計</li>
                    <?php } ?>
                    <?php if ($board_row_RecBoard["boardtag"] == "網站" ) {?>
                        <li>網站</li>
                    <?php } ?>
                    <?php if ($board_row_RecBoard["boardtag"] == "行銷") {?>
                        <li>行銷</li>
                    <?php } ?>
                </ul>
                <div class="projectInfo">
                    <div class="tagContainer"></div>
                    <div class="projectTime"><?php echo $board_row_RecBoard["boardtime"]?></div>
                    <div class="projectMemeber">10/20</div>
                </div>
            </div>
            <div class="projectFooter">
                <a href="#" data-toggle="modal" data-target=".singleProfile">
                    <span class="userAvator small"></span>
                    <span class="userName"><?php echo $board_row_RecBoard["boardname"];?></span>
                </a>
            </div>
        </div>

        <?php } ?>

    </div>

    <!--single project start-->
    
    <script type="text/javascript">
        function readDetail(dom){
            var id = $(dom).attr('data-id');
            $("#projectModal").load("modalProject.php?id=" + id, function(){
            $("#projectModal").modal('show');
            });
        }
    </script>

    <div class="singleProject modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="projectImage">
                    <img src="images/<?php echo $board_row_RecBoard["boardImg"];?>">
                </div>
                <div class="popUpHeader">
                    <div class="actionContainer">
                        <span class="main">參加</span>
                        <span>追蹤</span>
                        <span data-dismiss="modal">關閉</span>
                    </div>
                    <h3 class="projectName"><?php echo $board_row_RecBoard["boardsubject"]; ?></h3>
                    <ul class="tagContainer">
                        <li>標籤</li>
                        <li>標籤</li>
                        <li>標籤</li>
                        <li>標籤標籤標籤</li>
                        <li>標籤</li>
                        <li>標籤</li>
                        <li>標籤</li>
                        <li>標籤</li>
                    </ul>
                    <div class="projectInfo">
                        <div class="tagContainer"></div>
                        <div class="projectTime">2015/06/27~2015/06/30</div>
                        <div class="projectMemeber">10/20</div>
                    </div>
                </div>
                <div class="popUpContent">
                    <div class="projectContent">
                        <p>這個專案的目的在於幫助公益團體有效的推廣宣傳活動。希望行銷相關背景的學生能夠一起加入！</p>
                    </div>
                </div>
                <div class="popUpFooter">
                    <h3>留言</h3>
                    <div class="leaveComment">
                        <textarea></textarea>
                        <button>送出留言</button>
                        <button>重新填寫</button>
                        <button>分享專案</button>
                    </div>
                    <div class="commentContainer">
                        <div class="comment">
                            <span class="userAvator small"></span>
                            <div class="userName">使用者名稱<span class="commentTime"><br>1小時前</span>
                            </div>
                            <div class="userContent">
                                <p>這個專案很棒！我很喜歡！</p>
                            </div>
                        </div>
                        <div class="comment">
                            <span class="userAvator small"></span>
                            <div class="userName">使用者名稱<span class="commentTime"><br>2小時前</span>
                            </div>
                            <div class="userContent">
                                <p>大家加油！</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--project owner modal-->
    <div class="singleProfile modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="popUpHeader">
                    <div class="actionContainer">
                        <span class="main">聯絡</span>
                        <span data-dismiss="modal">關閉</span>
                    </div>
                    <div class="userAvator big"></div>
                    <br>
                    <div class="userName"><?php echo $board_row_RecBoard["boardname"];?>111</div>
                    <div class="userTitle">一般使用者的稱號，可省略。</div>
                    <ul class="tagContainer">
                        <li>平面設計</li>
                        <li>網頁設計</li>
                        <li>行銷規劃</li>
                        <li>專案規劃</li>
                    </ul>
                </div>
                <div class="popUpContent">
                </div>
                <!--<div class="popUpFooter">
                    <button>傳送即時訊息</button>
                    <button data-dismiss="modal">取消</button>
                </div>-->
            </div>
        </div>
    </div>
    <div class="new modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="projectImage">
                    <button>上傳圖片</button>
                </div>
                <div class="popUpHeader">
                    <div class="actionContainer">
                        <span class="main">發佈</span>
                        <span>儲存</span>
                        <span data-dismiss="modal">關閉</span>
                    </div>
                    <input name="newProjectName" placeholder="專案名稱">
                    <ul class="tagContainer">
                        <input name="newProjectTags" placeholder="新增標籤">
                    </ul>
                    <div class="projectInfo">
                        <div>
                            <input placeholder="專案開始時間" name="newProjectDate">
                        </div>
                        <div>
                            <input placeholder="專案結束時間" name="newProjectDate">
                        </div>
                    </div>
                </div>
                <div class="popUpContent">
                    <textarea placeholder="專案敘述"></textarea>
                </div>
                <!--<div class="popUpFooter">
                    <button class="main">發佈</button>
                    <button data-dismiss="modal">取消</button>
                </div>-->
            </div>
        </div>
    </div>
    <div class="edit modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="popUpHeader">
                    <div class="actionContainer">
                        <form action="" method="POST" enctype="multipart/form-data" name="formJoin" id="formJoin" onSubmit="return checkForm();">
                        <span class="main">儲存</span>
                        <a href="?logout=true"><span>登出</span></a>
                        <span data-dismiss="modal">關閉</span>
                    </div>
                    <h3>編輯個人資料</h3>
                </div>
                <div class="popUpContent">
                    <table>
                        <tbody>
                            <tr>
                                <th>大頭照</th>
                                <td colspan="2">
                                    <span class="userAvator">
                                        <img class="img-circle" height="50px" width="50px" src="profilepic/<?php echo $row_RecMember["m_profilepic"]; ?>">
                                    </span>
                                    <input type="file" name="m_profilepic" id="m_profilepic"/>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>姓名</th>
                                <td colspan="2">
                                    <input name="m_name" type="text" class="normalinput" id="m_name" value="<?php echo $row_RecMember["m_name"]; ?>">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>性別</th>
                                <td colspan="2">
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
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td colspan="2">
                                    <input type="text" placeholder="" value="XXXX@xxx.com">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>技能</th>
                                <td colspan="2">
                                    <input name="m_skill" type="text" class="normalinput" id="m_skill" value="<?php echo $row_RecMember["m_skill"]; ?>">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>隱私設定</th>
                                <td colspan="2">
                                    <label>
                                        <input type="checkbox">別人無法傳送訊息給我</label>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>使用E-mail帳號</th>
                                <td colspan="2">
                                    <?php echo $row_RecMember["m_username"]; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>更新密碼</th>
                                <td colspan="2">
                                    <input name="m_passwd" type="password" class="normalinput" id="m_passwd">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>再輸入一次新密碼</th>
                                <td colspan="2">
                                    <input name="m_passwdrecheck" type="password" class="normalinput" id="m_passwdrecheck">
                                    <br>
                                </td>
                                <td>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    若不修改密碼，請不要填寫。若要修改，請輸入密碼二次。
                    <br>
                    若修改密碼，系統會自動登出，請用新密碼登入。
                </div>
                <!--<div class="popUpFooter">
                    <button class="main">儲存</button>
                    <button data-dismiss="modal">取消</button>
                </div>-->
            </div>
        </div>
    </div>
</body>

</html>