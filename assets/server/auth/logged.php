<?php
function logged($rollno, $rollcode) : void
{
  $session  = base64_encode($rollno);
  $rollcode = sha1($rollcode);
  $rollno   = sha1($rollno);

  if (!isset($_SESSION)) {
    session_start();
  }

  $_SESSION['_token']  = $rollcode;
  $_SESSION['session'] = $session;
  $_SESSION['_auth']   = $rollno;

  setcookie('_token', $rollcode, time() + (60*60*24), "/");
  setcookie('_auth', $rollno, time() + (60*60*24), "/");
  setcookie('session', $session, time() + (60*60*24), "/");
}

function ForceFn() {
  //
}

function isLogged($conn, $callback = 'ForceFn') : bool
{
  if (!isset($_SESSION)) {
    session_start();
  }

  $token   = $_SESSION['_token'] ?? $_COOKIE["_token"] ?? false;
  $auth    = $_SESSION['_auth'] ?? $_COOKIE["_auth"] ?? false;
  $session = $_SESSION['session'] ?? $_COOKIE["session"] ?? '';
  $session = base64_decode($session);
  
  if (!($token && $auth && $session && sha1($session)===$auth)) {
    return false;
  }

  $stmt = $conn->prepare("SELECT * FROM `users` WHERE `rollno` = ?");
  $stmt->execute([$session]);

  if ($stmt->rowCount()===1) {
    $callback($conn, $session, $token, $auth);
    return true;
  }

  return false;
}
?>