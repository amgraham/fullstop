<?php require_once("./functions.php");
    
    $assetSql = array();
    foreach ($potentialAssets as $asset) {
        $assetSql[] = "request LIKE '%$asset'";
    }
    
    $pageSql = array();
    foreach ($potentialPages as $page) {
        $pageSql[] = "request LIKE '%$page%'";
    }
    
    $total["all"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE status = 0"));
    
    $total["assets"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE ".join($assetSql, " OR ")." ORDER BY date"));
    
    $total["folders"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE request LIKE '%/' ORDER BY date"));
    
    $ff = "SELECT * FROM events WHERE ".join($pageSql, " OR ")." GROUP BY request ORDER BY date";
    
    //echo $ff;
    
    $total["pages"] = mysql_num_rows(mysql_query($ff));
    
    $total["internal"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE referrer LIKE 'http://aramaki%' ORDER BY date"));
    
    $total["external"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE referrer NOT LIKE 'http://aramaki%' AND referrer != '' ORDER BY date"));
    
    $http = mysql_query("SELECT DISTINCT type FROM events WHERE status = 0");
    
    $types = array();
    
    while ($r = mysql_fetch_assoc($http)) {
    
        $types[$r["type"]] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE type = '".$r["type"]."' AND status = 0"));
        
    }

    $p = array();
    
    foreach($types as $key=>$value) {
    
        if (key_exists($key, $httpCodes)) {
            $s = ($types[$key] == 1) ? $s = 2 : $s = 1;
            $p[] = array($key, $types[$key] . " " . $httpCodes[$key][$s]);
        }
    }
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
    
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8;" />
        <meta http-equiv="Content-Language" content="en-US" />
        <title><?php echo $total["all"]; ?> Full&ndash;Stop&apos;s</title>
        <link rel="stylesheet" type="text/css" media="screen" title="default" href="style.css" />
        <!-- 1.6.0.3 -->
        <script src="./assets/prototype.js" type="text/javascript"></script>
        <script src="./assets/fastinit.js" type="text/javascript"></script>
        <script src="./assets/tablesort.js" type="text/javascript"></script>
                       
    </head>
    
    <body>

        <div id='definition'>
        
            <form id="meta" method="GET" action="./table.php">
                
                <select name="errorCode">
                    <option value="all">All codes</option>
                    <?php foreach($p as $each) { ?>
                    <option value="<?php echo (string) $each[0]; ?>"><?php echo $each[1]; ?></option>
                    <?php } ?>
                </select>
                
                <select name="resources">
                    <option value="all">All resources</option>
                    <?php if ($total["assets"] > 0) { ?><option value="assets"><?php echo $total["assets"]; ?> assets</option><?php } ?>
                </select>
                
                <select name="referrers">
                    <option value="all">All referrers</option>
                    <?php if ($total["internal"] > 0) { ?><option value="internal"><?php echo $total["internal"]; ?> internal</option><?php } ?>
                    <?php if ($total["external"] > 0) { ?><option value="external"><?php echo $total["external"]; ?> external</option><?php } ?>
                </select>
                
                <select name="group">
                    <option value="false">All requests</option>
                    <option value="true">Distinct request</option>
                </select>
                
                <!-- Change everything to blank -->
                <input type="reset" value="All Errors" onclick="clearForm(); return false;" title="Quickly bring back every event" />
                
                <!-- Change everything to blank -->
                <input type="submit" value="View" onclick="submitForm(); return false;" />
                                
            </form>
            
            <div id="data">
        
            <?php include("./table.php"); ?>
            
            </div>
            
        </div>
    
    </body>
    
        <script type="text/javascript" language="javascript">
            //<![CDATA[
            
            function submitForm() {
                var form = $('meta').serialize();
                new Ajax.Updater("data", "./table.php?"+form, {
                  onComplete: function() {
                      SortableTable.init('table');
                  }
                });
            }
            // this needs to also clear the form
            function clearForm() {
                new Ajax.Updater("data", "./table.php", {
                  onComplete: function() {
                      SortableTable.init('table');
                  }
                });
            }
          
          //]]>
        </script>
    
</html>

