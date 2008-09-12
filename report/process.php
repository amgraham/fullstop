<?php

require("functions.php");
$error = mysql_fetch_assoc(mysql_query("SELECT * FROM errors WHERE id = " . $_REQUEST["id"] . ""));
$user = mysql_fetch_assoc(mysql_query("SELECT * FROM users WHERE id = " . $error["user_id"] . ""));
if ($_POST["command"] == "ignore") {
  $sql = mysql_query("INSERT INTO responses (`user_id`,`request`,`response`) VALUES('" . $user["id"] . "', '" . $error["request"] . "', 'IGNORE')");
  $sql = mysql_query("DELETE FROM errors WHERE `request` = '" . $error["request"] . "'");
} else if ($_POST["command"] == "delete") {
  $sql = mysql_query("DELETE FROM errors WHERE `request` = '" . $error["request"] . "'");
} else if ($_POST["command"] == "response") {
  
}
header("Location: http://error/report/");
?>
