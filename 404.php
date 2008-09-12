<?php
	header("HTTP/1.1 404 Not Found"); // we're an error page, right?

	if ($_SERVER["HTTP_USER_AGENT"] == "smarterErrorScript") {
		// if the user_agent equals what we set it to when we
		// start requesting the structure of this reqested url we need to die.
		// if we don't we can crash the server
		//
		// each req will re-request subsequent pages:
		// so a req like domain.com/path/to/folder/and/file.php
		// will req domain.com/path/, domain.com/path/to/, domain.com/path/to/folder/
		// and so on.
		//
		// the problem is that each of those requests could get this error page.
		// meaning that we'll re-request them again, and again, and again, until we run out of memory.
		//
		// it's bad; and shared-hosts don't like stuff like that, so if we catch a req with the user agent that we set below; kill the script
		die;
	}
  
	//
	// set some configuration options; leave as the default unless you know what you're doing
	//
	$buildReq = true; // will req previous folders in the requested URL
	//
	// these are simple variables, and default strings that are needed throughout the script
	//
	$req	= $_SERVER["REQUEST_URI"];// the requested resource (http://domain.com/path/to/file.php)
	$reqParsed	= parse_url($req);// make the req pretty; split it up into hName, path, et cetera
	$hName = $_SERVER["SERVER_NAME"];// our hName (domain.com)
	$self = $_SERVER["PHP_SELF"];// this script (/var/www/error.php)
	$ref = $_SERVER["HTTP_REFERER"];// who sent the visitor here (us, another website, or blank)
	$refParsed = parse_url($ref);// make the ref pretty; split it up into hName, path, et cetera
	$agent = $_SERVER["HTTP_USER_AGENT"];// who's requesting us;
	$phpUA = ini_get('user_agent');// the original PHP user agent used for getting files
	$htDocs = $_SERVER["DOCUMENT_ROOT"];// the base of your domain (/var/www/)
  $reqArray = split('/', $req);// split the req on "/"
					            array_shift($reqArray);// drop the first element (it's empty)
  //$reqParsed = parse_url($req);// make the req pretty; split it up into hName, path, et cetera
	$base = "http://" . $hName . "/";// the basis for urls from here
	$reqFancy = '';
	$reqTrue = '';
	$reqFancy = "<div class='block' id='requested-file' title='The requested file'>http://" . $hName . str_replace('/', ' / ', $req) . "</div>";
  
  
  $errorPost = "http://error/report/post.php";
  $errorPost .= "?action=error";
  $errorPost .= "&version=1";
  $errorPost .= "&account=ashleymg@gmail.com";
  //$errorPost .= "&domain=" . urlencode($hName);
  $errorPost .= "&request=" . urlencode($req);
  $errorPost .= "&agent=" . urlencode($agent);
  if (isset($ref)) {
    $errorPost .= "&referrer=" . urlencode($ref);
  }
  $xmlError = @file_get_contents($errorPost);
  
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

	// custom header req; *a lot* like the original
	function myHeaderRequest($url) {
		$getHeaders = @get_headers($url, 1);
		if (strpos($getHeaders[0], '200')) { //if the main response contains '200' it exists
			return true;
		} else {
			return false;
		}
	}
  
	function processRequest($reqArray, $base, $phpUA, $hName) {
		global  $reqArray, $base, $reqTrue, $reqFancy, $reqFancy;
		ini_set('user_agent', 'smarterErrorScript'); // set it to us; if this page is called with out user agent; we die gracefully
		$reqFancy = "<a href='http://" . $hName ."'>http://" . $hName . "</a>"; // the beginning of our requested-file link list
		checkLinks($reqArray, $base); // go over everything, if it exists, make a link; come back here if it doesn't exist
		$reqFancy .= ' / ' . join(' / ', $reqArray); // turn the req array back into a string, with "/" as the glue
		$reqFancy = "<div class='block' id='requested-file'>" . $reqFancy . "</div>";
		ini_set('user_agent', $phpUA); // set the PHP user agent back to the default
	}

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

  processRequest($reqArray, $base, $phpUA, $hName, $htDocs); // process the req; give them some results.

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8;" />
    <meta http-equiv="Content-Language" content="en-US" />
    <title>Page Not Found</title>
    <style type="text/css" media="all">
		<!--
		body, html {margin: 1em;padding: 0px;font-size: .9em;color: #333;line-height: 1.4em;font-family: sans-serif;text-align: center;margin: 0;padding: 0;}
		#definition {width: 45em;margin: 1em auto;text-align: left;}
		#go {margin: 1em 0;font-size: 1.4em;}
		#go a {padding: .5em 1.5em;border: 1px solid #ccc;background: #ffffcc;}
		h1 {font-size: 1.2em;margin: 0;padding: 0;}
		h2 {font-size: 1.2em;margin: 0;padding: 0;margin-top: .5em;font-weight: normal;}
		p {margin-top: 0;padding-top: 0;margin-bottom: 0;}
		a, a:visited {color: blue;text-decoration: none;border-bottom: 1px solid #ccc;}
		a:hover, a:visited:hover {border-bottom: 1px solid blue;}
		p+p {text-indent: 1em;}
		.logged {font-size: .9em;color: #999;margin-top: 1em !important;display: block;}
		.block {display: block;width: 42em;scroll: auto;margin: .5em 0;background: #ffffcc;font-family: sans-serif;border: 1px solid #ccc;padding: 4px 1em; list-style-type: none; line-height: 1.6em;}
		-->
    </style>
  </head>
  <body>
  <div id='definition'>

  <h1>Page Not Found (404)</h1>

  <p>There was an unrecoverable error in the current request.</p>

  <?php echo $reqFancy; ?>

  <p>The <a href='#requested-file'>requested file</a> could not be located. <?php echo $reqTrue ?></p>

  <?php if (count($altLocs) > 0) { ?>
    <h2>Alternate resources;</h2>
    <p>There were other resources <strong>with different file extensions</strong> available at this level; these resources <strong>might</strong> be useful in finding what you initially requested:</p>
    <ol class="block">
      <?php foreach ($altLocs as $loc) {?>
        <li><a href="<?php echo $loc;?>" title="A possible substitution"><?php echo $loc; ?></a></li>
      <?php } ?>
    </ol>
    <p>Please use caution with these resources; they were presented to you based upon their file&ndash;extension only; they might not have anything to do with the initial request.</p>
  <?php } ?>

  <h2>If the requested file <em>does</em> exist;</h2>
  <p>The requested page was <strong>mis&ndash;typed</strong>; by you in the location bar within your browser, by us in a link, or another website linking to us.</p>

  <h2>If the requested file <em>doesn't</em> exist;</h2>
  <p>The requested page <strong>previously existed</strong> and was deleted or moved;  either intentionally (house cleaning, et cetera), or accidentally.</p>

  <h2>You should be aware;</h2>
  <p>There&apos;s no way to tell which of these situations is accurate. The requested file <em>could</em> exist, at another location, or somewhere in the past; or it could not. There's no way to precisely tell. However; we have enough information about the request to aide us in fixing the problem.</p>

  <?php backBtn($ref, $refParsed, $hName); ?>

  </div>
  </body>
</html>

<?php print_r($xmlError); ?>
