<?php
require '../server/logged.php';
isLogged(null, function() {
  header("location:/admin/");
  die();
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Shahzadi Afsara"/>
  <title>ASOT – Login into Admin Panel</title>
  <link rel="shortcut icon" href="/assets/img/weblogo.png" type="image/x-icon">
  <link rel="apple-touch-icon" href="/assets/img/weblogo.png">
  <meta name="theme-color" content="#6a6af1"/>
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
      <div><h1>Login into admin of (ASOT) – <?php echo date('Y'); ?></h1></div>
      <div class="subtitle">Bihar Board Annual Secondry Objective Test (ASOT) – <?php echo date('Y'); ?> For Intermediate Examination</div>
    </div>
  </div>
  <div class="container">
    <div class="form-container">
      <form action="/admin/server/login.php" method="post">
        <div class="field">
          <div style="position:relative;">
            <input type="password" id="password" name="pass-key" placeholder="ENTER PASSKEY" maxLength="50" autocomplete="off">
            <div class="show-hide">Show</div>
          </div>
          <div id="Password" class="__error"></div>
        </div>
        <div class="field">
          <button>login admin</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>