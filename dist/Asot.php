<?php

declare(strict_types=1);

require $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";
use Path\Path;

class Asot
{
  private $dir;
  private $conn;
  public function __construct($conn)
  {
    $this->conn = $conn;
    $this->dir = $_SERVER["DOCUMENT_ROOT"] . "/data/";
  }

  public function get_all_users($isAll=false) {
    $output = [];
    $data = [];
    $stmt = $this->conn->prepare("SELECT * FROM `users`");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $data = $records;
      foreach($records as $record)
      {
        $output[] = "AFSU_".$record["rollcode"].$record["rollno"];
      }
    }
    return !!$isAll ? $data : $output;
  }

  public function checkExists($table, $identifier) {
    $stmt = $this->conn->prepare("SELECT * FROM `{$table}` WHERE `subcode` = ?");
    $stmt->execute([$identifier]);
    return $stmt->rowCount() > 0;
  }

  public function set($subject, $questions, $start, &$exports) : bool {
    $CRLF  = '/([\r\n]\s\s)\s*/';
    $setup = [];
    $setup["subject"]        = $subject;
    $setup["delay"]          = "1 Hour 15 Minutes";
    $setup["total_question"] = 100;
    $setup["full_marks"]     = 100;
    $setup["questions"]      = [];
    $error = false;

    $subject_code  = sha1($subject);
    $fifty_minutes = 60*15;
    $hour = $fifty_minutes * 4;
    $duration = $hour * $fifty_minutes;

    $setup["subcode"] = $subject_code;

    if ($this->checkExists("tests", $subject_code)) {
      $exports["type"] = "error";
      $exports["msg"]  = sprintf("Setup [%s] already exists!", strtoupper($subject));
      return false;
    }

    $this->reset_previous_setup();

    $stmt = $this->conn->prepare("INSERT INTO `tests` (`subject`,`start`,`subcode`,`duration`) VALUES (?,?,?,?)");
    if (!$stmt->execute([$subject, $start, $subject_code, $duration])) {
      return false;
    }

    $stmt = $this->conn->prepare("UPDATE `admin` SET `conducted` = 'yes' WHERE `admin`.`id` = 1");
    if (!$stmt->execute()) {
      return false;
    }
  
    foreach($questions as $question) {
      $group = [];
      $options = json_decode($question["options"], true);
      $group[] = array_search($question["answer"], $options);

      $question["group"] = $group;
      $question["choosed"] = "";
      array_push($setup["questions"], $question);
    }

    $questions = $setup["questions"];
    $allUser   = $this->get_all_users();

    foreach($allUser as $subdir) {
      shuffle($questions);

      $question_number = 0;
      foreach($setup["questions"] as $i=>$question) {
        $question_number++;
        $questions[$i]["quesnum"] = $question_number;
      }

      $setup["questions"] = $questions;

      $setup_json_data = json_encode($setup, JSON_PRETTY_PRINT);
      $path = Path::resolve($this->dir, $subdir, "question.setup.json");
      if (!file_put_contents($path, $setup_json_data)) {
        $error = true;
      }
    }

    if (!$error) {
      $exports["type"] = "success";
      $exports["msg"]  = sprintf("[%s] has been SET!", strtoupper($subject));
    }

    return $error;
  }

  public function reset_previous_setup(&$exports=[]) {
    $stmt = $this->conn->prepare("UPDATE `admin` SET `conducted` = '' WHERE `admin`.`id` = 1");
    $stmt->execute();
    $stmt = $this->conn->prepare("TRUNCATE TABLE `tests`");
    $stmt->execute();
    foreach($this->get_all_users() as $subdir) {
      $path = Path::resolve($this->dir, $subdir, "question.setup.json");
      file_exists($path) && unlink($path);
    }

    $exports["type"] = "success";
    $exports["msg"]  = "Previous setup has been reset!";
  }

  public function get_active_user() {
    $userInfo = [];
    !function_exists('isLogged') && require $_SERVER["DOCUMENT_ROOT"]."/assets/server/auth/logged.php";
    isLogged($this->conn, function($conn, $rollno, $token /* token sha1 encoded rollcode */) use (&$userInfo) {
      $stmt = $conn->prepare("SELECT * FROM `users` WHERE `rollno` = ?");
      $stmt->execute([$rollno]);
      if ($stmt->rowCount() > 0) {
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($records as $record) {
          $matcher_token = sha1((string)$record["rollcode"]);
          if ($matcher_token===$token) {
            $userInfo = $record;
            break;
          }
        }
      }
    });
    return $userInfo;
  }

  public function get_tests($subcode) {
    $stmt = $this->conn->prepare("SELECT * FROM `tests` WHERE `subcode` = ?");
    $stmt->execute([$subcode]);
    if ($stmt->rowCount() > 0) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }
  }

  public function update_marks($column, $rollno, $rollcode) {
    $stmt = $this->conn->prepare("UPDATE `users` SET `{$column}` = `{$column}` + 1 WHERE `users`.`rollno` = ? AND `users`.`rollcode` = ?");
    if ($stmt->execute([$rollno, $rollcode])) {
      return true;
    }

    return false;
  }

  public function attempted($rollcode, $rollno) {
    $stmt = $this->conn->prepare("UPDATE `users` SET `present` = 'YES' WHERE `users`.`rollcode` = ? AND `users`.`rollno` = ?");
    $stmt->execute([$rollcode, $rollno]);
  }
}
?>