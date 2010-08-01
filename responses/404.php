<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8;" />
		<meta http-equiv="Content-Language" content="en-US" />
		<title>Page Not Found</title>
		<style type="text/css" media="all">
			<!--
			body, html {margin: 1em;padding: 0px;font-size: .9em;color: #333;line-height: 1.4em;font-family: sans-serif;text-align: left;margin: 0;padding: 0;}
			#definition {width: 45em;margin: 3em;text-align: left;}
			#go {margin: 1em 0;font-size: 1.4em;}
			#go a {padding: .5em 1.5em;border: 1px solid #ccc;background: #ffffcc;}
			h1 {font-size: 1.2em;margin: 0;padding: 0;}
			h2 {font-size: .9em;margin: 0;padding: 0;font-weight: normal; margin-bottom: 1em;}
			p {margin-top: 0;padding-top: 0;margin-bottom: 0;}
			a, a:visited {color: blue;text-decoration: none;border-bottom: 1px solid #ccc;}
			a:hover, a:visited:hover {border-bottom: 1px solid blue;}
			p+p, div+p {text-indent: 1em; margin-top: 1em;}
			#requested-file { font-face: monospace; position: absolute; left: 0; right: 0; padding-left: 3em; white-space: nowrap; }
			#requested-file + p { padding-top: 4em; }
			.logged {font-size: .9em;color: #999;margin-top: 1em !important;display: block;}
			.block {display: block; min-width: 42em; scroll: auto;margin: .5em 0;background: #ffffcc;font-family: sans-serif;border-top: 1px solid #ccc;border-bottom: 1px solid #ccc; padding: 4px 1em; list-style-type: none; line-height: 1.6em;}
			a.requested ( color: #333; )
			-->
		</style>
	</head>
	<body>
		<div id='definition'>

		<h1>Page Not Found (404)</h1>

		<h2>There was an unrecoverable error; the requested resource could not be found.</h2>

		<?php echo $reqFancy; ?>

		<p>The <a href='#requested-file' class='requested'>requested file</a> could not be located. <?php echo $reqTrue ?></p>

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

		<!--

		<h2>If the requested file <em>does</em> exist;</h2>
		<p>The requested page was <strong>mis&ndash;typed</strong>; by you in the location bar within your browser, by us in a link, or another website linking to us.</p>

		<h2>If the requested file <em>doesn't</em> exist;</h2>
		<p>The requested page <strong>previously existed</strong> and was deleted or moved;  either intentionally (house cleaning, et cetera), or accidentally.</p>

		<h2>You should be aware;</h2>
		<p>There&apos;s no way to tell which of these situations is accurate. The requested file <em>could</em> exist, at another location, or somewhere in the past; or it could not. There's no way to precisely tell. However; we have enough information about the request to aide us in fixing the problem.</p>

		-->

		<?php backBtn($ref, $refParsed, $hName); ?>

	</div>
	</body>
</html>
