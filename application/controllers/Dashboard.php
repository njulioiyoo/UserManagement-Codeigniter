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
class Dashboard extends AdminController
{
    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[1] = array('name' => 'Index', 'url' => base_url('dashboard/index'), 'class' => '');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function index()
    {
        $this->setBreadcrumbs($this->breadcrumbs)
            ->render();
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function input()
    {
        $this->breadcrumbs[2] = array('name' => 'New', 'url' => '#', 'class' => '');
        $this->setBreadcrumbs($this->breadcrumbs)
            ->render();
    }
} // END class
