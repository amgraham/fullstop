<?php require("./functions.php");
    $assetSql = array();
    foreach ($potentialAssets as $asset) {
        $assetSql[] = "request LIKE '%$asset'";
    }
    
    $pageSql = array();
    foreach ($potentialPages as $page) {
        $pageSql[] = "request LIKE '%$page%'";
    }
    
    $total["assets"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE ".join($assetSql, " OR ")." GROUP BY request ORDER BY date"));
    
    $total["folders"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE request LIKE '%/' GROUP BY request ORDER BY date"));
    
    $ff = "SELECT * FROM events WHERE ".join($pageSql, " OR ")." GROUP BY request ORDER BY date";
    
    //echo $ff;
    
    $total["pages"] = mysql_num_rows(mysql_query($ff));
    
    $total["internal"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE referrer LIKE 'http://aramaki%' GROUP BY request ORDER BY date"));
    
    $total["external"] = mysql_num_rows(mysql_query("SELECT * FROM events WHERE referrer NOT LIKE 'http://aramaki%' AND referrer != '' GROUP BY request ORDER BY date"));
    
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
    
    print_r($_GET);
    
?>
            <form id="meta" method="GET" action="./table.php">
            
                <select name="group" id="group" onchange="observeForm('group'); return false;">
                    <option value="false">All requests</option>
                    <option value="true">Distinct request</option>
                </select>
                
                <select name="errorCode" id="errorCode" onchange="observeForm('errorCode'); return false;">
                    <option value="all">All codes</option>
                    <?php foreach($p as $each) { ?>
                    <option value="<?php echo (string) $each[0]; ?>"><?php echo $each[1]; ?></option>
                    <?php } ?>
                </select>
                
                <select name="resources" id ="resources" onchange="observeForm('resources'); return false;">
                    <option value="all">All resources</option>
                    <?php if ($total["assets"] > 0) { ?><option value="assets"><?php echo $total["assets"]; ?> assets</option><?php } ?>
                </select>
                
                <select name="referrers" id="referrers" onchange="observeForm('referrers'); return false;">
                    <option value="all">All referrers</option>
                    <?php if ($total["internal"] > 0) { ?><option value="internal"><?php echo $total["internal"]; ?> internal</option><?php } ?>
                    <?php if ($total["external"] > 0) { ?><option value="external"><?php echo $total["external"]; ?> external</option><?php } ?>
                </select>
                
                <!-- Change everything to blank -->
                <input type="reset" value="All Errors" onclick="clearForm(); return false;" title="Quickly bring back every event" />
                
                <!-- Change everything to blank -->
                <input type="submit" value="View" onclick="submitForm(); return false;" />
                                
            </form>
