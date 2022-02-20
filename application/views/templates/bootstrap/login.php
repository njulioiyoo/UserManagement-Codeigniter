<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php echo $title;?></title>

	<meta name="author" content="njulioiyoo">

	<!-- start: CSS -->
	<link id="bootstrap-style" href="<?php echo base_url('assets/optimus/css/bootstrap.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/optimus/css/bootstrap-responsive.min.css');?>" rel="stylesheet">
	<link id="base-style" href="<?php echo base_url('assets/optimus/css/style.css');?>" rel="stylesheet">
	<!-- <link id="base-style-responsive" href="<?php echo base_url('assets/optimus/css/style-responsive.css');?>" rel="stylesheet"> -->
	<!-- end: CSS -->

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- start: Favicon -->
	<!-- <link rel="shortcut icon" href="img/favicon.ico"> -->
	<!-- end: Favicon -->

</head>
<body>
<?php
$form = $model->formlogin(); // array of fields
$errors = $this->session->flashdata('errors'); // errors value

// CVarDumper::dump($errors, 10, true);
?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="login-box">
			<?php if(is_array($errors) && sizeof($errors)>0): ?>
				<?php foreach($errors as $key=>$message):?>
					<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong><?php echo strtoupper($key);?> ERROR !</strong> <?php echo $message;?>.
					</div>
				<?php endforeach;?>
			<?php endif;?>
			<div class="icons">
				<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/optimus/img/kompas-gramedia.png" alt="Logo Admin" class="img-responsive center-block" /></a>
				<!-- <a href="#"><i class="icon-cog"></i></a> -->
			</div>
			<h2>Login Application</h2>
			<?php echo form_open('login/validate', 'class="form-horizontal"');?>
				<fieldset>
					<div class="input-prepend" title="Username">
						<span class="add-on"><i class="icon-user"></i></span>
						<?php echo form_input($form['username']);?>
					</div>
					<div class="clearfix"></div>

					<div class="input-prepend" title="Password">
						<span class="add-on"><i class="icon-lock"></i></span>
						<?php echo form_input($form['password']);?>
						<span class="help-inline" id="error-password"></span>
					</div>
					<div class="clearfix"></div>
					
					<label class="remember" for="remember">
						<input type="checkbox" name="remember" id="remember" />
						Remember me
					</label>

					<div class="btn-group button-login">	
						<!-- <button type="submit" class="btn btn-primary"><i class="icon-off icon-white"></i></button> -->
						<button type="submit" class="btn btn-primary">Login</button>
					</div>
					<div class="clearfix"></div>
			<?php echo form_close();?>
			<hr>

		</div><!--/span-->
	</div>
</div>

<script src="<?php echo base_url('assets/optimus/js/jquery-1.9.1.min.js');?>"></script>
<script src="<?php echo base_url('assets/optimus/js/jquery-migrate-1.0.0.min.js');?>"></script>
<script src="<?php echo base_url('assets/optimus/js/jquery-ui-1.10.0.custom.min.js');?>"></script>

<script src="<?php echo base_url('assets/optimus/js/bootstrap.js');?>"></script>

</body>
</html>