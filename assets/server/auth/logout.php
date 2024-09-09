<?php
ob_start();
session_start();

if (!isset($_GET["ts"])) die("Bad Request!");

setcookie('_auth', '', time() - (60*60*24), '/');
setcookie('_token', '', time() - (60*60*24), '/');
setcookie('session', '', time() - (60*60*24), '/');

session_destroy();

header("location:/");
die();
?>