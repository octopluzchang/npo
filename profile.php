<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="js/holder.js"></script>
<script>
$('#home a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})

$('#profile a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
</script>
<title>NPO Lab</title>

<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php include("navbar.php"); ?>
<div class="container">
<!-- User Profile -->
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4 text-center"><img data-src="holder.js/40x40/text:K" class="img-circle">
      <h1>Kenny</h1>
    </div>
    <div class="col-md-4"></div>
  </div><!-- User Profile -->
  
  <div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">已完成的專案</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">正在進行的專案</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">追蹤中的專案</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
    <div class="row">
    <div class="col-sm-6 col-md-4">   
    <?php include("singleProject.php"); ?>
    
    </div>
  </div>
  </div>
  
    <div role="tabpanel" class="tab-pane" id="profile">...</div>
    <div role="tabpanel" class="tab-pane" id="messages">...</div>
  </div>

</div>
  
  
  
 
  
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="file:///Macintosh HD/Users/kenny/Desktop/npolab/web/js/bootstrap.min.js"></script>
</body>
</html>