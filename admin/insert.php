<?php require 'common/header.php'; ?>
<div class="form-container">
  <div class="status"></div>
  <form action="server/insert.php" method="post">
    <div class="field">
      <select name="subject" id="subject">
        <option value="hindi">LL – Hindi हिंदी</option>
        <option value="urdu">MB - Urdu उर्दू</option>
        <option value="geography">Geography भूगोल</option>
        <option value="history">History इतिहास</option>
        <option value="economics">Economics अर्थशास्त्र</option>
        <option value="political_science">Political Science राजनीति विज्ञान</option>
      </select>
    </div>
    <div class="field">
      <textarea name="question" id="question" rows="6" placeholder="Enter Question प्रश्न दर्ज करें..."></textarea>
    </div>
    <div class="field">
      <input type="radio" name="answer" id="option_A">
      <input type="text" class="opts" name="option-a" placeholder="Option विकल्प (A)">
    </div>
    <div class="field">
      <input type="radio" name="answer" id="option_B">
      <input type="text" class="opts" name="option-b" placeholder="Option विकल्प (B)">
    </div>
    <div class="field">
      <input type="radio" name="answer" id="option_C">
      <input type="text" class="opts" name="option-c" placeholder="Option विकल्प (C)">
    </div>
    <div class="field">
      <input type="radio" name="answer" id="option_D">
      <input type="text" class="opts" name="option-d" placeholder="Option विकल्प (D)">
    </div>
    <div class="field">
      <button>Submit</button>
    </div>
  </form>
</div>
<script src="client/app.js"></script>
<?php require 'common/footer.php'; ?>