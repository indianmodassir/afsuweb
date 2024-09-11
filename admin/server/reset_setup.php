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

if (!isset($_POST["reset"])) {
  die("Missing POST Data!");
}

header("Content-Type: application/json");

$Asot->reset_marks();
$Asot->reset_previous_setup($exports);
die(json_encode($exports));
?>