<?php
ini_set('error_reporting', 1);
header("Cache-Control: no-cache, no-store, must-revalidate, max-age=0");
header("Cache-Control: pre-check=0, post-check=0", false);
header("Pragma: no-cache");
date_default_timezone_set("Asia/Kolkata");
require 'server/logged.php';
$conn = null;
$data = null;
if (!isLogged()) {
  header("location:/admin/auth/");
  die();
}
isLogged(null, function($PDO, $_, $res) {
  global $data;
  global $conn;
  $data = $res;
  $conn = $PDO;
});

$conduct = !$data["conducted"] ? "Deactivated" : "Activated";
$result  = !$data["act_result"] ? "Deactivated" : "Activated";
$answer  = !$data["act_answer"] ? "Deactivated" : "Activated";

if ($_GET['rel']!='tab') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="Shahzada Modassir"/>
<title>ASOT – Admin Panel</title>
<link rel="stylesheet" href="css/app.css">
<script src="/library/jqrony-min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/layout-resizer/lib/layout-resizer.js"></script>
</head>
<body>
<div class="content">
<div class="leftnav">
<div class="sash"></div>
<div class="profile">
<div class="prefix">
<div><div class="pro"><img src="/assets/img/admin.jpg" alt="Modassir"></div></div>
<div class="user"><strong><?=$data["username"];?></strong></div>
</div>
</div>
<div class="">
<ul>
<li><a href="./">ASOT Question Setup</a></li>
<li><a href="announcement">ASOT Announcement</a></li>
<li><a href="insert">ASOT Insert Question</a></li>
</ul>
</div>
</div>
<div class="preview">
<?php } ?>