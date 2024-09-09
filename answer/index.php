<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Shahzadi Afsara"/>
  <title>ASOT – Download Answer Key</title>
  <link rel="stylesheet" href="/assets/css/app.css">
  <script src="/library/jqrony-min.js"></script>
  <script src="/assets/js/result-answer.js" defer></script>
</head>
<body>
  <div class="nav">
    <div class="leftbar">
      <div><img src="/assets/img/weblogo.png" alt="Web Logo" width="70" height="70"></div>
    </div>
    <div style="text-align:center;flex:1;">
      <div><h1>Annual Secondry Objective Test (ASOT) – <?php echo date('Y'); ?></h1></div>
      <div class="subtitle">Bihar Board Annual Secondry Objective Test (ASOT) For Intermediate Examination Download & Check Answer Key</div>
    </div>
  </div>
  <div class="container">
  <div class="form-container">
      <form action="/assets/server/answer.php" method="post">
        <div class="field">
          <input type="number" id="rollno" name="rollno" placeholder="Enter rollno" min="0" autocomplete="off">
          <div id="Rollno" class="__error"></div>
        </div>
        <div class="field">
          <input type="date" name="dob" id="dob">
          <div id="DOB" class="__error"></div>
        </div>
        <div class="field">
          <div class="captcha">
            <input type="hidden" id="_captcha" name="captcha" autocomplete="off">
            <span class="captcha-1"></span>
            <span>+</span>
            <span class="captcha-2"></span>
            <span>=</span>
            <span><input type="number" id="captcha" name="captcha-input" max="199" min="1" autocomplete="off"></span>
          </div>
          <div id="Captcha" class="__error"></div>
        </div>
        <div class="field">
          <button>Show Answer Key</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>