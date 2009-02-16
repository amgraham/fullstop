<?php
require("./functions.php");

$q = mysql_query("SELECT * FROM events");

$count = mysql_num_rows($q);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8;" />
    <meta http-equiv="Content-Language" content="en-US" />
    <title><?php echo $count; ?> Full&ndash;Stop's</title>
    <link rel="stylesheet" type="text/css" media="screen" title="default" href="style.css" />
    
  </head>
  <body>
    
  <div id='definition'>
  
  <h1><?php echo $count; ?> Full&ndash;Stop&apos;s</h1>
  <p>There are a total of <strong><?php echo $count; ?> errors</strong> within your 
  site; this total includes <strong>5 Database</strong> errors, 
  <strong>18 programming</strong> errors, and <strong>35 HTTP</strong> error 
  codes, of which 10 resources can&apos;t be found, 8 lack authentication, 
  and 3 forbidden requests.</p>
  
  </div>
  </body>
</html>

