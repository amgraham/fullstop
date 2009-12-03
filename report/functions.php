<?php

$potentialAssets = array(
    // etc
    ".css", ".js",
    //images
    ".png", ".gif", ".jpg", ".ico"

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

define(dbU, "root"); define(dbP, "humpty"); define(dbD, "dev_full-stop");

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
