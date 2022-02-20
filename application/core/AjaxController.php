<?php defined('BASEPATH') or exit('No direct script access allowed');
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
class AjaxController extends MY_Controller
{
    protected $response = array();
    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function __construct()
    {
        parent::__construct();
        // if(!$this->input->is_ajax_request()) show_error('failed load page.', 500, 'wrong method.');
    }
} // END class
