<?php

declare(strict_types=1);

function userExists($conn, $rollcode, $rollno, $callback) {
  $stmt = $conn->prepare("SELECT * FROM `users` WHERE `rollcode` = ? AND `rollno` = ?");
  $stmt->execute([$rollcode, $rollno]);
  if ($stmt->rowCount()>0) {
    $callback($conn, $stmt->fetch(PDO::FETCH_ASSOC), $rollcode, $rollno);
  }
}
?>