<?php 
require("./functions.php");

$userCheck = mysql_query("SELECT * FROM users WHERE `email` = '".$_REQUEST["account"]."'");

if (mysql_num_rows($userCheck) == 1) {
  
  $user = mysql_fetch_assoc($userCheck);
  $sql = "SELECT * FROM errors WHERE `request` = '" . $_REQUEST["request"] . "' AND user_id = '" . $user["id"] . "'";
  $alreadyExists = mysql_query($sql);
  
  if (mysql_num_rows($alreadyExists) == 1) {
    echo "already exists";
  } else {
    $now = date("Y-m-d H:i:s");
    $sql = "INSERT INTO errors 
      (`request`,`referrer`,`timestamp`,`user_id`,`agent`) 
      VALUES('".$_REQUEST["request"]."','".$_REQUEST["referrer"]."','$now','".$user["id"]."','".$_REQUEST["agent"]."')";
    if ($i = mysql_query($sql)) {
      echo "success";
    } else {
      echo "failed";
    }
  }
} else {
  header("HTTP/1.1 404 Not Found");
} 
?>
