<?php

$dir = $_SERVER["DOCUMENT_ROOT"];
require $dir.'/assets/server/auth/logged.php';
require $dir.'/dist/Asot.php';
require $dir.'/connection/dbconnect.php';
require $dir.'/assets/view/questions.php';

use Path\Path;

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
  die("Bad Request!");
}

date_default_timezone_set("Asia/Kolkata");

header("Content-Type: application/json");

isLogged($conn, function($conn) use ($dir) {
  $Asot = new Asot($conn);
  $user_info = $Asot->get_active_user();
  $path = Path::resolve($dir, "data", "AFSU_".$user_info["rollcode"].$user_info["rollno"], "question.setup.json");
  $path = preg_replace('/\\\/', '/', $path);

  if (!file_exists($path)) {
    die(json_encode([
      "type" => "error",
      "html" => unavailable("ASOT")
    ]));
  }

  $data = file_get_contents($path);
  $json = json_decode($data, true);

  if (!($info=$Asot->get_tests($json["subcode"]))) {
    die(json_encode([
      "type" => "error",
      "html" => unavailable("ASOT")
    ]));
  }

  $hasTime = (int) $info["duration"] - time();

  if ($hasTime <= 0) {
    die(json_encode([
      "type" => "error",
      "html" => unavailable("ASOT")
    ]));
  }

  $start = (int) $info["start"];

  if ($start > time()) {
    die(json_encode([
      "timer" => date("h:i:s", $start)
    ]));
  }

  if (isset($_POST["load"])) {

    $attach = ["hindi"=> "LL – ", "urdu"=> "MB – "];

    $Asot->attempted($user_info["rollcode"], $user_info["rollno"]);

    $subject = $json["subject"];
    $subject = ($attach[$subject] ?? '').$subject;
    $questions = $json["questions"];

    session_start();
    $_SESSION["running"] = true;
    die(json_encode([
      "timer" => date("h:i:s", (int)$info["duration"]),
      "question"=> viewQuestion($subject, $questions)
    ]));
  }
});
?>