<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8;" />
    <meta http-equiv="Content-Language" content="en-US" />
    <title>File Gone</title>
    <style type="text/css" media="all">
		<!--
		body, html {margin: 1em;padding: 0px;font-size: .9em;color: #333;line-height: 1.4em;font-family: sans-serif;text-align: center;margin: 0;padding: 0;}
		#definition {width: 45em;margin: 3em auto;text-align: left;}
		#go {margin: 1em 0;font-size: 1.4em;}
		#go a {padding: .5em 1.5em;border: 1px solid #ccc;background: #ffffcc;}
		h1 {font-size: 1.2em;margin: 0;padding: 0;}
		h2 {font-size: .9em;margin: 0;padding: 0;font-weight: normal; margin-bottom: 1em;}
		p {margin-top: 0;padding-top: 0;margin-bottom: 0;}
		a, a:visited {color: blue;text-decoration: none;border-bottom: 1px solid #ccc;}
		a:hover, a:visited:hover {border-bottom: 1px solid blue;}
		p+p, div+p {text-indent: 1em; margin-top: 1em;}
		.logged {font-size: .9em;color: #999;margin-top: 1em !important;display: block;}
		.block {display: block;width: 42em;scroll: auto;margin: .5em 0;background: #ffffcc;font-family: sans-serif;border: 1px solid #ccc;padding: 4px 1em; list-style-type: none; line-height: 1.6em;}
		a.requested ( color: #333; )
		-->
    </style>
  </head>
  <body>
  <div id='definition'>

  <h1>File Gone (410)</h1>

  <h2>There was an unrecoverable error in the current request.</h2>

  <?php echo $reqFancy; ?>

  <p>The <a href='#requested-file' class='requested'>requested file</a> previously existed, but has been removed. <?php echo $reqTrue ?></p>
  
  <?php backBtn($ref, $refParsed, $hName); ?>

  </div>
  </body>
</html>
