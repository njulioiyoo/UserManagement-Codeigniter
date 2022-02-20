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
class Rolepermissionmodel extends MY_Model
{
    public $id_rolepermission, $permission_id, $role_id, $created_at, $created_by, $updated_at, $updated_by;
    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function __construct()
    {
        parent::__construct();
        $this->_tablename = 'siak_role_permission';
        $this->_pk        = 'id_rolepermission';

        $this->updated_at = date('Y-m-d H:i:s');
        $this->updated_by = $this->userlogin_id;
        if (empty($this->id_rolepermission)) {
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
        // $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[50]');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function form()
    {
        return array(
            // 'name' => array(
            //     'name'=>'name',
            //     'id'=>'field-name',
            //     'value'=>$this->name,
            // ),
            'role_id' => array(
                'name'    => 'role_id',
                'value'   => $this->role_id,
                'options' => $this->_roles(),
                'extra'   => array(
                    'id'       => 'field-role_id',
                    'class'    => '',
                    'data-rel' => 'chosen',
                ),
            ),
        );
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    private function _roles()
    {
        $roles  = array();
        $models = (new Rolemodel)->find()->result();
        if (sizeof($models) > 0) {
            foreach ($models as $model) {
                $roles[$model->id_role] = $model->name;
            }
        }

        return $roles;
    }
} // END class
