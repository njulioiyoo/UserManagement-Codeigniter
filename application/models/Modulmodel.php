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
class Modulmodel extends MY_Model
{
    public $id_modul, $parent_id, $name, $url, $icon, $created_at, $created_by, $updated_at, $updated_by;
    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function __construct()
    {
        parent::__construct();
        $this->_tablename = 'siak_modul';
        $this->_pk        = 'id_modul';

        $this->updated_at = date('Y-m-d H:i:s');
        $this->updated_by = $this->userlogin_id;
        if (empty($this->id_modul)) {
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
        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('icon', 'Icon', 'trim|max_length[50]');
        $this->form_validation->set_rules('url', 'Url', 'trim|max_length[100]');
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
            'name'      => array(
                'name'  => 'name',
                'id'    => 'field-name',
                'value' => $this->name,
            ),
            'icon'      => array(
                'name'        => 'icon',
                'id'          => 'field-icon',
                'readonly'    => 'readonly',
                'placeholder' => 'click to choose icon',
                'value'       => $this->icon,
                'onclick'     => 'showicons()',
            ),
            'parent_id' => array(
                'name'    => 'parent_id',
                'value'   => $this->parent_id,
                'options' => $this->_parents(),
                'extra'   => array(
                    'id'       => 'field-parent_id',
                    'class'    => '',
                    'data-rel' => 'chosen',
                ),
            ),
            'url'       => array(
                'name'    => 'url',
                'value'   => $this->url,
                'options' => $this->_url(),
                'extra'   => array(
                    'id'       => 'field-url',
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
    private function _parents()
    {
        $parents = array('' => 'None');
        $models  = $this->find()->result();
        if (sizeof($models) > 0) {
            foreach ($models as $model) {
                $parents[$model->id_modul] = $model->name;
            }
        }

        return $parents;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    private function _url()
    {
        $this->load->library('controllerlist');
        $_pages = array('#' => 'None');
        $pages  = $this->controllerlist->getControllers();
        if (sizeof($pages) > 0) {
            foreach ($pages as $key => $value) {
                $_pages[$key] = array();
                foreach ($value as $field) {
                    $_pages[$key][$key . "/" . $field] = $key . "/" . $field;
                }
            }
        }
        return $_pages;
    }
} // END class
