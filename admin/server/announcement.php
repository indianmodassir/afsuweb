<?php

declare(strict_types=1);
header("Content-Type: application/json");

require $_SERVER["DOCUMENT_ROOT"] . '/connection/dbconnect.php';
$exports = [];

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
  die("Bad Request!");
}

if (!(isset($_POST["col"]) && isset($_POST["type"]))) {
  die("Missing POST Data!");
}

$col   = trim($_POST["col"]);
$value = trim($_POST["type"]);

$stmt = $conn->prepare("UPDATE `admin` SET `{$col}` = ? WHERE `admin`.`auth` = ?");
if ($stmt->execute([$value, '_admin'])) {
  $exports["type"]   = "success";
  $exports["msg"]    = "Announcement data has been Updated!";
  $exports["class"]  = ".{$col}";
  $exports["value"]  = !$value ? "Deactivated" : "Activated";
} else {
  $exports["type"]   = "error";
  $exports["msg"]    = "An error accurred in Database";
}
die(json_encode($exports));
?>