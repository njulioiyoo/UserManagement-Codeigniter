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
class Logmodel extends MysqlModel
{
    public $id_log, $table_id, $table_name, $content, $created_by, $created_at;
    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function __construct()
    {
        parent::__construct();
        $this->_tablename = 'helpdesk_log';
        $this->_pk        = 'id_log';
    }
} // END class
