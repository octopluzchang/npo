<!-- Single Project-->
      <div class="list-group">
        <div class="thumbnail"> <img data-toggle="modal" data-target="#projectModal" data-src="holder.js/100%x200"> <?php echo $board_row_RecBoard["username"]; ?>
          <div class="caption list-group-item"> <span aria-hidden="true" class="glyphicon glyphicon-user"></span> 9/10 <span aria-hidden="true" class="glyphicon glyphicon-time"></span> 2015/10/20 <a data-toggle="modal" data-target="#projectModal">
            <h2><?php echo $board_row_RecBoard["boardsubject"]; ?></h2>
            </a> <span class="label label-info">設計</span> <span class="label label-info">行銷</span> <span class="label label-info">網站</span> </div>
          <div class="list-group-item">
            <div class="media">
              <div class="media-left"> <img data-src="holder.js/40x40/text:K" class="img-circle"> </div>
              <div class="media-body"> <?php echo nl2br($board_row_RecBoard["boardcontent"]); ?> </div>
            </div>
          </div>
        </div>
      </div><!-- Single Project--> 