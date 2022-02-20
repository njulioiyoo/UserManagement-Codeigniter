<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * ***************************************************************
 * Script : PHP
 * Version : Codeigniter 3.1.9
 * Author : Julio Notodiprodyo
 * Email : njulioiyoo@gmail.com
 * ***************************************************************
 */
 
/**
 * undocumented class
 *
 * @package default
 * @author 
 **/
class PublicController extends MY_Controller
{
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function __construct()
	{
		parent::__construct();

		if($this->session->userdata('userlogin_id')){
			redirect(site_url('dashboard'));
		}

		// cookies
		$cookies = get_cookie('app-siak');
		if($cookies != ''){
			$this->load->model('Usermodel');
			$user = (new Usermodel)->where(array('cookies'=>$cookies))->find()->row();
			if(!empty($user)){
				$session = array(
					'userlogin_id'=>$user->id_user,
					'userlogin_name'=>$user->username,
					'userlogin_email'=>$user->username,
				);
				$this->session->set_userdata($session);

				redirect(site_url('dashboard'));
			}
		}
	}

} // END class 