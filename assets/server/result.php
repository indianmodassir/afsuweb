<?php

declare(strict_types=1);

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
  die("Bad Request!");
}

if (!(isset($_POST["captcha"]) && isset($_POST["rollno"]) && isset($_POST["rollcode"]) && isset($_POST["captcha-input"]))) {
  die("Missing form Data");
}

require '../../connection/dbconnect.php';
require '../view/result.php';
require '../view/unavailable.php';

$captcha_input = (int) $_POST["captcha-input"];
$rollcode = (int) $_POST["rollcode"];
$rollno   = (int) $_POST["rollno"];
$captcha  = (int) $_POST["captcha"];

$r_dob      = '/^(?:([\d]{4})-([\d]{2})-([\d]{2}))$/';
$r_captcha  = '/^(?=[1-9])([0-9]{2,3}|199)$/';
$r_rollcode = '/^[0-9]{5}$/';
$r_rollno   = '/^[0-9]{3,8}$/';

$data = array(
  'Rollcode' => [$rollcode, $r_rollcode],
  'Rollno'   => [$rollno, $r_rollno],
  'Captcha'  => [$captcha_input, $r_captcha]
);

$exports = [];

foreach($data as $id=>$value) {
  if (!$value[0]) {
    $exports['id'] = "#".$id;
    $exports['msg'] = sprintf("Field '%s' is Required!", $id);
    break;
  }
  if (!preg_match($value[1], (string) $value[0])) {
    $exports['id'] = "#".$id;
    $exports['msg'] = sprintf("Invalid '%s'", $id);
    break;
  }
}

if ($captcha !== $captcha_input && empty($exports)) {
  $exports["id"] = "#Captcha";
  $exports["msg"] = "Invalid Captcha!";
}

function to_words($marks, &$outputs=[]) {
  $words = ["zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten"];

  if (sizeof($marks)===1 && $marks[0]==0) {
    return "–";
  }
  
  if (empty($marks)) {
    return join(" ", $outputs);
  }

  $mark = array_shift($marks);
  array_push($outputs, $words[$mark]);

  return to_words($marks, $outputs);
}

header("Content-Type: application/json");

!empty($exports) && die(json_encode($exports));

function checks($conn, $exports) {
  $stmt = $conn->prepare("SELECT * FROM `admin` WHERE `auth` = ?");
  $stmt->execute(["_admin"]);
  $data = $stmt->fetch(PDO::FETCH_ASSOC);
  $isActive = $data["act_result"] ?? false;
  if ($stmt->rowCount() <=0 || !$isActive) {
    $exports["data"] = unavailable("Result");
    die(json_encode($exports));
  }
}

checks($conn, $exports);

function setDivision($subjects, $total) {
    $subjects = array_diff($subjects, ["0"]);
    $fullmark = 100;
    $passing  = 30;
    $maxvalue = count($subjects) * $fullmark;

    $top    = $maxvalue * 95 / $fullmark;
    $first  = $maxvalue * 60 / $fullmark;
    $second = $maxvalue * 30 / $fullmark;
    $third  = $second - 1;

    if ($total >= $top) {
        return "1vip";
    }
    else if ($total >= $first) {
        return "1st";
    }
    else if ($total >= $second) {
        return "2nd";
    }
    else if ($total <= $third) {
        return "3rd";
    }
};

$stmt = $conn->prepare("SELECT * FROM `users` WHERE `rollcode` = ?");
$stmt->execute([$rollcode]);
if ($stmt->rowCount() > 0) {
  $data              = $stmt->fetch(PDO::FETCH_ASSOC);
  $mt_rollno         = (int) $data["rollno"];
  $history           = $data["history"];
  $geography         = $data["geography"];
  $economics         = $data["economics"];
  $political_science = $data["political"];
  $hindi             = $data["hindi"];
  $urdu              = $data["urdu"];
  $dob               = preg_replace($r_dob, '$3/$2/$1', $data["dob"]);
  $username          = $data["username"];
  $UID               = $data["uid"];
  $present           = $data["present"];
  $total             = ($history + $geography + $economics + $political_science + $urdu + $hindi);
  $division          = setDivision([$hindi, $urdu, $history, $geography, $political_science], $total);

  if ($mt_rollno === $rollno) {
    $exports["data"] = result($hindi, $urdu, $history, $geography, $political_science, $economics, $username, $dob, $UID, $rollcode, $rollno, $total, $division, $present);
  } else {
    $exports["id"] = "#Rollno";
    $exports["msg"] = "Rollno does not exists!";
  }
} else {
  $exports["id"] = "#Rollcode";
  $exports["msg"] = "Rollcode does not exists!";
}

die(json_encode($exports));
?>