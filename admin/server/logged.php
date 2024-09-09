<?php
declare(strict_types=1);
ob_start();
function ForceFn() {}
function isLogged($conn=null, $callback='ForceFn', $key=null) {
  $isLogged = false;
  if (!$conn) {
    require $_SERVER["DOCUMENT_ROOT"] . '/connection/dbconnect.php';
  }

  if (!isset($_SESSION)) {
    session_start();
  }

  $_s = $_SESSION["_s"] ?? '';

  if ($_s) {
    $_s = base64_decode($_s);
  }

  if ($key) {
    $_s = $key;
  }

  $stmt = $conn->prepare("SELECT * FROM `admin` WHERE `auth` = '_admin'");
  $stmt->execute();

  if ($stmt->rowCount()===1) {
    $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
    if (password_verify($_s, $fetch["passkey"])) {
      unset($fetch["passkey"]);
      $callback($conn, true, $fetch, $_s);
      $isLogged = true;
    } else if ($key) {
      $callback($conn, false, [], $_s);
    }
  }

  return $isLogged;
}
?>