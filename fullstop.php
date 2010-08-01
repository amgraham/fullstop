<?php

if ($_SERVER["HTTP_USER_AGENT"] == "fullStopScript") {
	//if the user_agent equals what we set it to when we
	//start requesting the structure of this reqested url we need to die.
	//if we don't we can crash the server

	//each req will re-request subsequent pages:
	//so a req like domain.com/path/to/folder/and/file.php
	//will req domain.com/path/, domain.com/path/to/, domain.com/path/to/folder/
	//and so on.

	//the problem is that each of those requests could get this error page.
	//meaning that we'll re-request them again, and again, and again, until we run out of memory.

	//it's bad; and shared-hosts don't like stuff like that, so if we catch a req with the user agent that we set below; kill the script
	
	// this little bit assures that this script doesn't spwan off hundreds of other error scripts.
	header("HTTP/1.1 404 Not Found");
	//then 
	die;
}

if ($_SERVER["REQUEST_URI"] == "/favicon.ico") {
	header("HTTP/1.1 404 Not Found");
	die;
}

//
//define and connect to the database
//

if (!@mysql_connect('localhost', 'root', 'humpty')) {   include("./assets/codes/db.html"); die(); }

if (!@mysql_select_db('dev_full-stop')) {   include("./assets/codes/db.html"); die(); }

//
//set some configuration options; leave as the default unless you know what you're doing
//
$buildReq   = false; // will require previous folders in the requested URL
//
//these are simple variables, and default strings that are needed throughout the script
//
$req		= $_SERVER["REQUEST_URI"];// the requested resource (http://domain.com/path/to/file.php)
$reqParsed	= parse_url($req);// make the req pretty; split it up into hName, path, et cetera
$hName		= $_SERVER["SERVER_NAME"];// our hName (domain.com)
$self		= $_SERVER["PHP_SELF"];// this script (/var/www/error.php)
$ref		= $_SERVER["HTTP_REFERER"];// who sent the visitor here (us, another website, or blank)
$refParsed 	= parse_url($ref);// make the ref pretty; split it up into hName, path, et cetera
//$agent		= $_SERVER["HTTP_USER_AGENT"];// who's requesting us;
$phpUA		= ini_get('user_agent');// the original PHP user agent used for getting files
$htDocs		= $_SERVER["DOCUMENT_ROOT"];// the base of your domain (/var/www/)
$reqArray	= split('/', $req);// split the req on "/"
array_shift($reqArray);// drop the first element (it's empty)
//$reqParsed	= parse_url($req);// make the req pretty; split it up into hName, path, et cetera
$base		= "http://" . $hName . "/";// the basis for urls from here
$reqFancy	= '';
$reqTrue	= '';
$reqFancy	= "<div class='block' id='requested-file' title='The requested file'>http://" . $hName . str_replace('/', ' / ', $req) . "</div>";

//
//this is the type of page we're creating, see http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html for definitions
//this is also going to be the page we're going to show the visitor
//keep in mind eventually we want to handle software errors
//
$errorType = $_GET["code"];

//we need these values to populate the database
$date = date("Y-m-d");
$time = date("H:i:s");

//add the data to the database
$query = mysql_query("INSERT INTO events (`type`,`request`,`referrer`,`date`,`time`) VALUES('$errorType', '$req', '$ref', '$date', '$time')");

//generates a back button; if we can determine where they came from
function backBtn($ref, $refParsed, $hName) {
	global $goBack;
	if (isset($refParsed ["host"])) {
		echo "<div id='go'><p>";
		if ($refParsed ["host"] == $hName) {
			echo  "<a href='" . $ref . "'>Go Back</a>";
		} elseif ($refParsed ["host"] != $hName) {
			echo  "<a href='" . $ref . "'>Go back to " . $refParsed ['host'] . "</a>";
		}
		echo "</p></div>";
	}
}

//
//custom header request; *a lot* like the original
//
function myHeaderRequest($url) {

	$getHeaders = @get_headers($url, 1);
	if (strpos($getHeaders[0], '200')) { //if the main response contains '200' it exists
		return true;
	} else {
		return false;
	}
}

//
//go over the available data, and do something with it
//
function processRequest($reqArray, $base, $phpUA, $hName) {
	global  $reqArray, $base, $reqTrue, $reqFancy, $reqFancy;
	ini_set('user_agent', 'fullStopScript'); // set it to us; if this page is called with out user agent; we die gracefully
	$reqFancy = "<a href='http://" . $hName ."'>http://" . $hName . "</a>"; // the beginning of our requested-file link list
	checkLinks($reqArray, $base); // go over everything, if it exists, make a link; come back here if it doesn't exist
	$reqFancy .= ' / ' . join(' / ', $reqArray); // turn the req array back into a string, with "/" as the glue
	$reqFancy = "<div class='block' id='requested-file'>" . $reqFancy . "</div>";
	ini_set('user_agent', $phpUA); // set the PHP user agent back to the default
}

//
//check the path up to the last page recursively.
//
function checkLinks($reqArray, $base) {
	global  $reqArray, $base, $reqTrue, $reqFancy, $reqExists;
	$reqTrue = '';
	$reqExists = array();
	$preBase = $base;
	while (true) {
		foreach ($reqArray as $folder) {
		// We make $preBase hold the value, and only change $base if the resource exists
			$preBase .= $folder . "/";
			if (myHeaderRequest($preBase)) {
				// apparently, we're still reqing
				$reqTrue = "However, <em>some</em> resources preceding the requested one <strong> are available above</strong>; these resources <em>could</em> aide you in finding what you originally intended.";
				$reqFancy .= " / <a href='" . $preBase . "'>" . $folder . "</a>";
				array_shift($reqArray);
				// This is only set if the resource exists, $base is used for alternates
				$base .= $folder . "/";
			} else {
				return false;
			}
		}
	}
}

//
//finally do something
//
processRequest($reqArray, $base, $phpUA, $hName, $htDocs); // process the req; give them some results.

	$codes = array();
	if ($errorType == "404") {
		header("HTTP/1.1 404 Not Found"); // we're an error page, right?
		include ("./responses/".$errorType.".php");
	} else if ($errorType == "db") {
		include ("./responses/db.php");
	}
?>

