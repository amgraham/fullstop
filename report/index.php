<?php require_once("./functions.php"); 

$total["all"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE status = 0"));
$total["401"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE type = 401"));
$total["403"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE type = 403"));
$total["404"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE type = 404"));
$total["408"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE type = 408"));
$total["410"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE type = 410"));
$total["500"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE type = 500"));

$total["unknown_code"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE type = ''"));

$assetSql = array();
foreach ($potentialAssets as $asset) {
    $assetSql[] = "request LIKE '%$asset'";
}

$pageSql = array();
foreach ($potentialPages as $page) {
	$pageSql[] = "request LIKE '%$page%'";
}

$total["pages"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE ".join($pageSql, " OR ")." ORDER BY date"));

$total["assets"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE ".join($assetSql, " OR ")." ORDER BY date"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
    
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8;" />
        <meta http-equiv="Content-Language" content="en-US" />
        <title><?php echo $total["all"]; ?> Full&ndash;Stop&apos;s</title>
        <link rel="stylesheet" type="text/css" media="screen" title="default" href="style2.css" />
        <!-- 1.6.0.3 -->
        <script src="./assets/prototype.js" type="text/javascript"></script>
                       
    </head>
    
    <body>

        <div id='main'>
        <h1>There are <?php echo $total["all"]; ?> events</h1>
        
        <p>which contain: <?php if ($total["404"] > 0) { ?><?php echo $total["404"]; ?> missing files, <?php } ?>
        <?php if (($total["401"] + $total["403"]) > 0) { ?><?php echo  ($total["401"] + $total["403"]); ?> authorization errors, <?php } ?>
        <?php if ($total["408"] > 0) { ?><?php echo $total["408"]; ?> timeouts, <?php } ?>
        <?php if ($total["410"] > 0) { ?><?php echo $total["410"]; ?> deleted files, <?php } ?>
        <?php if ($total["unknown_code"] > 0) { ?><?php echo $total["unknown_code"]; ?> unknown errors, <?php } ?>
        and 
        <?php if ($total["500"] > 0) { ?><?php echo $total["500"]; ?> server errors<?php } ?>.</p>
        
        <p>In addition to that, there are <?php echo $total["assets"]; ?> errors with <span class='help'>assets</span> &amp; <?php echo $total["pages"]; ?> missing pages.</p>
        
            
        </div>
    
    </body>
    
        <script type="text/javascript" language="javascript">
            //<![CDATA[
            
          
          //]]>
        </script>
    
</html>

