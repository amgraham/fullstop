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
    
    if ($_GET["group"] == "true") {
        $group = " GROUP BY request ";
    } else {
        $group = '';
    }
    
    $query .= " status = 0 $group ORDER BY date";
    
    $load = mysql_query($query);

?>
    
    <table class="sortable" id="table">
        <tr>
            <th class='code'>Code</th>
            <th class='strong request'>Request</th>
            <th class='strong referrer'>Referrer</th>
            <th class='date'>Date</th>
        </tr>
        <?php while ($event = mysql_fetch_assoc($load)) { ?>
        <tr>
            <td class='code'><span title="<?php echo $httpCodes[$event['type']][0]; ?>"><?php echo $event["type"]; ?></span></td>
            <td><?php echo $event["request"]; ?></td>
            <td><?php echo $event["referrer"]; ?></td>
            <td><?php echo date("M jS", strtotime($event["date"] . ' ' . $event["time"])); ?></td>
        </tr>
        <?php } ?>
    </table>
