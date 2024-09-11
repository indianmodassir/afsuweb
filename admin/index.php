<?php
require 'common/header.php';
$stmt1 = $conn->prepare("SELECT * FROM `hindi`");
$stmt2 = $conn->prepare("SELECT * FROM `urdu`");
$stmt3 = $conn->prepare("SELECT * FROM `history`");
$stmt4 = $conn->prepare("SELECT * FROM `geography`");
$stmt5 = $conn->prepare("SELECT * FROM `political`");
$stmt6 = $conn->prepare("SELECT * FROM `economics`");
$stmt1->execute();
$stmt2->execute();
$stmt3->execute();
$stmt4->execute();
$stmt5->execute();
$stmt6->execute();
$t_hindi = $stmt1->rowCount();
$t_urdu = $stmt2->rowCount();
$t_history = $stmt3->rowCount();
$t_geography = $stmt4->rowCount();
$t_political = $stmt5->rowCount();
$t_economics = $stmt6->rowCount();
$max = max($t_hindi, $t_urdu, $t_history, $t_geography, $t_political, $t_economics);
$options = "";
for($i=1; $i <= $max; $i++) {
  $options .= "<option value=\"{$i}\">{$i}</option>";
}
?>
<div class="form-container">
  <ul style="display:flex;padding:2px;column-gap:11px;max-width:500px;margin-bottom:18px;">
    <li class="mrg-0 border">LL – Hin (<?=$t_hindi;?>)</li>
    <li class="mrg-0 border">MB – Urd (<?=$t_urdu;?>)</li>
    <li class="mrg-0 border">His (<?=$t_history;?>)</li>
    <li class="mrg-0 border">Geo (<?=$t_geography;?>)</li>
    <li class="mrg-0 border">Pol SC (<?=$t_political;?>)</li>
    <li class="mrg-0 border">Eco (<?=$t_economics;?>)</li>
  </ul>
  <div class="status"></div>
  <form action="server/setup.php" method="post">
    <div class="field">
      <select name="subject" id="subject">
        <option value="hindi">LL – Hindi ( हिंदी ) – <?=$t_hindi;?></option>
        <option value="urdu">MB - Urdu ( उर्दू ) – <?=$t_urdu;?></option>
        <option value="geography">Geography ( भूगोल ) – <?=$t_geography;?></option>
        <option value="history">History ( इतिहास ) – <?=$t_history;?></option>
        <option value="economics">Economics ( अर्थशास्त्र ) – <?=$t_economics;?></option>
        <option value="political_science">Political Science ( राजनीति विज्ञान ) – <?=$t_political;?></option>
      </select>
    </div>
    <div class="field">
      <input type="time" name="start-time" id="start" style="text-transform:uppercase;padding-left:2px;">
    </div>
    <div class="field">
      <select name="from">
        <option>––set from––</option>
        <?=$options;?>
      </select>
    </div>
    <div class="field">
      <button>set question</button>
      <button type="button" id="_reset" style="background-color: #ec2b2b;">Reset previous setup</button>
    </div>
  </form>
  <div class="">
    
  </div>
</div>
<script>
  $("#_reset").click(function(e) {
    $(".status").removeClass("error success").html("");
    $.ajax({
      url: "server/reset_setup.php",
      type: "POST",
      data: {reset: true},
      dataType: "json",
      success: function(res, s) {
        $(".status").addClass(res.type).html(res.msg);
        res.class && $(res.class).find("div").html(res.value);
      }
    });
  });
</script>
<script src="client/app.js"></script>
<?php require 'common/footer.php'; ?>