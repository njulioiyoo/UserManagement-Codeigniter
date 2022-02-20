<?php defined('BASEPATH') OR exit('No direct script access allowed');

$base_url = $this->config['base_url'];

$config['assets']['optimus']['base_js'] = array(
	array('src'=>$base_url.'assets/optimus/js/jquery-1.9.1.min.js'),
	array('src'=>$base_url.'assets/optimus/js/jquery-migrate-1.0.0.min.js'),
	array('src'=>$base_url.'assets/optimus/js/jquery-ui-1.10.0.custom.min.js'),
	array('src'=>$base_url.'assets/optimus/js/bootstrap.js'),
);
$config['assets']['optimus']['base_css'] = array(
	array('href'=>$base_url.'assets/optimus/css/bootstrap.css', 'rel'=>'stylesheet', 'id'=>'bootstrap-style'),
	array('href'=>$base_url.'assets/lib/glyphicons/css/glyphicons.css', 'rel'=>'stylesheet'),
	array('href'=>$base_url.'assets/optimus/css/bootstrap-responsive.min.css', 'rel'=>'stylesheet'),
	array('href'=>$base_url.'assets/optimus/css/style.css', 'rel'=>'stylesheet', 'id'=>'base-style'),
	array('href'=>$base_url.'assets/optimus/css/style-responsive.css', 'rel'=>'stylesheet', 'id'=>'base-style-responsive'),
	array('href'=>$base_url.'assets/lib/fontawesome/css/font-awesome.min.css', 'rel'=>'stylesheet'),
);