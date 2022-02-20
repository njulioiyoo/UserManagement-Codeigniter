<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
	<title><?php echo $title;?></title>

<?php echo isset($assets_css) ? $assets_css."\n" : ""; ?>
<?php echo isset($assets_js_top) ? $assets_js_top."\n" : ""; ?>

	<!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>
<body>
<header>
    <!-- IMAGE HEADER -->
    <?php echo isset($image_header) ? $image_header."\n" : ""; ?>
    <!-- IMAGE HEADER -->
    <div class="container">
        <div class="row">
            <div class="navbar-inverse navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
        </div>
    </div>
</header>