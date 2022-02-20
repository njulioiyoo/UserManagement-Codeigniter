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
class Role extends AdminController
{
    private $response = [];
    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Rolemodel');

        $this->breadcrumbs[1] = array('name' => 'Role', 'url' => base_url('role/index'), 'class' => '');
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
        $this->tabs['create']['src'] = base_url('role/input');

        if (!$this->auth->can('createRole')) {
            unset($this->tabs['create']);
        }

        $this->data['title'] = 'Role Apps';
        $this->data['body']  = $this->load->view('role/index', $this->data, true);
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
            ->render('viewRole');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function tablegroupuser()
    {
        if (!$this->input->is_ajax_request()) {
            show_error('undefined request', 500, 'wrong method');
        }

        $sidx = $this->input->post('sidx');
        $sord = $this->input->post('sord');

        $offset = $this->input->post('page');
        $limit  = $this->input->post('rows');

        // individual search
        $like = $this->searchRole();

        $group = new Rolemodel;

        // prev data
        if (sizeof($like) > 0) {
            $group->like($like);
        }

        $prev = $group->find()->result();
        // prev data

        $this->response['records'] = sizeof($prev);
        $this->response['total']   = ceil($this->response['records'] / $limit);

        $params          = array();
        $params['start'] = ($offset * $limit) - $limit;
        $params['limit'] = $limit;

        // next data
        $group->order($sidx, $sord);
        if (sizeof($like) > 0) {
            $group->like($like);
        }

        $next = $group->limit($params['limit'], $params['start'])->find()->result();
        // next data

        if (sizeof($next) > 0) {
            foreach ($next as $key => $value) {
                $edit   = '<a href="' . base_url("role/input/" . $value->id_role) . '" class="btn btn-small btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                $delete = '<button data-delete="' . base_url("role/delete/" . $value->id_role) . '" data-name="' . $value->name . '" class="btn btn-small btn-danger" onclick="deleterow(this)"><i class="fa fa-trash"></i> Delete</button>';

                if (!$this->auth->can('updateRole')) {
                    $edit = '';
                }

                if (!$this->auth->can('deleteRole')) {
                    $delete = '';
                }

                $this->response['rows'][] = array(
                    'act'     => $edit . "&nbsp;" . $delete,
                    'name'    => $value->name,
                    'remarks' => $value->name,
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
    public function searchRole()
    {
        $like    = array();
        $name    = $this->input->post('name', true);
        $remarks = $this->input->post('remarks', true);

        if ($name != '') {
            $like['LOWER(name)'] = strtolower($name);
        }

        if ($remarks != '') {
            $like['LOWER(name)'] = strtolower($remarks);
        }

        return $like;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function input($id = false)
    {
        $permission = 'createRole';
        $title      = 'New';
        $role       = new Rolemodel;
        if ($id) {
            $permission = 'updateRole';
            $title      = 'Update';
            $role       = $role->where(array('id_role' => $id))->find()->row(0, 'Rolemodel');
        }

        // collect user input if store in sessions
        if ($this->session->userdata('post')) {
            $post       = json_decode(json_encode($this->session->userdata('post')));
            $role->name = $post->name;
            $this->session->unset_userdata('post'); // unset session
        }

        // tabs must define before load body
        $this->tabs['list']['src']     = base_url('role');
        $this->tabs['create']['class'] = 'active';
        $this->tabs['create']['title'] = $title;

        // content
        $this->data['model'] = $role;
        $this->data['title'] = $title . ' Role';
        $this->data['body']  = $this->load->view('role/input', $this->data, true);
        // content

        // breadcrumbs
        $this->breadcrumbs[2] = array('name' => $title, 'url' => '#', 'class' => '');
        $this->setBreadcrumbs($this->breadcrumbs)
            ->render($permission);
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function save()
    {
        $output        = array();
        $role          = new Rolemodel;
        $role->id_role = $this->input->post('id_role');
        $role->name    = $this->input->post('name', true);

        // validate
        $role->validate();
        if (!$this->form_validation->run()) {
            $output['errors']['name'] = form_error('name', '<span>', '</span>');
            $this->session->set_flashdata('errors', $output['errors']);
            $this->session->set_userdata('post', $_POST);
            redirect(site_url('role/input/' . $role->id_role));
        }

        $id_role = $role->save();
        if (!empty($id_role)) {
            $this->session->set_flashdata('flash-delete', array('success' => 'Saved'));
            redirect(site_url('role'));
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
        if (!$this->auth->can('deleteRole')) {
            $this->session->set_flashdata('flash-delete', array('error' => 'doesnt have permission for deleteRole'));
            redirect(site_url('role'), 'refresh');
        }

        $id            = $this->uri->segment(3);
        $role          = new Rolemodel;
        $role->id_role = $id;

        if ($role->delete()) {
            $this->session->set_flashdata('flash-delete', array('success' => 'Delete'));
            redirect(site_url("role"));
        }
    }
} // END class
