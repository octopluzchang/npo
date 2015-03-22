<!-- Single Project-->
      <div class="panel panel-default">
     
          <!-- Project Title-->
          <div class="panel-heading">
          <a data-toggle="modal" data-target="#projectModal">
            <h2><?php echo $board_row_RecBoard["boardsubject"]; ?></h2>
            </a>
            </div>
            <div class="panel-body">
            <!-- Project Status-->
          <span aria-hidden="true" class="glyphicon glyphicon-user"></span> 9/10 <span aria-hidden="true" class="glyphicon glyphicon-time"></span> 2015/10/20 
          
            <!-- Project Tags-->
             
             <span class="label label-info">設計</span> <span class="label label-info">行銷</span> <span class="label label-info">網站</span> 
             
          
            <div class="media">
              <div class="media-left"> <img data-src="holder.js/40x40/text:K" class="img-circle"><br> <?php echo $board_row_RecBoard["username"]; ?></div>
              <div class="media-body"> <?php echo nl2br($board_row_RecBoard["boardcontent"]); ?> </div>
            </div>
          </div>
        
      </div>
      
      
      <!-- Single Project--> 
      
      
