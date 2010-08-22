<?php require_once("./functions.php");

    $query = "SELECT * FROM events WHERE ";
    
    if (count($_GET) != 0) {
    
        if ($_GET["errorCode"] != "all") {
        
            $query .= " type = ".$_GET["errorCode"]." AND ";
            
        }
        
        if ($_GET["resources"] != "all") {
        
            if ($_GET["resources"] == "assets") {
            
                $assetSql = array();
                foreach ($potentialAssets as $asset) {
                    $assetSql[] = "request LIKE '%$asset' ";
                }
                
                $query .= "(".join($assetSql, " OR ").")";
                
            }
            
            if ($_GET["resources"] == "pages") {
            
                $pagesSql = array();
                foreach ($potentialPages as $page) {
                    $pageSql[] = "request LIKE '%$page' ";
                }
                
                $query .= "(".join($pageSql, " OR ").")";
                
            }
            
            
            $query .= " AND ";
            
        } 
        
        
        if ($_GET["referrers"] != "all") {
            
            if ($_GET["referrers"] == "internal") {
                
                $query .= "referrer LIKE 'http://aramaki%' AND referrer != ''";
            
            } else if ($_GET["referrers"] == "external") {
                
                $query .= "referrer NOT LIKE 'http://aramaki%' AND referrer != ''";
                
            }
            
            $query .= " AND ";
        }
        
        
    }
    
    if ($_GET["group"] != "true") {
        $group = " GROUP BY request ";
    } else {
        $group = '';
    }
    
    $query .= " status = 0 $group ORDER BY date";
    
    $load = mysql_query($query);

?>
    <form>
    <table class="sortable" id="table">
        <tr>
            <th class='no-sort'></th>
            <th class='code'>Code</th>
            <th class='strong request'>Request</th>
            <th class='strong referrer'>Referrer</th>
            <th class='date'>Date</th>
        </tr>
        <?php while ($event = mysql_fetch_assoc($load)) { ?>
        <tr>
            <td><input type="checkbox" /></td>
            <td class='code'><span title="<?php echo $httpCodes[$event['type']][0]; ?>"><?php echo $event["type"]; ?></span></td>
            <td><?php echo excerpt($event["request"]); ?></td>
            <td><?php echo excerpt($event["referrer"]); ?></td>
            <td><?php echo date("D, M jS Y", strtotime($event["date"] . ' ' . $event["time"])); ?></td>
        </tr>
        <?php } ?>
    </table>
    </form>
