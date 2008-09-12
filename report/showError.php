<?php
require("functions.php");
$error = mysql_fetch_assoc(mysql_query("SELECT * FROM errors WHERE id = " . $_REQUEST["id"] . ""));
?>
<h2><?php echo $error["request"]; ?></h2>

<form method="post" action="process.php">
<fieldset>
  <legend>Create Response</legend>
  <label for="response">Return this response &rarr; </label>
  <input type="text" value="" name="response" id="response" />
  <input type="hidden" name="command" value="response" />
  <input type="hidden" name="id" value="<?php echo $error["id"]; ?>" />
  <input type="submit" value="Create Response" />
</fieldset>
</form>
<form method="post" action="process.php">
<fieldset>
  <legend>Ignore</legend>
  <label for="requestIgnore">Ignore this request &rarr; </label>
  <input type="checkbox" value="" name="requestIgnore" id="requestIgnore" />
  <input type="hidden" name="command" value="ignore" />
  <input type="hidden" name="id" value="<?php echo $error["id"]; ?>" />
  <input type="submit" value="Ignore" />
</fieldset>
</form>
<form method="post" action="process.php">
<fieldset>
  <legend>Delete</legend>
  <label for="requestDelete">Delete this request &rarr; </label>
  <input type="checkbox" value="" name="requestDelete" id="requestDelete" />
  <input type="hidden" name="command" value="delete" />
  <input type="hidden" name="id" value="<?php echo $error["id"]; ?>" />
  <input type="submit" value="Delete" />
</fieldset>
</form>
