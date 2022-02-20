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
class User extends AdminController
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
        $this->breadcrumbs[1] = array('name' => 'User', 'url' => base_url('user/index'), 'class' => '');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function tableuser()
    {
        if (!$this->input->is_ajax_request()) {
            show_error('undefined request', 500, 'wrong method');
        }

        $sidx = $this->input->post('sidx');
        $sord = $this->input->post('sord');

        $offset = $this->input->post('page');
        $limit  = $this->input->post('rows');

        // individual search
        $like = $this->searchUser();

        $user   = new Usermodel;
        $status = $user->status();

        // prev data
        if (sizeof($like) > 0) {
            $user->like($like);
        }

        $prev = $user->find()->result();
        // prev data

        $this->response['records'] = sizeof($prev);
        $this->response['total']   = ceil($this->response['records'] / $limit);

        $params          = array();
        $params['start'] = ($offset * $limit) - $limit;
        $params['limit'] = $limit;

        // next data
        $user->order($sidx, $sord);
        if (sizeof($like) > 0) {
            $user->like($like);
        }

        $next = $user->limit($params['limit'], $params['start'])->find()->result();
        // next data

        if (sizeof($next) > 0) {
            foreach ($next as $key => $value) {
                $edit   = '<a href="' . base_url("user/input/" . $value->id_user) . '" class="btn btn-small btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                $delete = '<button data-delete="' . base_url("user/delete/" . $value->id_user) . '" data-name="' . $value->username . '" class="btn btn-small btn-danger" onclick="deleterow(this)"><i class="fa fa-trash"></i> Delete</button>';

                if (!$this->auth->can('updateUser')) {
                    $edit = '';
                }

                if (!$this->auth->can('deleteUser')) {
                    $delete = '';
                }

                $this->response['rows'][] = array(
                    'act'      => $edit . "&nbsp;" . $delete,
                    'username' => $value->username,
                    'status'   => $status[$value->status],
                );
            }
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($this->response, 128));
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    private function searchUser()
    {
        $like = array();
        return $like;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function index()
    {
        // breadcrumbs
        $this->breadcrumbs[2] = array('name' => 'Index', 'url' => '#', 'class' => '');
        // tabs
        $this->tabs['list']['class'] = 'active';
        $this->tabs['create']['src'] = base_url('user/input');

        $this->data['title'] = 'User Apps';
        $this->data['body']  = $this->load->view('user/index', $this->data, true);
        $this->setBreadcrumbs($this->breadcrumbs)
            ->setCss(
                array(
                    array('href' => base_url('assets/lib/jqgrid/css/ui.jqgrid-bootstrap.css'), 'rel' => 'stylesheet'),
                    // array('href'=>base_url('assets/lib/jqgrid/css/ui.jqgrid-bootstrap-ui.css'), 'rel'=>'stylesheet'),
                    // array('href'=>base_url('assets/lib/jqgrid/css/ui.jqgrid.css'), 'rel'=>'stylesheet'),
                )
            )
            ->setJs(
                array(
                    array('src' => base_url('assets/lib/jqgrid/js/i18n/grid.locale-en.js')),
                    array('src' => base_url('assets/lib/jqgrid/js/jquery.jqGrid.min.js')),
                ), 'bottom'
            )
            ->render('viewUser');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function input($id = false)
    {
        $title = 'New';
        $user  = new Usermodel;
        if ($id) {
            $title = 'Update';
            $user  = $user->where(array('id_user' => $id))->find()->row(0, 'Usermodel');
        }

        // collect user input if store in sessions
        if ($this->session->userdata('post')) {
            $post                   = json_decode(json_encode($this->session->userdata('post')));
            $user->username         = $post->username;
            $user->password         = $post->password;
            $user->confirm_password = $post->confirm_password;
            $this->session->unset_userdata('post'); // unset session
        }

        // tabs must define before load body
        $this->tabs['list']['src']     = base_url('user');
        $this->tabs['create']['class'] = 'active';
        $this->tabs['create']['title'] = $title;

        if (!$this->auth->can('createUser')) {
            unset($this->tabs['create']);
        }

        // content
        $this->data['model'] = $user;
        $this->data['title'] = $title . ' User';
        $this->data['body']  = $this->load->view('user/input', $this->data, true);
        // content

        // breadcrumbs
        $this->breadcrumbs[2] = array('name' => $title, 'url' => '#', 'class' => '');
        $this->setBreadcrumbs($this->breadcrumbs)
            ->setJs(
                array(array('src' => base_url('assets/optimus/js/jquery.chosen.min.js'))),
                'bottom'
            )
            ->render();
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function save()
    {
        $user           = new Usermodel;
        $user->id_user  = $this->input->post('id_user');
        $user->username = $this->input->post('username');
        $user->password = $this->input->post('password');
        $user->status   = $this->input->post('status');
        $user->validate();
        if (!$this->form_validation->run()) {
            $output['errors']['username']         = form_error('username');
            $output['errors']['password']         = form_error('password');
            $output['errors']['confirm_password'] = form_error('confirm_password');

            $this->session->set_flashdata('errors', $output['errors']);
            $this->session->set_userdata('post', $_POST);
            redirect(site_url('user/input/' . $user->id_user));
        }

        // hash password
        // $cost               = 10;
        // $salt               = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.'); // random salt
        // $salt               = sprintf("$2a$%02d$", $cost) . $salt;
        $user->hashpassword = crypt($user->password);
        $user->password     = $user->hashpassword;

        $id_user = $user->save();

        if (!empty($id_user)) {
            $this->session->set_flashdata('flash-delete', array('success' => 'Saved'));
            redirect(site_url('user'));
        }
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function delete()
    {
        if (!$this->auth->can('deleteUser')) {
            $this->session->set_flashdata('flash-delete', array('error' => 'doesnt have permission for deleteUser'));
            redirect(site_url('user'), 'refresh');
        }

        $id            = $this->uri->segment(3);
        $user          = new Usermodel;
        $user->id_user = $id;
        if ($user->delete()) {
            $this->session->set_flashdata('flash-delete', array('success' => 'Deleted'));
            redirect(site_url('user'));
        }
    }
} // END class
