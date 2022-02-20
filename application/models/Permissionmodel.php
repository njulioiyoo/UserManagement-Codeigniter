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
class Permissionmodel extends MY_Model
{
    public $id_permission, $modul_id, $name, $created_at, $created_by, $updated_at, $updated_by;
    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function __construct()
    {
        parent::__construct();
        $this->_tablename = 'siak_permission';
        $this->_pk        = 'id_permission';

        $this->updated_at = date('Y-m-d H:i:s');
        $this->updated_by = $this->userlogin_id;
        if (empty($this->id_permission)) {
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
        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[50]|alpha_numeric' . (empty($this->id_permission) ? '|is_unique[siak_permission.name]' : ''),
            array(
                'is_unique' => 'This %s already exists.',
            )
        );
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
            'name'     => array(
                'name'  => 'name',
                'id'    => 'field-name',
                'value' => $this->name,
            ),
            'modul_id' => array(
                'name'    => 'modul_id',
                'value'   => $this->modul_id,
                'options' => $this->_moduls(),
                'extra'   => array(
                    'id'       => 'field-modul_id',
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
    private function _moduls()
    {
        $moduls = array();
        $models = (new Modulmodel)->find()->result();
        if (sizeof($models) > 0) {
            foreach ($models as $model) {
                $moduls[$model->id_modul] = $model->name;
            }
        }

        return $moduls;
    }
} // END class
