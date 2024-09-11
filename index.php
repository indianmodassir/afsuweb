<?php
ob_start();
require 'assets/server/auth/logged.php';
require 'connection/dbconnect.php';
require 'dist/Asot.php';
$Asot = new Asot($conn);
$userInfo = $Asot->get_active_user();

date_default_timezone_set("Asia/Kolkata");
if (!isLogged($conn)) {
  header("location:login/"); die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Shahzadi Afsara"/>
  <meta name="theme-color" content="#6a6af1"/>
  <title>ASOT – Annual Secondry Objective Test</title>
  <link rel="shortcut icon" href="/assets/img/weblogo.png" type="image/x-icon">
  <link rel="apple-touch-icon" href="/assets/img/weblogo.png">
  <link rel="manifest" href="/manifest.json">
  <link rel="stylesheet" href="assets/css/app.css">
  <script src="/library/jqrony-min.js"></script>
  <script src="assets/js/app.js" defer></script>
</head>
<body>
  <div class="nav">
    <div class="leftbar">
      <div><img src="assets/img/weblogo.png" alt="Web Logo" width="70" height="70"></div>
      <div><strong><?=$userInfo["username"];?></strong></div>
    </div>
    <div style="text-align:center;flex:1;">
      <div><h1>Annual Secondry Objective Test – <?php echo date('Y'); ?></h1></div>
      <div class="subtitle">Bihar Board Annual Secondry Objective Test (ASOT) – <?php echo date('Y'); ?> For Intermediate Examination</div>
    </div>
    <div><a href="/assets/server/auth/logout.php?ts=-<?=time()+(60*60*24);?>">Logout</a></div>
  </div>
  <div class="container">
    
  </div>
</body>
</html>