<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * ***************************************************************
 * Script : PHP
 * Version : Codeigniter 3.1.9
 * Author : Julio Notodiprodyo
 * Email : njulioiyoo@gmail.com
 * ***************************************************************
 */
 
use Psr\Log\LogLevel;

/**
 * undocumented class
 *
 * @package default
 * @author 
 **/
class MY_Controller extends CI_Controller
{
	private $logger = null;
	protected $_js = array();
	protected $_css = array();
	protected $assets = array();
	protected $cachetime = 3600;

	public $data = array();
	public $userlogin_id;
	public $userlogin_name;
	public $userlogin_email;
	public $access = 'hellloooo';
	public $page_id = null;

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function __construct()
	{
		parent::__construct();

		$this->data['title'] = 'My Great Apps';

		// FOR DEVELOPMENT USE ONLY
		// $this->userlogin_id = 2711;
		// $this->userlogin_name = strtoupper('njulioiyoo');
		// $this->userlogin_email = 'njulioiyoo@gmail.com';


		$session = $this->session->userdata();
		// CVarDumper::dump($session, 10, true);
		if(isset($session['userlogin_id'])){
			$this->userlogin_id = $session['userlogin_id'];
			$this->userlogin_name = strtoupper($session['userlogin_name']);
			$this->userlogin_email = $session['userlogin_email'];
	
			$this->auth->user($this->userlogin_id);
		}
		// FOR DEVELOPMENT USE ONLY
		
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function logout()
	{
		delete_cookie('app-siak');
        $this->session->sess_destroy();
        redirect(site_url('dashboard'));
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	protected function setDefaultTabs()
	{
		return array(
			'list'=>array('src'=>null, 'title'=>'List', 'class'=>'', 'icon'=>'<i class="fa fa-dashboard"></i>'),
			'create'=>array('src'=>null, 'title'=>'New', 'class'=>'', 'icon'=>'<i class="fa fa-user"></i>'),
		);
	}

	/**
	 * undocumented function
	 *
	 * @return String
	 * @author 
	 **/
	protected function alertSuccess($msg = 'success saved data')
	{
		return '<div class="alert alert-succes">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>ERROR !</strong> '.$msg.'.
				</div>';
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	protected function alertDanger($msg = 'failed saved data')
	{
		return '<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>ERROR !</strong> '.$msg.'.
				</div>';
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	protected function createdTime()
	{
		return date('Y-m-d H:i:s');
		// return '2017-04-18 19:50:00';
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	protected function assets()
	{
		return $this->config->item('assets');
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	protected function setImgHeader($file)
	{
		$this->data['image_header'] = img($file);
		return $this;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	protected function registerScript($scriptString, $type = 'js')
	{
		switch ($type) {
			case 'css':
				$this->_css[] = "\n".'<style>'.$scriptString.'</style>';
				break;
			
			default:
				$this->_js['bottom'][] = "\n".'<script type="text/javascript">'.$scriptString.'</script>';
				break;
		}
		
		return $this;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	protected function setJs($file, $position = 'top')
	{

		if(!is_array($file)){
			$this->_js[$position][] = _loadasset(_attributes_to_string(array('src'=>$file)));
		}else{
			foreach ($file as $key => $value) {
				if(!is_array($value)){
					$value = array('src'=>base_url($value));
				}
				$this->_js[$position][] = _loadasset(_attributes_to_string($value));
			}
		}

		return $this;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	protected function setCss($file)
	{

		if(!is_array($file)){
			$this->_css[] = _loadasset(_attributes_to_string(array('href'=>base_url($file))), 'css');
		}else{
			foreach ($file as $key => $value) {
				if(!is_array($value)){
					$value = array('href'=>base_url($value));
				}
				$this->_css[] = _loadasset(_attributes_to_string($value), 'css');
			}
		}

		return $this;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	protected function setBreadcrumbs($breadcrumbs = array())
	{
		$_breadcrumbs = '';
		if(sizeof($breadcrumbs)>0){
			foreach ($breadcrumbs as $key => $value) {
				$_breadcrumbs .= '<li class="'.(isset($value['class']) ? $value['class'] : '').'">';
				$_breadcrumbs .= '<a href="'.(isset($value['url']) ? $value['url'] : '').'">';
				$_breadcrumbs .= isset($value['name']) ? $value['name'] : '';
				$_breadcrumbs .= '</a>';
				$_breadcrumbs .= isset($breadcrumbs[($key+1)]) ? '<span class="divider">/</span>':'';
				$_breadcrumbs .= '</li>';
			}
		}
		$this->data['breadcrumbs'] = $_breadcrumbs;
		return $this;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	protected function render($permission = false)
	{
		if(isset($this->_js['top']))
			$this->data['assets_js_top'] = implode("\n", $this->_js['top']);

		if(isset($this->_js['bottom']))
			$this->data['assets_js_bottom'] = implode("\n", $this->_js['bottom']);

		$this->data['assets_css'] = implode("\n", $this->_css);

		// validate
		if($permission && !$this->auth->can($permission)){
			$this->data['body'] = $this->alertDanger('doesnt have permission for '.$permission); // ovveride body content if doesnt have access
		}

		$this->load->view('templates/bootstrap/header', $this->data);
		$this->load->view('templates/bootstrap/body', $this->data);
		$this->load->view('templates/bootstrap/footer', $this->assets);
	}

} // END class 