<?php
require("./functions.php");

$q = mysql_query("SELECT * FROM errors ORDER BY timeStamp");

$errors = array();
while($error = mysql_fetch_assoc($q)) {
  $errors[] = $error;
}
$q = mysql_query("SELECT * FROM responses");

$responses = array();
while($response = mysql_fetch_assoc($q)) {
  $responses[] = $response;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8;" />
    <meta http-equiv="Content-Language" content="en-US" />
    <script type="text/javascript" src="assets/prototype.js"></script>
    <script type="text/javascript" src="assets/fastinit.js"></script>
    <script type="text/javascript" src="assets/tablesort.js"></script>
    <title>Events</title>
    <link rel="stylesheet" type="text/css" media="screen" title="default" href="style.css" />
    
    <script type="text/javascript">
    //checkAll = function() {
    //  $$('.checkAll').each(function(e){e.checked=true;});
    //};
    //checkNone = function() {
    //  $$('.checkAll').each(function(e){e.checked=false;});
    //};
    function loadError(id) {
      new Ajax.Updater(
      'command',
      'showError.php?id='+id
      )
    }
    Ajax.Responders.register({
        onCreate: function(){ Element.show('loading')},
        onComplete: function(){Element.hide('loading')}
    });
    </script>
  </head>
  <body>
    
  <div id='definition'>
  
  <img id="loading"style="display: none;" src="assets/spinner.gif" />

  
  <h1 class="head">Recent Activity</h1>
  <p class="head">These are recent errors that require attention</p>
  
  <table class="sortable scroll">
    <thead>
      <tr>
        <th>Request</th>
        <th>Referrer</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($errors as $e) { ?>
      <tr>
        <td><span onclick="loadError(<?php echo $e["id"]; ?>);"><?php echo $e["request"]; ?></span></td>
        <td><?php echo $e["referrer"]; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  
  <div id="command">
  
  </div>
  
  <h1 class="head">Responses</h1>
  <p class="head">These are the current responses for future errors</p>
  
  <table class="sortable scroll">
    <thead>
      <tr>
        <th>Request</th>
        <th>Response</th>
        <th>Hits</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($responses as $r) { ?>
      <tr>
        <td><?php echo $r["request"]; ?></td>
        <td><?php echo $r["response"]; ?></td>
        <td><?php echo $r["hits"]; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table
  
  <h1 class="head">Settings</h1>
  <p class="head">Your current settings</p>
  
  </div>
  </body>
</html>

