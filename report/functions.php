<?php

include('../settings.php');

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
include("memo.php");
$memo = new Memo();


$potentialAssets = array(
    // etc
    ".css", ".js",
    //images
    ".png", ".gif", ".jpg", ".ico",
    // downloads
    ".zip", ".tar.gz", ".pdf"

);

$potentialPages = array(
    ".php", ".htm"
);

$httpCodes = array(

    /*
    
    The HTTP code  The HTTP code response               Plural event                Singular event
    
    */
    
    /* Redirection codes */

    "300" => array("Multiple Choice",                   "files not found",          "file not found"),
    "301" => array("Moved",                             "files not found",          "file not found"),
    "302" => array("Found",                             "files not found",          "file not found"),
    "303" => array("See Other",                         "files not found",          "file not found"),
    //"304" => array("Not Modified",                      "files not found",          "file not found"),
    "305" => array("Use Proxy",                         "files not found",          "file not found"),
    //"306" =>  "(Unused)",                             "files not found",          "file not found"),
    "307" => array("Temporary Redirect",                "files not found",          "file not found"),
    
    /* Client error codes */
    
    "400" => array("Bad Request",                       "general request errors",   "general request error"),
    "401" => array("Unauthorized",                      "unauthorized requests",    "unauthorized request"),
    //"402" => "Payment Required",                      "files not found",          "file not found"),
    "403" => array("Forbidden",                         "forbidden requests",       "forbidden request"),
    "404" => array("File Not Found",                    "files not found",          "file not found"),
    //"405" => array("Method Not Allowed",              "files not found",          "file not found"),
    //"406" => array("Not Acceptable",                  "files not found",          "file not found"),
    //"407" => array("Proxy Authentication Required",   "files not found",          "file not found"),
    "408" => array("Request Timeout",                   "timeouts",                 "timeout"),
    //"409" => array("Conflict",                        "files not found",          "file not found"),
    "410" => array("Gone",                              "files not found",          "file not found"),
    "411" => array("Length Required",                   "general request errors",   "general request error"),
    "412" => array("Precondition Failed",               "general request errors",   "general request error"),
    "413" => array("Request Entity Too Large",          "general request errors",   "general request error"),
    "414" => array("Request URI Too Long",              "general request errors",   "general request error"),
    "415" => array("Unsupported Media Type",            "general request errors",   "general request error"),
    "416" => array("Requested Range Not Satisfiable",   "general request errors",   "general request error"),
    "417" => array("Expectation Failed",                "general request errors",   "general request error"),
    
    /* Server error codes */
    
    "500" => array("Server Error",                      "server errors",             "server error"),
    "501" => array("Not Implemented",                   "server errors",             "server error"),
    "502" => array("Bad Gateway",                       "server errors",             "server error"),
    "503" => array("Service Unavailable",               "server errors",             "server error"),
    "504" => array("Gateway Timeout",                   "server errors",             "server error"),
    "505" => array("HTTP Version Not Supported",        "server errors",             "server error"),
);

function pluralizer($count, $plural, $singular, $replace = '$') {
	$replace = ($replace == '') ? "$" : $replace;
	$singular = str_replace($replace, $count, $singular);
	$plural = str_replace($replace, $count, $plural);
	if ($count == 1) {
		echo $singular;
	} else {
		echo $plural;
	}
}

function excerpt($string, $length) {
	if (strlen($string) > $length) {
		$string = substr($string, 0, $length). "...".substr($string, strlen($string) - $length, $length);
	}
	
	return $string;
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