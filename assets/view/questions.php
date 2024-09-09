<?php

declare(strict_types=1);

function viewQuestion($subject, $questions) {

  $html_ques = "";
  foreach($questions as $i=>$question) {
    $options = json_decode($question["options"], true);
    $choosed = $question["choosed"] ? " disabled" : "";
    $checks  = ['','','',''];
    $checks[$question["choosed"]] = "checked";
    $html_ques .= "<li class=\"ques{$choosed}\">
          <div>{$question['question']}</div>
          <ul class=\"opts\">
            <li>
              <label class=\"radio\"><input class=\"opt\" type=\"radio\" name=\"opt-{$question['id']}\" hidden data-index=\"0\" value=\"{$question['id']}\" {$checks[0]}></label>
              <div class=\"opt-text\">{$options[0]}</div>
            </li>
            <li>
              <label class=\"radio\"><input class=\"opt\" type=\"radio\" name=\"opt-{$question['id']}\" hidden data-index=\"1\" value=\"{$question['id']}\" {$checks[1]}></label>
              <div class=\"opt-text\">{$options[1]}</div>
            </li>
            <li>
              <label class=\"radio\"><input class=\"opt\" type=\"radio\" name=\"opt-{$question['id']}\" hidden data-index=\"2\" value=\"{$question['id']}\" {$checks[2]}></label>
              <div class=\"opt-text\">{$options[2]}</div>
            </li>
            <li>
              <label class=\"radio\"><input class=\"opt\" type=\"radio\" name=\"opt-{$question['id']}\" hidden data-index=\"3\" value=\"{$question['id']}\" {$checks[3]}></label>
              <div class=\"opt-text\">{$options[3]}</div>
            </li>
          </ul>
        </li>";
  }

  return "<div style=\"text-transform:uppercase;text-align:center;padding:22px 0;\">
      <h1 style=\"font-size:26px;\">{$subject}</h1>
    </div>
    <div class=\"\">
      <div>
        <div class=\"flex-justify\">
          <div>
            <div>कुल प्रश्नों की संख्या: 50 + 50</div>
            <div><strong>Total No of Question: 100</strong></div>
          </div>
          <div style=\"text-align:end;\">
            <div>परीक्षण प्रकार: ऑनलाइन</div>
            <div><strong>Test Type: Online</strong></div>
          </div>
        </div>
        <div class=\"flex-justify\" style=\"border-bottom: 1px solid #666;\">
          <div>
            <div>( समय: 1 घंटा 15 मिनट )</div>
            <div>[ Time: 1 Hour 15 Minutes ]</div>
          </div>
          <div style=\"text-align:end;\">
            <div>( पूर्णांक: 100 )</div>
            <div>[ Full Marks: 100 ]</div>
          </div>
        </div>
      </div>
    </div>
    <div class=\"ques-ins\" style=\"border-bottom: 1px solid #666;padding-top:11px;\">
      <i><strong>Instructions for the candidates:</strong></i>
      <ul>
        <li><strong>Candidates must enter his / her Question Booklet Serial No. (10 Digits) in the Checkbox Of Answer.</strong></li>
        <li>Candidates are required to give their answers in their own words as far as practicable.</li>
        <li>Figure in the left hand margin indicate full marks.</li>
        <li>15 minutes of extra time have been allotted for the candidates to read the questions carefully.</li>
      </ul>
    </div>
    <div class=\"questions\"><ul>{$html_ques}</ul></div>";
}
?>