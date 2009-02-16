<?php

ini_set("precision", "1");
require("markdown.php");

$today = date("Y-m-d");
$year = date("Y");

define(dbU, "root"); define(dbP, "humpty"); define(dbD, "events");

if (!@mysql_connect('localhost', dbU, dbP)) {
  $erRsn = "dbError";
  include("./error.php");
  die(); 
}

if (!@mysql_select_db(dbD)) {
  $erRsn = "dbError";
  include("./error.php");
  die(); 
}

function percentDiff($lastyear, $thisyear) {
  if ($lastyear) {
    $v = 100 * (($thisyear - $lastyear) / $lastyear);
    if ($v == 0) {
      $v = "";
    } else {
      if (strstr($v, "-")) {
        $v = str_replace("-", "", $v);
        $v = "<span class='negative'>" . $v . "%</span>";
      } else {
        $v = "<span class='positive'>" . $v . "%</span>";
      }
    }
    return $v;
  }
}


// Sort the $statuses array by timestamp
// timestamp isn't twitter made, it's created/decided by us
function sortByDate($a, $b) {
  if ($a["date"] == $b["date"]) {
    return 0;
  } else {
    return ($a["date"] < $b["date"]) ? 1 : -1;
  }
}

function neg($v) {
  if ($v == 0) {
    $v = "&mdash;";
  } else {
    if (strstr($v, "-")) {
      $v = str_replace("-", "", $v);
      $v = "<span class='negative'>\$" . number_format($v/100,2) . "</span>";
    } else {
      $v = "<span class='positive'>\$" . number_format($v/100,2) . "</span>";
    }
  }
  return $v;
}

function ceilpow100($val) {
  if ($val % 100 == 0) return $val;
  return number_format($val + (100 - ($val % 100)));
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
    echo "<div style='text-align: left;margin-top: 1em; margin-bottom: 1em; font-size: 110%; border: 1px solid #ccc; background: #efefef; padding: .5em; font-family: monospace;'>";
    echo "<div style='padding: .2em; margin-bottom: .2em; border: 1px solid #ccc; background: #fff;'>";
    echo "<span style='padding-right: .2em; float: right; color: red;'>" . gettype($var) . "</span>";
    echo "<span style='color: green;'>\$" . $n . "</span></div>";
  } else {
    echo "<div style='margin-left: .5em;'>";
  }
  
  // if $var is an array, we need to give it some special stuff
  if (is_array($var)) {
    echo "<div style='border-bottom: 1px dotted #ccc; padding-bottom: .5em; margin-bottom: .5em;'>";
    // for each $key=>$value pair
    foreach ($var as $k=>$v) {
      // we set $c (count) here as an empty string so it won't do anything, if we change it, we need to alter the display/layout
      $c = "";
      if (count($v) != 1) {
        $c = count($v) . " items";
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
?>
