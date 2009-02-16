<?php

function parseUserAgent($ua)
  {

    $userAgent = array();
    $agent = $ua;
    $products = array();

    $pattern  = "([^/[:space:]]*)" . "(/([^[:space:]]*))?"
      ."([[:space:]]*\[[a-zA-Z][a-zA-Z]\])?" . "[[:space:]]*"
      ."(\\((([^()]|(\\([^()]*\\)))*)\\))?" . "[[:space:]]*";

    while( strlen($agent) > 0 )
      {
        if ($l = ereg($pattern, $agent, $a))
          {
            // product, version, comment
            array_push($products, array($a[1],    // Product
                                        $a[3],    // Version
                                        $a[6]));  // Comment
            $agent = substr($agent, $l);
          }
        else
          {
            $agent = "";
          }
      }

    // Directly catch these
    foreach($products as $product)
      {
        switch($product[0])
          {
          case 'Firefox':
          case 'Netscape':
          case 'Safari':
          case 'Camino':
          case 'Mosaic':
          case 'Galeon':
          case 'Opera':
            $userAgent[0] = $product[0];
            $userAgent[1] = $product[1];
            break;
          }
      }

    if (count($userAgent) == 0)
      {
        // Mozilla compatible (MSIE, konqueror, etc)
        if ($products[0][0] == 'Mozilla' &&
            !strncmp($products[0][2], 'compatible;', 11))
          {
            $userAgent = array();
            if ($cl = ereg("compatible; ([^ ]*)[ /]([^;]*).*",
                           $products[0][2], $ca))
              {
                $userAgent[0] = $ca[1];
                $userAgent[1] = $ca[2];
              }
            else
              {
                $userAgent[0] = $products[0][0];
                $userAgent[1] = $products[0][1];
              }
          }
        else
        {
          $userAgent = array();
          $userAgent[0] = $products[0][0];
          $userAgent[1] = $products[0][1];
        }
      }

    return $userAgent;
  }

function doRelativeDate($posted_date) {
    /**
        This function returns either a relative date or a formatted date depending
        on the difference between the current datetime and the datetime passed.
            $posted_date should be in the following format: YYYYMMDDHHMMSS
 
        Relative dates look something like this:
            3 weeks, 4 days ago
        Formatted dates look like this:
            on 02/18/2004
 
        The function includes 'ago' or 'on' and assumes you'll properly add a word
        like 'Posted ' before the function output.
 
        By Garrett Murray, http://graveyard.maniacalrage.net/etc/relative/
    **/
    $in_seconds = strtotime(substr($posted_date,0,8).' '.
                  substr($posted_date,8,2).':'.
                  substr($posted_date,10,2).':'.
                  substr($posted_date,12,2));
    $diff = time()-$in_seconds;
    $months = floor($diff/2592000);
    $diff -= $months*2419200;
    $weeks = floor($diff/604800);
    $diff -= $weeks*604800;
    $days = floor($diff/86400);
    $diff -= $days*86400;
    $hours = floor($diff/3600);
    $diff -= $hours*3600;
    $minutes = floor($diff/60);
    $diff -= $minutes*60;
    $seconds = $diff;
 
    if ($months>0) {
        // over a month old, just show date (mm/dd/yyyy format)
        return 'on '.substr($posted_date,4,2).'/'.substr($posted_date,6,2).'/'.substr($posted_date,0,4);
    } else {
        if ($weeks>0) {
            // weeks and days
            $relative_date .= ($relative_date?', ':'').$weeks.' week'.($weeks>1?'s':'');
            $relative_date .= $days>0?($relative_date?', ':'').$days.' day'.($days>1?'s':''):'';
        } elseif ($days>0) {
            // days and hours
            $relative_date .= ($relative_date?', ':'').$days.' day'.($days>1?'s':'');
            $relative_date .= $hours>0?($relative_date?', ':'').$hours.' hour'.($hours>1?'s':''):'';
        } elseif ($hours>0) {
            // hours and minutes
            $relative_date .= ($relative_date?', ':'').$hours.' hour'.($hours>1?'s':'');
            $relative_date .= $minutes>0?($relative_date?', ':'').$minutes.' minute'.($minutes>1?'s':''):'';
        } elseif ($minutes>0) {
            // minutes only
            $relative_date .= ($relative_date?', ':'').$minutes.' minute'.($minutes>1?'s':'');
        } else {
            // seconds only
            $relative_date .= ($relative_date?', ':'').$seconds.' second'.($seconds>1?'s':'');
        }
    }
    // show relative date and add proper verbiage
    return $relative_date.' ago';
}

function debug(&$var, $r = NULL) {
  // if $var is an empty string, we're being called recursively
  // this is an extreme guess, and might cause problems
 
  // now we determine the variable name
 
  $old = $var;
  $var = $new = "unique".rand()."value";
  $vname = FALSE;
  foreach($GLOBALS as $key => $val) {
    if($val === $new) $vname = $key;
  }
  $var = $old;
  $n = $vname;
 
 
  if ($r == null) {
    echo "<div style='text-align: left;margin-top: 1em; margin-bottom: 1px; font-size: 11px; border: 1px solid #ccc; background: #efefef; padding: 5px; font-family: monospace; line-height: 16px;'>";
    echo "<div style='padding: 2px; margin-bottom: 2px; border: 1px solid #ccc; background: #fff;'>";
    echo "<span style='padding-right: 2px; float: right; color: red;'>" . gettype($var) . "</span>";
    echo "<span style='color: green;'>\$" . $n . "</span></div>";
  } else {
    echo "<div style='margin-left: 5px;'>";
  }
 
  // if $var is an array, we need to give it some special stuff
  if (is_array($var)) {
    if ($r == null) {
      // this is the original
      echo "<div style='padding-bottom: 5px; margin-bottom: 5px; text-align: left;;'>";
    } else {
      echo "<div style='border-left: 1px solid #bbb; padding-left: 5px; padding-bottom: 5px; text-align: left;  margin-left: -2px; border-bottom: 1px solid #bbb;'>";
    }
    // for each $key=>$value pair
    foreach ($var as $k=>$v) {
      // we set $c (count) here as an empty string so it won't do anything, if we change it, we need to alter the display/layout
      $c = "";
      if (count($v) != 1) {
        $c = count($v) . " items &darr;";
      }
      // if $c is empty the results will be displayed next to the $k,
      // otherwise we're display the number of items, then on a new line, go over them
      echo "<span style='font-weight: bold;'>$k</span> &rarr; $c";
      if (is_array($v)) {
        debug($v, true);
      } else {
        echo $v . "<br />";
      }
    }
    echo "</div>";
  } else {
    echo $var;
  }
  echo "</div>";

}


define(dbU, "root"); define(dbP, "humpty"); define(dbD, "full-stop");

if (!@mysql_connect('localhost', dbU, dbP)) {
  $errorType = "mySql";
  include("../fullstop.php");
  die(); 
}

if (!@mysql_select_db(dbD)) {
  $errorType = "mySql";
  include("../fullstop.php");
  die(); 
}
?>
