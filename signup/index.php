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
  <meta name="theme-color" content="#6a6af1"/>
  <title>ASOT – Signup new Account</title>
  <link rel="shortcut icon" href="/assets/img/weblogo.png" type="image/x-icon">
  <link rel="apple-touch-icon" href="/assets/img/weblogo.png">
  <link rel="manifest" href="/manifest.json">
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
      <form action="/assets/server/signup.php" method="post">
        <div class="field">
          <input type="text" id="username" placeholder="Enter Username" name="username" autocomplete="off">
          <div id="Username" class="__error"></div>
        </div>
        <div class="field">
          <input type="number" id="rollcode" placeholder="Enter Rollcode" min="0" name="rollcode">
          <div id="Rollcode" class="__error"></div>
        </div>
        <div class="field">
          <input type="number" id="rollno" placeholder="Enter Rollno" min="0" name="rollno" autocomplete="off">
          <div id="Rollno" class="__error"></div>
        </div>
        <div class="field">
          <input type="date" name="dob" id="dob">
          <div id="DOB" class="__error"></div>
        </div>
        <div class="field">
          <button>SIGNUP</button>
        </div>
        <div class="field" style="text-align:center;">
          <span>Already have Account?</span>
          <a href="/login/">Login</a>
        </div>
      </form>
    </div> 
  </div>
</body>
</html>