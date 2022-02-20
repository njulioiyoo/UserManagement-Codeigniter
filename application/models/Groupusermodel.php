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
class Groupusermodel extends MysqlModel
{
    public $id_groupuser, $name, $remarks, $status, $created_at, $updated_at, $created_by, $updated_by;
    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function __construct()
    {
        parent::__construct();
        $this->_tablename = 'helpdesk_groupuser';
        $this->_pk        = 'id_groupuser';
    }
} // END class
