<?php

declare(strict_types=1);

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
  die("Something went Wrong!");
}

if (!(isset($_POST["rollno"]) && isset($_POST["password"]))) {
  die("Bad Request!");
}

$rollno   = (int) $_POST["rollno"];
$password = $_POST["password"];

$r_rollno = '/^[0-9]{3,8}$/';

require 'auth/logged.php';
require '../../connection/dbconnect.php';

$exports = [];

header("Content-Type: application/json");

$stmt = $conn->prepare("SELECT * FROM `users` WHERE `rollno` = ?");
$stmt->execute([$rollno]);
if ($stmt->rowCount()===1) {
  $data = $stmt->fetch(PDO::FETCH_ASSOC);
  if (password_verify($password, $data["password"])) {
    $exports["status"] = true;
    logged($rollno, $data["rollcode"]);
  } else {
    $exports["id"] = "#Password";
    $exports["msg"] = "Incorrect password!";
  }
} else {
  $exports["id"] = "#Rollno";
  $exports["msg"] = "Rollno does not exists!";
}

die(json_encode($exports));
?>