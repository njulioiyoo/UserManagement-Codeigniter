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
class Login extends PublicController
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
        $this->load->model('Usermodel');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function index()
    {
        if ($this->session->userdata('username') !== null) {
            redirect(site_url('dashboard'));
        }

        $model               = new Usermodel;
        $this->data['model'] = $model;
        $this->data['title'] = 'Login Page';

        $this->load->view('templates/bootstrap/login', $this->data);
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function validate()
    {
        // CVarDumper::dump($_POST, 10, true);
        $output   = array();
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        $remember = $this->input->post('remember');

        $this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email|max_length[50]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if (!$this->form_validation->run()) {
            $output['errors']['username'] = form_error('username', '<span>', '</span>');
            $output['errors']['password'] = form_error('password', '<span>', '</span>');
            $this->session->set_flashdata('errors', $output['errors']);
            redirect(site_url('login'));
        }

        $user = (new Usermodel)->where(array('username' => $username))->find('*')->row();
        if (!empty($user) && hash_equals($user->hashpassword, crypt($password, $user->hashpassword))) {
            //if(!empty($user) && md5($password) == $user->hashpassword){

            if ($remember == 'on') {
                $key = random_string('alnum', 64);
                set_cookie('app-siak', $key, 3600 * 24 * 30);

                // update cookies user
                $_user          = new Usermodel;
                $_user->id_user = $user->id_user;
                $_user->cookies = $key;
                $_user->save(false);

            }

            $session = array(
                'userlogin_id'    => $user->id_user,
                'userlogin_name'  => $user->username,
                'userlogin_email' => $user->username,
            );
            $this->session->set_userdata($session);

            redirect(site_url('dashboard'));
        }

        $this->session->set_flashdata('errors', array('Login Failed'));
        redirect(site_url('login'));
    }
} // END class
