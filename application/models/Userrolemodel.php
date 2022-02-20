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
class Userrolemodel extends MY_Model
{
    public $id_userrole, $role_id, $user_id, $created_at, $created_by, $updated_at, $updated_by;
    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function __construct()
    {
        parent::__construct();
        $this->_tablename = 'siak_user_role';
        $this->_pk        = 'id_userrole';

        $this->updated_at = date('Y-m-d H:i:s');
        $this->updated_by = $this->userlogin_id;
        if (empty($this->id_userrole)) {
            $this->created_at = $this->updated_at;
            $this->created_by = $this->updated_by;
        }
    }
} // END class
