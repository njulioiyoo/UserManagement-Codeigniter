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
class Usermodel extends MY_Model
{
    public $id_user, $username, $password, $status, $hashpassword, $cookies, $created_at, $created_by, $updated_at, $updated_by;
    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function __construct()
    {
        parent::__construct();
        $this->_tablename = 'siak_user';
        $this->_pk        = 'id_user';

        $this->updated_at = date('Y-m-d H:i:s');
        $this->updated_by = $this->userlogin_id;
        if (empty($this->id_user)) {
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
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[50]|valid_email' . (empty($this->id_user) ? '|is_unique[siak_user.username]' : ''),
            array(
                'is_unique' => 'This %s already exists.',
            )
        );

        $password = 'Password';
        if (!empty($this->id_user)) {
            $password = 'New ' . $password;
        }

        $this->form_validation->set_rules('password', $password, 'trim|required|min_length[8]|alpha_numeric|max_length[255]');
        $this->form_validation->set_rules('confirm_password', 'Confirm ' . $password, 'trim|required|matches[password]');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function formlogin()
    {
        return array(
            'username' => array(
                'name'        => 'username',
                'id'          => 'field-username',
                'value'       => $this->username,
                'class'       => 'input-large span10',
                'type'        => 'text',
                'placeholder' => 'Type Username',
            ),
            'password' => array(
                'name'        => 'password',
                'id'          => 'field-password',
                'value'       => $this->password,
                'class'       => 'input-large span10',
                'type'        => 'password',
                'placeholder' => 'Type Password',
            ),
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
            'username'         => array(
                'name'  => 'username',
                'id'    => 'field-username',
                'value' => $this->username,
                // 'disabled'=>!empty($this->id_user),
                'type'  => 'email',
            ),
            'password'         => array(
                'name'  => 'password',
                'id'    => 'field-password',
                'value' => (!empty($this->id_user)) ? "" : $this->password,
                'type'  => 'password',
            ),
            'confirm_password' => array(
                'name' => 'confirm_password',
                'id'   => 'field-confirm_password',
                // 'value'=>$this->password,
                'type' => 'password',
            ),
            'status'           => array(
                'name'    => 'status',
                'value'   => $this->status,
                'options' => $this->status(), // inside MY_Model
                'extra'   => array(
                    'id'       => 'field-status',
                    'class'    => '',
                    'data-rel' => 'chosen',
                ),
            ),
        );
    }
} // END class
