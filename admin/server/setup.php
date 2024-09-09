<?php

declare(strict_types=1);

require $_SERVER["DOCUMENT_ROOT"] . '/connection/dbconnect.php';
require '../../dist/Asot.php';
date_default_timezone_set("Asia/Kolkata");
$exports = [];

$Asot = new Asot($conn);

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
  die("Bad Request!");
}

if (!(isset($_POST["subject"]) && isset($_POST["start-time"]) && isset($_POST["from"]))) {
  die("Missing POST Data!");
}

$rsubject = '/([^_]+)(_([^_]+))?/';
$subject    = preg_replace($rsubject, '$1 $3', trim($_POST["subject"]));
$from       = (int) $_POST["from"];
$to         = $from + 100;
$start_time = $_POST["start-time"];
$subject    = trim($subject);
$table      = explode(" ", $subject)[0];

if ($from >= $to) {
  $exports["type"] = "error";
  $exports["msg"]  = "Invalid question range!";
}

$start_time = date("m/d/Y ") . $start_time;
$start_on = strtotime($start_time);

if ((time() + 60) >= $start_on) {
  $exports["type"] = "error";
  $exports["msg"]  = "Invalid conducted timestamp!";
}

if (!empty($exports)) die(json_encode($exports));

$stmt = $conn->prepare("SELECT * FROM `{$table}` WHERE `id` BETWEEN {$from} AND {$to} LIMIT 100");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->rowCount() > 0 && $Asot->set($subject, $data, $start_on, $exports);
die(json_encode($exports));
?>