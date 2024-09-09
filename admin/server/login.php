<?php

declare(strict_types=1);

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
  die("Bad Request!");
}

if (!isset($_POST["pass-key"])) {
  die("Missing POST Data!");
}

require 'logged.php';

header("Content-Type: application/json");

$passkey = $_POST["pass-key"];
isLogged(null, function($_, $logged, $d, $passkey) {
  !$logged && die(json_encode([
    'id'  => '#Password',
    'msg' => 'Incorrect Pass-Key!'
  ]));
  if ($logged) {
    $_SESSION['_s'] = base64_encode($passkey);
    die(json_encode(['status'=>true]));
  }
}, $passkey);
?>