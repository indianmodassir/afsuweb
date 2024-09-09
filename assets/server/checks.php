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


  $data = file_get_contents($path);
  $json = json_decode($data, true);

  $column   = explode(" ", $json["subject"])[0];
  $questions = $json["questions"];

  $choosed  = trim($_POST["choosed"]);
  $id = trim($_POST["id"]);

  $isSuccess=false;

  foreach($questions as $i=>$question) {
    if ($question["id"] == $id) {
      $json["questions"][$i]["choosed"]=&$choosed;
      $isSuccess=true;
      if (in_array($choosed, $question["group"])) {
        $info = $Asot->get_active_user();
        $Asot->update_marks($column, $info["rollno"], $info["rollcode"]);
      }
      break;
    }
  }

  $questions = json_encode($json, JSON_PRETTY_PRINT);
  if ($isSuccess && file_put_contents($path, $questions)) {
    die(json_encode(["status"=>"success"]));
  }
});
?>