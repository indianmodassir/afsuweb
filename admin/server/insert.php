<?php

declare(strict_types=1);

require $_SERVER["DOCUMENT_ROOT"] . '/connection/dbconnect.php';

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
  die("Bad Request!");
}

if (!(isset($_POST["option-a"]) && isset($_POST["option-b"]) && isset($_POST["option-c"]) && isset($_POST["option-d"]) && isset($_POST["subject"]) && isset($_POST["question"]))) {
  die("Missing POST Data!");
}

$attached = ['hindi'=>'LL – ', 'urdu'=>'MB – '];
$rsubject = '/([^_]+)(_([^_]+))?/';

$exports = [];
if (!isset($_POST["answer"])) {
  $exports["type"] = "error";
  $exports["msg"] = "Please choose an correct answer?";
}

header("Content-Type: application/json");

$option1 = trim($_POST["option-a"]);
$option2 = trim($_POST["option-b"]);
$option3 = trim($_POST["option-c"]);
$option4 = trim($_POST["option-d"]);

$subject  = trim($_POST["subject"]);
$answer   = trim($_POST["answer"] ?? '');
$question = trim($_POST["question"]);

if (!($option1 && $option2 && $option3 && $option4 && $question)){
  $exports["type"] = "error";
  $exports["msg"]  = "An input field is Required!";
}

if (!empty($exports)) die(json_encode($exports));

function checkExistsQuestion($conn, $table, $question, $answer) {
  $stmt = $conn->prepare("SELECT * FROM `{$table}` WHERE `question` = ? AND `answer` = ?");
  $stmt->execute([$question, $answer]);
  if ($stmt->rowCount()>0) {
    die(json_encode([
      'type' => 'error',
      'msg'  => 'You\'re entered question already exists!'
    ]));
  }
}

$options = json_encode([$option1, $option2, $option3, $option4]);
$subject = preg_replace($rsubject, '$1 $2', $subject);
$table   = explode(" ", $subject)[0];
$subject = trim($subject);
$subject = ($attached[$subject] ?? '') . strtoupper($subject);

checkExistsQuestion($conn, $table, $question, $answer);

$stmt = $conn->prepare("INSERT INTO `{$table}` (`question`,`options`,`answer`) VALUES (?,?,?)");
if ($stmt->execute([$question, $options, $answer])) {
  $exports["type"]   = "success";
  $exports["status"] = true;
  $exports["msg"]    = "Data inserted successfully!";
} else {
  $exports["type"]   = "error";
  $exports["status"] = false;
  $exports["msg"]    = "An error accurred in Database";
}
die(json_encode($exports));
?>