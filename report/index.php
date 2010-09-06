<?php 

	include_once("./functions.php");

	$note = $memo->get();
	
	$broken = mysql_num_rows(mysql_query("SELECT * FROM events WHERE `ignore` = 0 AND `trash` = 0"));
	$deleted = mysql_num_rows(mysql_query("SELECT * FROM events WHERE `ignore` = 0 AND `trash` = 1"));
	$ignored = mysql_num_rows(mysql_query("SELECT * FROM events WHERE `ignore` = 1 AND `trash` = 0"));
	//$redirects = mysql_num_rows(mysql_query("SELECT * FROM events WHERE `ignore` = 0 AND `trash` = 0"));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
    
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8;" />
        <meta http-equiv="Content-Language" content="en-US" />
        <title>Full&ndash;Stop</title>
        <link rel="stylesheet" type="text/css" media="screen" title="default" href="./style.css" />
        <!-- 1.6.0.3 -->
        <script src="./prototype.js" type="text/javascript"></script>
        <script src="./script.js" type="text/javascript"></script>
                       
    </head>
    
    <body>
		<div id="note"><?php echo $note; ?></div>
        <div id='main'>
        <form method="post" action="./actions.php">
        
        	<div id="control">
				<h1>Full&ndash;Stop</h1>
				
				<p><a id="broken" onclick="loadView('broken'); return false;"><?php echo pluralizer($broken, "There are !$ broken events", "There is !$ broken event", "!$"); ?></a>, 
				along with <a id="trash" onclick="loadView('trash'); return false;"><?php echo pluralizer($deleted, "$ deleted events", "$ deleted event", "$"); ?></a>,
				
				<a id="redirect" onclick="loadView('redirect'); return false;"><?php echo $redirects; ?> redirect(s)</a>, 
				and <a id="trash" onclick="loadView('ignore'); return false;"><?php echo pluralizer($ignored, "$ ignored events", "$ ignored event"); ?></a></p>
        	</div>
        	
        	
        	<div id="events">
				<?php require("table.php"); ?>

            <div>
            

        </form>
        </div>
    
    </body>
    
        <script type="text/javascript" language="javascript">
            //<![CDATA[
          function toggleChecked(key) {
          	//var toggle = $(id).checked;
          	if ($(key).checked == 1) {
          		$(key).checked = 0;
          	} else {
          		$(key).checked = 1;
          	}
          }
          
          function loadView(view) {
          	new Ajax.Updater("events", "table.php?view="+view);
			$(view).addClassName("current");
          }
          
          //]]>
        </script>
    
</html>