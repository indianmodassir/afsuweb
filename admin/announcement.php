<?php
require 'common/header.php';
?>
<div class="form-container">
  <div class="status"></div>
  <form action="server/announcement.php" method="post">
    <div class="field" style="align-items:center;padding-left:4px;">
      <div>
        <input type="radio" name="type" id="active" style="position:relative;" value="true" checked>
        <label for="active">Active</label>
      </div>
      <div>
        <input type="radio" name="type" id="deactive" style="position:relative;" value="">
        <label for="deactive">Deactive</label>
      </div>
    </div>
    <div class="field">
      <select name="col" id="announcement">
        <option value="conducted">Test Conducted</option>
        <option value="act_result">Declare Result</option>
        <option value="act_answer">Release Answer Key</option>
      </select>
      <div><button>UPDATE</button></div>
    </div>
  </form>
  <div style="margin: 44px 0px 22px 0px;">
    <table border="1">
      <tr>
        <td colspan="3" class="center header">Announcement Details</td>
      </tr>
      <tr>
        <td class="space-between act_result"><span>Result:</span><div><?=$result;?></div></td>
        <td class="space-between act_answer"><span>Answer Key:</span><div><?=$answer;?></div></td>
        <td class="space-between conducted"><span>Test Conduct:</span><div><?=$conduct;?></div></td>
      </tr>
    </table>
  </div>
</div>
<script src="client/app.js"></script>
<?php require 'common/footer.php'; ?>