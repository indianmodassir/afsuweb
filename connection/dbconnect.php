<?php

declare(strict_types=1);

use Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';

Dotenv::process(__DIR__, ['../.env', '.env'])->safeLoad();


$DSN  = sprintf("%s:host=%s;dbname=%s;", $_ENV['DB_CONNECTION'], $_ENV['DB_HOST'], $_ENV['DB_DATABASE']);

try {
  $conn = new \PDO($DSN, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
} catch(PDOException $e)
{
  die("Database not connected!");
}
?>