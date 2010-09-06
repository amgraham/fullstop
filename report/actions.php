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
       <script type="text/javascript" language="javascript">
            //<![CDATA[
			
          //]]>
        </script>              
    </head>
    <body>
    <div id="main">
    <?php 


	require("./configuration.php"); 

	//debug($_POST);

	$plural = (count($_POST) == 2) ? false : true;
	
	if (count($_POST) == 1) {
		die("<a href='./' title='go back'>&larr; nothing to do</a>");	
	}
	
	switch($_POST["action"]) {
	
		case "confirmDelete":
			array_shift($_POST);
			
			foreach ($_POST as $id=>$int) {
				$ids[] = str_replace('id_', '', $id);
			}
			$query = "DELETE FROM events WHERE id IN (".implode(',', $ids).")";
			
			if (mysql_query($query)) {
				$memo->set(count($ids)." event(s) deleted&hellip;");
				header("Location: ./");
			} else {
				echo mysql_error();
				die("Could not delete");
			}
		break;

		case "delete":
		
			array_shift($_POST);
			
			foreach ($_POST as $id=>$int) {
				$ids[] = str_replace('id_', '', $id);
			}
			
			echo "<h1><a href='./'>&larr;</a> Delete ".count($ids)." Event(s)</h1>";
			if ($plural) {
				echo "<p>Remove the following events; keep in mind that new events with those requests <em>can</em> be created.</p>";
			} else {
				echo "<p>Remove the following event; keep in mind that a new event with that request <em>can</em> be created.</p>";
			}
			
			$query = "SELECT * FROM events WHERE id IN (".implode(',', $ids).")";
			$load = mysql_query($query);
			?>
			    <form method="post" action="./actions.php" id="confirm">
			    <input type="hidden" name="action" value="confirmDelete" />
			    <p>You can <input type="button" id="toggler" value="Reselect All"/> and then <input type="submit" value="Confirm" />. You can also <a href='./'>cancel and go back</a>.</p>
				<table>
					<?php while ($event = mysql_fetch_assoc($load)) { ?>
					<tr<?php echo $even; ?> onclick="toggleChecked('id_<?php echo $event["id"]; ?>'); return false;">
						<td><?php echo $event["type"] ; ?></td>
						<td><input type="checkbox" id="id_<?php echo $event["id"]; ?>" name="id_<?php echo $event["id"]; ?>" /></td>
						<td><label for="id_<?php echo $event["id"]; ?>""><?php echo $event["request"]; ?></label></td>
					</tr>
					<?php if ($even == '') { $even = " class='even''"; } else { $even = ''; } } ?>
				</table>
				</form>
			<?php
			//echo $query;
			
		break;
		
		case "redirect":
		
			array_shift($_POST);
			
			foreach ($_POST as $id=>$int) {
				$ids[] = str_replace('id_', '', $id);
			}
		
			echo "<h1><a href='./'>&larr;</a> Redirect ".count($ids)." Event(s)</h1>";
			if ($plural) {
				echo "<p>Create new <a href=''>redirects</a> so these requests will end up going where they're supposed to.</p>";
			} else {
				echo "<p>Create a new <a href=''>redirect</a> so this request will end up going where it&apos;s meant.</p>";
			}
			
			$query = "SELECT * FROM events WHERE id IN (".implode(',', $ids).")";
			$load = mysql_query($query);
			?>
			    <form method="post" action="./actions.php" id="confirm">
			    <input type="hidden" name="action" value="confirmDelete" />
			    <p>You can <input type="button" id="toggler" value="Reselect All"/> and then <input type="submit" value="Confirm" />. You can also <a href='./'>cancel</a> and go back.</p>
				<table>
					<?php while ($event = mysql_fetch_assoc($load)) { ?>
					<tr<?php echo $even; ?> onclick="toggleChecked('id_<?php echo $event["id"]; ?>'); return false;">
						<td><?php echo $event["type"] ; ?></td>
						<td><input type="checkbox" id="id_<?php echo $event["id"]; ?>" name="id_<?php echo $event["id"]; ?>" /></td>
						<td><label for="id_<?php echo $event["id"]; ?>""><?php echo $event["request"]; ?></label></td>
					</tr>
					<?php if ($even == '') { $even = " class='even''"; } else { $even = ''; } } ?>
				</table>
				</form>
			<?php
			//echo $query;
			
		break;
		
		case "confirmIgnore":
		
			array_shift($_POST);
			
			foreach ($_POST as $id=>$int) {
				$ids[] = str_replace('id_', '', $id);
			}
			$query = "UPDATE events SET `ignore` = 1 WHERE id IN (".implode(',', $ids).")";
			//echo $query;
			if (mysql_query($query)) {
				$memo->set(count($ids)." event(s) ignored&hellip;");
				header("Location: ./");
			} else {
				echo mysql_error();
				die("Could not ignore");
			}
		
		break;
		
		case "ignore":
		
			array_shift($_POST);
			
			foreach ($_POST as $id=>$int) {
				$ids[] = str_replace('id_', '', $id);
			}
			
			echo "<h1><a href='./'>&larr;</a> Ignore ".count($ids)." Event(s)</h1>";
			if ($plural) {
				echo "<p>Choose to ignore furthers events that match the following requests.</p>";
			} else {
				echo "<p>Choose to ignore a future event that matches the one selected.</p>";
			}
			
			
			$query = "SELECT * FROM events WHERE id IN (".implode(',', $ids).")";
			$load = mysql_query($query);
			?>
			    <form method="post" action="./actions.php" id="confirm">
			    <input type="hidden" name="action" value="confirmIgnore" />
			    <p>You can <input type="button" id="toggler" value="Reselect All"/> and then <input type="submit" value="Confirm" />. You can also <a href='./'>cancel</a> and go back.</p>
				<table>
					<?php while ($event = mysql_fetch_assoc($load)) { ?>
					<tr<?php echo $even; ?> onclick="toggleChecked('id_<?php echo $event["id"]; ?>'); return false;">
						<td><?php echo $event["type"] ; ?></td>
						<td><input type="checkbox" id="id_<?php echo $event["id"]; ?>" name="id_<?php echo $event["id"]; ?>" /></td>
						<td><label for="id_<?php echo $event["id"]; ?>""><?php echo $event["request"]; ?></label></td>
					</tr>
					<?php if ($even == '') { $even = " class='even''"; } else { $even = ''; } } ?>
				</table>
				</form>
			<?php
			//echo $query;
			
		break;
	}
	?>
    </div>
    
    </body>
    
        <script type="text/javascript" language="javascript">
            //<![CDATA[
			$('toggler').observe('click',function (e) {
				//var toggle = $('toggler').checked;
				if ($('toggler').readAttribute("value") == "Reselect All") {
					var state = 1;
					$('toggler').writeAttribute("value", "Deselect All");
				} else {
					var state = 0;
					$('toggler').writeAttribute("value", "Reselect All");
				}
				$$('#confirm input[type=checkbox]').each(function(check) {
					check.checked = state;
				});
			});
			
          function toggleChecked(key) {
          	//var toggle = $(id).checked;
          	if ($(key).checked == 1) {
          		$(key).checked = 0;
          	} else {
          		$(key).checked = 1;
          	}
          }
			
          //]]>
        </script>
    
</html>