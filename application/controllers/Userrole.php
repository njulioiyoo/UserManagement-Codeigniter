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
class Userrole extends AdminController
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
        $this->load->model('Userrolemodel');
        $this->load->model('Usermodel');
        $this->load->model('Rolemodel');
        $this->breadcrumbs[1] = array('name' => 'User', 'url' => base_url('userrole/index'), 'class' => '');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function tableuserrole()
    {
        if (!$this->input->is_ajax_request()) {
            show_error('undefined request', 500, 'wrong method');
        }

        $sidx = $this->input->post('sidx');
        $sord = $this->input->post('sord');

        $offset = $this->input->post('page');
        $limit  = $this->input->post('rows');

        // individual search
        $like = $this->searchUserRole();

        $fields = 'u.id_user, u.username, GROUP_CONCAT(r.name SEPARATOR \',\') rolename';
        $user   = new Usermodel;
        $user->settable('siak_user u');
        $user->with(
            array('siak_user_role ur', 'ur.user_id = u.id_user', 'LEFT'),
            array('siak_role r', 'ur.role_id = r.id_role', 'LEFT')
        );
        // prev data
        if (sizeof($like) > 0) {
            $user->like($like);
        }

        $prev = $user->group('u.id_user')->find($fields)->result();
        // prev data

        // die($this->db->last_query());

        $this->response['records'] = sizeof($prev);
        $this->response['total']   = ceil($this->response['records'] / $limit);

        $params          = array();
        $params['start'] = ($offset * $limit) - $limit;
        $params['limit'] = $limit;

        // next data
        $user->settable('siak_user u');
        $user->with(
            array('siak_user_role ur', 'ur.user_id = u.id_user', 'LEFT'),
            array('siak_role r', 'ur.role_id = r.id_role', 'LEFT')
        );
        $user->order($sidx, $sord);
        if (sizeof($like) > 0) {
            $user->like($like);
        }

        $next = $user->limit($params['limit'], $params['start'])->group('u.id_user')->find($fields)->result();
        // next data

        if (sizeof($next) > 0) {
            foreach ($next as $key => $value) {
                $edit   = '<a href="' . base_url("userrole/input/" . $value->id_user) . '" class="btn btn-small btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                $delete = '<button data-delete="' . base_url("userrole/delete/" . $value->id_user) . '" data-name="' . $value->username . '" class="btn btn-small btn-danger" onclick="deleterow(this)"><i class="fa fa-trash"></i> Delete</button>';

                if (!$this->auth->can('updateUserRole')) {
                    $edit = '';
                }

                if (!$this->auth->can('deleteUserRole')) {
                    $delete = '';
                }

                $this->response['rows'][] = array(
                    'act'      => $edit . "&nbsp;" . $delete,
                    'username' => $value->username,
                    'rolename' => $value->rolename,
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
    private function searchUserRole()
    {
        $like     = array();
        $username = $this->input->post('username');
        $rolename = $this->input->post('rolename');
        if ($username != '') {
            $like['LOWER(u.username)'] = strtolower($username);
        }

        if ($rolename != '') {
            $like['LOWER(r.name)'] = strtolower($rolename);
        }

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
        unset($this->tabs['create']);

        $this->data['title'] = 'User Role Apps';
        $this->data['body']  = $this->load->view('userrole/index', $this->data, true);
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
            ->render('viewUserRole');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function input($user_id = false)
    {
        $title  = 'Update';
        $fields = 'u.id_user, u.username, r.id_role, r.name';
        $user   = new Usermodel;
        $user->settable('siak_user u');
        $user->with(
            array('siak_user_role ur', 'ur.user_id = u.id_user', 'LEFT'),
            array('siak_role r', 'ur.role_id = r.id_role', 'LEFT')
        );
        $users = $user->where(array('u.id_user' => $user_id))->find($fields)->result();

        $roles     = array();
        $rolenames = array();
        $_role     = (new Rolemodel)->find()->result();
        if (sizeof($_role) > 0) {
            foreach ($_role as $role) {
                $roles[$role->id_role] = $role->name;
            }
        }

        $this->data['roles'] = $roles;

        if (sizeof($users) > 0) {
            foreach ($users as $key => $value) {
                if (isset($roles[$value->id_role])) {
                    $rolenames[$value->id_role] = $roles[$value->id_role];
                    unset($roles[$value->id_role]);
                }
            }
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

        // content
        $this->data['rolenames'] = $rolenames;
        $this->data['model']     = $users;
        $this->data['title']     = $title . ' User';
        $this->data['body']      = $this->load->view('userrole/input', $this->data, true);
        // content

        // breadcrumbs
        $this->breadcrumbs[2] = array('name' => $title, 'url' => '#', 'class' => '');
        $this->setBreadcrumbs($this->breadcrumbs)
            ->setJs(
                array(array('src' => base_url('assets/lib/multiselect/multiselect.min.js'))),
                'bottom'
            )
            ->render('updateUserRole');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function save()
    {
        $id_user  = $this->input->post('id_user');
        $rolename = $this->input->post('rolename'); // array
        $old      = (new Userrolemodel)->where(array('user_id' => $id_user))->find()->result();
        if (sizeof($rolename) > 0) {
            foreach ($rolename as $key => $role_id) {
                $id_userrole = array();
                if (sizeof($old) > 0) {
                    foreach ($old as $index => $value) {
                        if ($value->role_id == $role_id) {
                            $id_userrole[$value->role_id] = $value->id_userrole;
                            unset($old[$index]);
                        }
                    }
                }
                $userrole              = new Userrolemodel;
                $userrole->id_userrole = isset($id_userrole[$role_id]) ? $id_userrole[$role_id] : "";
                $userrole->user_id     = $id_user;
                $userrole->role_id     = $role_id;
                $userrole->save();
            }

            if (sizeof($old) > 0) {
                foreach ($old as $key => $value) {
                    $user              = new Userrolemodel;
                    $user->id_userrole = $value->id_userrole;
                    $user->delete();
                }
            }

            $this->session->set_flashdata('flash-delete', array('success' => 'Saved'));
            redirect(site_url('userrole'));
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
        if (!$this->auth->can('deleteUserRole')) {
            $this->session->set_flashdata('flash-delete', array('error' => 'doesnt have permission for deleteUserRole'));
            redirect(site_url('user'), 'refresh');
        }

        $id       = $this->uri->segment(3);
        $userrole = new Userrolemodel;
        $userrole->setpkey('user_id');
        $userrole->user_id = $id;
        if ($userrole->delete()) {
            $this->session->set_flashdata('flash-delete', array('success' => 'Deleted'));
            redirect(site_url('userrole'));
        }
    }
} // END class
