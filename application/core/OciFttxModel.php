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
class OciFttxModel extends CI_Model
{
	private $fttx = null;
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function __construct()
	{
		parent::__construct();
		$this->fttx = $this->load->database('FTTX', TRUE);
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function getConnection()
	{
		if(!empty($this->fttx)) return $this->fttx;

		return $this->load->database('FTTX', TRUE);
	}
} // END class 