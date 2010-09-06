	<?php 	
	include_once("./configuration.php");
	 if ($_GET["view"] == "ignore") {
    	$load = mysql_query("SELECT * FROM  events WHERE `ignore` = 1 AND `trash` = 0 ORDER BY request ASC ");
    	?>
		<p><label for="action">These are entries you&apos;ve decided to ignore, you can now, send them back to the broken list</label>
		<input type="hidden" name="action" value="reallyDelete" />
		<input type="submit" value="Process!" /> &larr; It's <em>very</em> exciting!</p>
    <?php } else if ($_GET["view"] == "redirect") { 
    	$load = mysql_query("SELECT * FROM  events WHERE `ignore` = 0 AND `trash` = 1 ORDER BY request ASC ");
	?>
		<p><label for="action">These are the previous entries you&apos;ve deleted, you can now, delete them <em>for real</em></label>
		<input type="hidden" name="action" value="reallyDelete" />
		<input type="submit" value="Process!" /> &larr; It's <em>very</em> exciting!</p>
    <?php } else if ($_GET["view"] == "trash") {
    	$load = mysql_query("SELECT * FROM  events WHERE `ignore` = 0 AND `trash` = 1 ORDER BY request ASC ");
	?>
		<p><label for="action">These are the previous entries you&apos;ve deleted, you can now delete them <em>for real</em></label>
		<input type="hidden" name="action" value="confirmDelete" />
		<input type="submit" value="Process!" /> &larr; It's <em>very</em> exciting!</p>
    <?php } else {
    	$load = mysql_query("SELECT * FROM  events WHERE `ignore` = 0 AND `trash` = 0 ORDER BY request ASC");
	?>
		<p><label for="action">What would you like to do? </label>
		<select name="action">
			<option value="delete">Delete</option>
			<option value="redirect">Create Redirect</option>
			<option value="ignore">Ignore</option>
		</select>
		<input type="submit" value="Process!" /> &larr; It's <em>very</em> exciting!</p>
	<?php }
	
	if ($_GET["view"] != "redirect") { ?>
	<table>
		<?php while ($event = mysql_fetch_assoc($load)) { ?>
		<tr<?php echo $even; ?> onclick="toggleChecked('id_<?php echo $event["id"]; ?>'); return false;">
			<td><?php echo $event["type"] ; ?></td>
			<td><input type="checkbox" id="id_<?php echo $event["id"]; ?>" name="id_<?php echo $event["id"]; ?>" /></td>
			<td><label for="id_<?php echo $event["id"]; ?>""><?php echo $event["request"]; ?></label></td>
			<td><?php echo $event["count"] ; ?></td>
		</tr>
		<?php if ($even == '') { $even = " class='even''"; } else { $even = ''; } } ?>
	</table>
	<?php } else { ?>
redirect!
	<?php } ?>