<?php

function result($hindi, $urdu, $history, $geography, $political_science, $economics, $username, $dob, $UID, $rollcode, $rollno, $total, $division, $present) {
  date_default_timezone_set("Asia/Kolkata");
  $w_hindi             = to_words(str_split($hindi));
  $w_urdu              = to_words(str_split($urdu));
  $w_history           = to_words(str_split($history));
  $w_geography         = to_words(str_split($geography));
  $w_political_science = to_words(str_split($political_science));
  $w_economics         = to_words(str_split($economics));
  $year = date("Y");
  $date = date("d/m/Y");

  return "<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"UTF-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <title>Document</title>
  <style>
    .result-preview {
      flex-direction: column;
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      overflow: hidden;
      position: relative;
    }
    .result-preview::after {
      content: \"AFSARA WEB\";
      position: absolute;
      font-size: 6rem;
      color: #ccc;
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      z-index: -1;
      align-items: center;
      transform: rotate(-45deg);
    }
    table .header {
      text-align: center;
      font-weight: 600;
      padding: 8px 4px;
      color: #fff;
      background-color: #29ad29;
      text-transform: uppercase;
      font-size: 15px;
    }
    table {
      font-size: 14px;
      width: 100%;
      border: 1px solid #b1abab;
    }
    table.collapse {
      border-collapse:collapse;
      margin-top: -1px;
      border-top-color:transparent;
    }
    .upper {
      text-transform: uppercase;
    }
    td {
      position: relative;
      padding: 8px;
      font-weight: 500;
    }
    .center {
      text-align: center;
    }
    table span {
      font-weight: 500;
      color: #4d4d6b;
    }
    .fit {
      width: 0px;
      white-space: nowrap;
    }
    .eq-fit {
      width: calc(100% / 3);
    }
  </style>
</head>
<body>
  <div class=\"result-preview\" style=\"max-width:900px;margin:0 auto;\">
    <table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;border-collapse:collapse;\">
      <tr>
        <td colspan=\"2\" class=\"header\">
          <div>Annual Secondry Objective Test Result – {$year}</div>
          <div style=\"font-size:12px;text-transform:initial;\">Bihar Board Annual Secondry Objective Test (ASOTR) For Intermediate Examination Declared Result – {$year}</div>
        </td>
      </tr>
      <tr>
        <td class=\"fit\"><span>अनोखा पहचान Unique ID</span></td>
        <td colspan=\"5\">{$UID}</td>
      </tr>
      <tr>
        <td class=\"fit\"><span>उपयोक्तानाम Username</span></td>
        <td colspan=\"5\">{$username}</td>
      </tr>
      <tr>
        <td class=\"fit\"><span>उपस्थित Present</span></td>
        <td colspan=\"5\">{$present}</td>
      </tr>
      <tr>
        <td class=\"fit\"><span>परीक्षण प्रकार Test Type</span></td>
        <td colspan=\"5\">ONLINE</td>
      </tr>
      <tr>
        <td colspan=\"5\"><span>परीक्षण प्रकार Test Type:</span> ANNUAL SECONDRY OBJECTIVE TEST (ASOT) – {$year}</td>
      </tr>
    </table>
    <table class=\"collapse\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;\">
      <tr>
        <td class=\"center\"><div><span>रौल कोड Roll Code</span></div><div>{$rollcode}</div></td>
        <td class=\"center\"><div><span>रौल नंO Roll No.</span></div><div>{$rollno}</div></td>
        <td class=\"center\"><div><span>जन्म तिथि Date of Birth</span></div><div>{$dob}</div></td>
      </tr>
    </table>
    <table class=\"collapse\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;\">
      <tr>
        <td class=\"center\"><span>SUBJECT</span></td>
        <td class=\"center\"><span>FULL MARKS</span></td>
        <td class=\"center\"><span>PASS MARKS</span></td>
        <td class=\"center\"><span>TOTAL</span></td>
        <td class=\"center\"><span>MARKS IN WORDS</span></td>
      </tr>
      <tr>
        <td style=\"border-bottom:none;\">LL - HINDI</td>
        <td style=\"border-bottom:none;\" class=\"center\">100</td>
        <td style=\"border-bottom:none;\" class=\"center\">030</td>
        <td style=\"border-bottom:none;\" class=\"center\">{$hindi}</td>
        <td style=\"border-bottom:none;\" class=\"center upper\">{$w_hindi}</td>
      </tr>
      <tr>
        <td style=\"border-bottom:none;\">MB - URDU</td>
        <td style=\"border-bottom:none;\" class=\"center\">100</td>
        <td style=\"border-bottom:none;\" class=\"center\">030</td>
        <td style=\"border-bottom:none;\" class=\"center\">{$urdu}</td>
        <td style=\"border-bottom:none;\" class=\"center upper\">{$w_urdu}</td>
      </tr>
      <tr>
        <td style=\"border-bottom:none;\">GEOGRAPHY</td>
        <td style=\"border-bottom:none;\" class=\"center\">100</td>
        <td style=\"border-bottom:none;\" class=\"center\">030</td>
        <td style=\"border-bottom:none;\" class=\"center\">{$geography}</td>
        <td style=\"border-bottom:none;\" class=\"center upper\">{$w_geography}</td>
      </tr>
      <tr>
        <td style=\"border-bottom:none;\">HISTORY</td>
        <td style=\"border-bottom:none;\" class=\"center\">100</td>
        <td style=\"border-bottom:none;\" class=\"center\">030</td>
        <td style=\"border-bottom:none;\" class=\"center\">{$history}</td>
        <td style=\"border-bottom:none;\" class=\"center upper\">{$w_history}</td>
      </tr>
      <tr>
        <td style=\"border-bottom:none;\">POLITICAL SCIENCE</td>
        <td style=\"border-bottom:none;\" class=\"center\">100</td>
        <td style=\"border-bottom:none;\" class=\"center\">030</td>
        <td style=\"border-bottom:none;\" class=\"center\">{$political_science}</td>
        <td style=\"border-bottom:none;\" class=\"center upper\">{$w_political_science}</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan=\"3\" style=\"text-align:right;\"><span>AGGREGATE</span></td>
        <td class=\"center\">{$total}</td>
        <td class=\"center\" rowspan=\"2\"><div style='position:absolute;top:3px;left:4px;'><span>RESULT</span></div><div>{$division} DIV.</div></td>
      </tr>
      <tr>
        <td style=\"border-bottom:none;\">ECONOMICS</td>
        <td style=\"border-bottom:none;\" class=\"center\">100</td>
        <td style=\"border-bottom:none;\" class=\"center\">030</td>
        <td style=\"border-bottom:none;\" class=\"center\">{$economics}</td>
      </tr>
    </table>
    <table class=\"collapse\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;\">
      <tr>
        <td>
          <div style=\"display:flex;justify-content:space-between;align-items:center;\">
            <div><span>Date: {$date}</span></div>
            <div style=\"text-align:center;\">
              <div><i>Md Modassir</i></div>
              <div><span>परीक्षा नियंत्रक</span></div>
              <div><span>Signature of Controller</span></div>
            </div>
          </div>
        </td>
      </tr>
    </table>
  </div>
  <div class=\"res-footer\">
    <div><button onclick='window.location.reload();'>CHECK AGAIN</button><button onclick='window.print();'>PRINT</button></div>
  </div>
</body>
</html>";
}

?>