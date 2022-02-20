<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php echo $title;?></title>

	<meta name="author" content="njulioiyoo">

<?php echo isset($assets_css) ? $assets_css."\n" : ""; ?>
<?php echo isset($assets_js_top) ? $assets_js_top."\n" : ""; ?>

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- start: Favicon -->
	<!-- <link rel="shortcut icon" href="img/favicon.ico"> -->
	<!-- end: Favicon -->

</head>
<body>
