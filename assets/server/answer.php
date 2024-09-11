<?php

declare(strict_types=1);

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
  die("Something went Wrong!");
}

if (!(isset($_POST["rollno"]) && isset($_POST["dob"]) && isset($_POST["captcha"]) && isset($_POST["captcha-input"]))) {
  die("Bad Request!");
}

$exports  = [];
$icaptcha = (int) trim($_POST["captcha-input"]);
$captcha  = (int) trim($_POST["captcha"]);
$rollno   = (int) trim($_POST["rollno"]);
$dob      = trim($_POST["dob"]);

require '../../connection/dbconnect.php';

if ($captcha!==$icaptcha) {
  $exports["id"]  = "#Captcha";
  $exports["msg"] = "Invalid captcha code!";
}

!empty($exports) && die(json_encode($exports));

$stmt = $conn->prepare("SELECT * FROM `users` WHERE `rollno` = ? AND `dob` = ?");
$stmt->execute([$rollno, $dob]);
if ($stmt->rowCount() > 0) {
  echo 'done';
} else {
  $exports['type'] = "error";
  $exports['msg']  = "Invalid Rollno or DOB";
}
die(json_encode($exports));
?>