<script type="text/javascript">
  function readDetail(dom){
    var id = $(dom).attr('data-id');
    $("#projectModal").load("modalProject.php?id=" + id, function(){
      $("#projectModal").modal('show');
    });
  }
</script>
<!-- Single Project-->
      <div class="panel panel-default">
     
          <!-- Project Title-->
          <div class="panel-heading">
          <a data-toggle="modal" onclick="readDetail(this)" data-id="<?php echo $board_row_RecBoard['boardid']; ?>">
            <h2><?php echo $board_row_RecBoard["boardsubject"]; ?></h2>
            
            </a>
            </div>
            <div class="panel-body">
            <!-- Project Status-->
          <span aria-hidden="true" class="glyphicon glyphicon-user"></span><span aria-hidden="true" class="glyphicon glyphicon-time"></span> <?php echo $board_row_RecBoard["boardtime"]?>
          
            <!-- Project Tags-->
             
             <span class="label label-info"><?php
          if ($board_row_RecBoard["boardtag"] == 設計)  {
            echo "設計";
          }else if ($board_row_RecBoard["boardtag"] == "網站") {
            echo "網站";
          }else if ($board_row_RecBoard["boardtag"] == "行銷") {
            echo "行銷";
          }else{
            echo "not all";
          }
        ?></span> 
             
          
            <div class="media">
              <div class="media-left"> <img data-src="holder.js/40x40/text:K" class="img-circle" ><br> <?php echo $board_row_RecBoard["boardname"]; ?></div>
              <div class="media-body"> <?php echo nl2br($board_row_RecBoard["boardcontent"]); ?> </div>
            </div>
          </div>
        
      </div>
      
      
      <!-- Single Project--> 
      
      
