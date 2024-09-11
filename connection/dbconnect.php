<?php

declare(strict_types=1);

require $_SERVER["DOCUMENT_ROOT"].'/vendor/autoload.php';
\Pointenv\Pointenv::quickLoad();

$DSN  = sprintf("%s:host=%s;dbname=%s;", "mysql", "sql212.infinityfree.com", "if0_37273804_asot");

try {
  $conn = new \PDO($DSN, "if0_37273804", "Bo8H7dFQTF5Ix");
} catch(PDOException $e)
{
  die("Database not connected!");
}
?>