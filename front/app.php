<?php 
  $current_time = time();
  $total_days_pending = 37;
     $from_date = date('Y-m-d 00:00:00', strtotime('-'. $total_days_pending .' day', $current_time));
     echo $from_date;
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="vi"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="vi"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="vi"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="vi"> <!--<![endif]-->
<head>
  
  <meta charset="utf-8" content="text/html" http-equiv="content-type">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
</head>
<body ng-app="jApp"> 
  <div style="padding:20px;"><a href="https://play.google.com/store/apps/details?id=com.pt.pd.app.notifyme">Android App</a></div>
  This is for test!!!
</body>
</html>