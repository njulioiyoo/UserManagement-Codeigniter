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
class Rolemodel extends MY_Model
{
    public $id_role, $name, $created_at, $created_by, $updated_at, $updated_by;

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function __construct()
    {
        parent::__construct();
        $this->_tablename = 'siak_role';
        $this->_pk        = 'id_role';

        $this->updated_at = date('Y-m-d H:i:s');
        $this->updated_by = $this->userlogin_id;
        if (empty($this->id_role)) {
            $this->created_at = $this->updated_at;
            $this->created_by = $this->updated_by;
        }
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function validate()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[50]|is_unique[siak_role.name]',
            array(
                'is_unique' => 'This %s already exists.',
            )
        );
    }

    /**
     * form input
     *
     * @return void
     * @author
     **/
    public function form()
    {
        return array(
            'name' => array(
                'name'  => 'name',
                'id'    => 'field-name',
                'value' => $this->name,
            ),
        );
    }
} // END class
