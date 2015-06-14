<?php
require_once ("connMysql.php");
//專案資料取出開始
//預設每頁筆數
$board_pageRow_records = 10;
//預設頁數
$board_num_pages = 1;
//若已經有翻頁，將頁數更新
if (isset($_GET['page'])) {
	$board_num_pages = $_GET['page'];
}
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$board_startRow_records = ($board_num_pages - 1) * $board_pageRow_records;
//未加限制顯示筆數的SQL敘述句
$board_query_RecBoard = "SELECT * FROM `board` WHERE `boardid` = " . $_GET['id'] . " ORDER BY `boardtime` DESC";
//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
$board_query_limit_RecBoard = $board_query_RecBoard . " LIMIT " . $board_startRow_records . ", " . $board_pageRow_records;
//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecBoard 中
$board_RecBoard = mysql_query($board_query_limit_RecBoard);
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecBoard 中
$board_row_RecBoard=mysql_fetch_assoc($board_RecBoard);


?>
<!-- Project Modal -->
    
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn btn-default"> <span aria-hidden="true" class="glyphicon glyphicon-user"> 加入專案 </button>
            <button type="button" class="btn btn-default"> <span aria-hidden="true" class="glyphicon glyphicon-bookmark"> 追蹤 </button>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body"> 
          <h2><?php echo $board_row_RecBoard["boardsubject"]; ?></h2>
            <h4 class="modal-title" id="myModalLabel"> <small>12091288</small></h4>
            <h2 align="center"></h2>
            <p> 專案日期：<?php echo $board_row_RecBoard["boardtime"];?> </p>

            <h3><?php echo $board_row_RecBoard["boardcontent"]; ?></h3>
          
            <p> 專案說明...BlablaBlablaBlablaBlabla...BlablaBlablaBlablaBlabla </p>

          </div>
          <div class="modal-footer">
            <div class="media">
              <div class="media-left"> <img data-src="holder.js/40x40/text:K" class="img-circle"> </div>
              <div class="media-body">
                <h5 class="media-left">NPOK <small> - 2 天前</small></h5>
                <p> 專案討論...BlablaBlablaBlablaBlabla </p>
              </div>
            </div>
            <div class="media">
              <div class="media-left"> <img data-src="holder.js/40x40/text:S" class="img-circle"> </div>
              <div class="media-body">
                <h5 class="media-left">SOMEONE <small> - 2 天前</small></h5>
                <p> 專案討論...BlablaBlablaBlablaBlabla </p>
              </div>
            </div>
            <div class="media">
              <div class="media-left"> <img data-src="holder.js/40x40/text:M" class="img-circle"> </div>
              <div class="media-body">
                <h5 class="media-left">ME</h5>
                <div class="input-group input-group-sm">
                  <input type="text" class="form-control" placeholder="問問題" aria-describedby="basic-addon2">
                  <span class="input-group-addon" id="basic-addon2">Send</span> </div>
              </div>
            </div>
          </div>
        </div>
      </div>