<?php

declare(strict_types=1);

require $_SERVER["DOCUMENT_ROOT"].'/vendor/autoload.php';
\Pointenv\Pointenv::quickLoad();

$DSN  = sprintf("%s:host=%s;dbname=%s;", getenv("DB_CONNECTION"), getenv("DB_HOST"), getenv("DB_DATABASE"));

try {
  $conn = new \PDO($DSN, getenv("DB_USERNAME"), getenv("DB_PASSWORD"));
} catch(PDOException $e)
{
  die("Database not connected!");
}
?>