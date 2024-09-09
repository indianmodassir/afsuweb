<?php
ob_start();
require '../assets/server/auth/logged.php';
require '../connection/dbconnect.php';
isLogged($conn, function() {
  header("location:/");
  die();
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Shahzadi Afsara"/>
  <title>ASOT – Login or Signup</title>
  <link rel="stylesheet" href="/assets/css/app.css">
  <script src="/library/jqrony-min.js"></script>
  <script src="/assets/js/login-signup.js" defer></script>
</head>
<body>
  <div class="nav">
    <div class="leftbar">
      <div><img src="/assets/img/weblogo.png" alt="Web Logo" width="70" height="70"></div>
    </div>
    <div style="text-align:center;flex:1;">
      <div><h1>Annual Secondry Objective Test – <?php echo date('Y'); ?></h1></div>
      <div class="subtitle">Bihar Board Annual Secondry Objective Test (ASOT) – <?php echo date('Y'); ?> For Intermediate Examination</div>
    </div>
  </div>
  <div class="container">
    <div class="form-container">
      <form action="/assets/server/login.php" method="post">
        <div class="field">
          <input type="number" id="rollno" name="rollno" placeholder="Enter Rollno" min="0">
          <div id="Rollno" class="__error"></div>
        </div>
        <div class="field">
          <div style="position:relative;">
            <input type="password" id="password" name="password" placeholder="Enter Password" maxLength="50" autocomplete="off">
            <div class="show-hide">Show</div>
          </div>
          <div id="Password" class="__error"></div>
        </div>
        <div class="field">
          <button>login</button>
        </div>
        <div class="field" style="text-align:center;">
          <span>Don't have Account?</span>
          <a href="/signup/">Signup</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>