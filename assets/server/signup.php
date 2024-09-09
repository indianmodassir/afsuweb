<?php

declare(strict_types=1);

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
  die("Something went Wrong!");
}

if (!(isset($_POST["username"]) && isset($_POST["rollcode"]) && isset($_POST["rollno"]) && isset($_POST["dob"]))) {
  die("Bad Request!");
}

$username = trim($_POST["username"]);
$rollno   = (int) $_POST["rollno"];
$rollcode = (int) $_POST["rollcode"];
$dob      = (string) $_POST["dob"];
$username = strtoupper($username);

require 'auth/logged.php';
require '../../connection/dbconnect.php';
require 'exists.php';

$r_dob      = '/^(?:([\d]{4})-([\d]{2})-([\d]{2}))$/';
$r_rollcode = '/^[0-9]{5}$/';
$r_rollno   = '/^[0-9]{3,8}$/';
$r_username = '/^[a-z]{1}(([a-z0-9]{1,11})(\s[a-z0-9]{3,11})?)$/i';

$strip_dob  = preg_replace($r_dob, '$3$2$1', $dob);
$strip_name = substr($username, 0, 4);
$password   = password_hash($strip_name.$strip_dob, PASSWORD_BCRYPT);

$data = array(
  'Username' => [$username, $r_username],
  'Rollcode' => [$rollcode, $r_rollcode],
  'Rollno'   => [$rollno, $r_rollno],
  'DOB'      => [$dob, $r_dob]
);

$errors = [];

header("Content-Type: application/json");

userExists($conn, $rollcode, $rollno, function() {
  die(json_encode([
    'id'  => '#Rollno',
    'msg' => 'You\'re entered Rollcode and Rollno already exists.'
  ]));
});

foreach($data as $id=>$value) {
  if (!$value[0]) {
    $errors['id'] = "#".$id;
    $errors['msg'] = sprintf("Field '%s' is Required!", $id);
    break;
  }
  if (!preg_match($value[1], (string) $value[0])) {
    $errors['id'] = "#".$id;
    $errors['msg'] = sprintf("Invalid '%s'", $id);
    break;
  }
}

if (!empty($errors)) {
  die(json_encode($errors));
}

$uid = strtoupper(sha1((string)$rollno));
$uid = substr($uid, 0, 22);

$dir = '../../data/AFSU_' . (string) $rollcode . (string) $rollno;

$stmt = $conn->prepare("INSERT INTO `users` (`username`,`uid`,`rollno`,`rollcode`,`dob`,`password`) VALUES (?,?,?,?,?,?)");
if ($stmt->execute([$username, $uid, $rollno, $rollcode, $dob, $password]) && mkdir($dir)) {
  $errors["status"] = "success";
  $errors["msg"] = "Data inserted successfully!";
  logged($rollno, $rollcode);
} else {
  $errors["msg"] = "Database server Error!";
}

die(json_encode($errors));
?>