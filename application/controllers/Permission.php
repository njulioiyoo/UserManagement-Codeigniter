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
class Permission extends AdminController
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
        $this->load->model('Permissionmodel');
        $this->load->model('Modulmodel');
        // breadcrumbs
        $this->breadcrumbs[1] = array('name' => 'Permission', 'url' => base_url('permission/index'), 'class' => '');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function tablepermission()
    {
        if (!$this->input->is_ajax_request()) {
            show_error('undefined request', 500, 'wrong method');
        }

        $sidx = $this->input->post('sidx');
        $sord = $this->input->post('sord');

        $offset = $this->input->post('page');
        $limit  = $this->input->post('rows');

        // individual search
        $like = $this->searchPermission();

        $fields     = 'sp.*, sm2.name parent';
        $permission = new Permissionmodel;
        $permission->settable('siak_permission sp');
        $permission->with(
            array('siak_modul sm2', 'sm2.id_modul = sp.modul_id', 'INNER')
        );

        // prev data
        if (sizeof($like) > 0) {
            $permission->like($like);
        }

        $prev = $permission->find($fields)->result();
        // prev data

        $response            = array();
        $response['records'] = sizeof($prev);
        $response['total']   = ceil($response['records'] / $limit);

        $params          = array();
        $params['start'] = ($offset * $limit) - $limit;
        $params['limit'] = $limit;

        // next data
        $permission->settable('siak_permission sp');
        $permission->with(
            array('siak_modul sm2', 'sm2.id_modul = sp.modul_id', 'INNER')
        );
        $permission->order($sidx, $sord);
        if (sizeof($like) > 0) {
            $permission->like($like);
        }

        $next = $permission->limit($params['limit'], $params['start'])->find($fields)->result();
        // next data

        if (sizeof($next) > 0) {
            foreach ($next as $key => $value) {
                $edit   = '<a href="' . base_url("permission/input/" . $value->id_permission) . '" class="btn btn-small btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                $delete = '<button data-delete="' . base_url("permission/delete/" . $value->id_permission) . '" data-name="' . $value->name . '" class="btn btn-small btn-danger" onclick="deleterow(this)"><i class="fa fa-trash"></i> Delete</button>';

                if (!$this->auth->can('updatePermission')) {
                    $edit = '';
                }

                if (!$this->auth->can('deletePermission')) {
                    $delete = '';
                }

                $response['rows'][] = array(
                    'act'    => $edit . "&nbsp;" . $delete,
                    'name'   => $value->name,
                    'parent' => $value->parent,
                );
            }
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response, 128));
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    private function searchPermission()
    {
        $like   = array();
        $name   = $this->input->post('name');
        $parent = $this->input->post('parent');
        if ($name != '') {
            $like['LOWER(sp.name)'] = strtolower($name);
        }

        if ($parent != '') {
            $like['LOWER(sm2.name)'] = strtolower($parent);
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
        $this->tabs['create']['src'] = base_url('permission/input');

        if (!$this->auth->can('createPermission')) {
            unset($this->tabs['create']);
        }

        $this->data['title'] = 'Permission Apps';
        $this->data['body']  = $this->load->view('permission/index', $this->data, true);
        $this->setBreadcrumbs($this->breadcrumbs)
            ->setCss(
                array(
                    array('href' => base_url('assets/lib/jqgrid/css/ui.jqgrid-bootstrap.css'), 'rel' => 'stylesheet'),
                )
            )
            ->setJs(
                array(
                    array('src' => base_url('assets/lib/jqgrid/js/i18n/grid.locale-en.js')),
                    array('src' => base_url('assets/lib/jqgrid/js/jquery.jqGrid.min.js')),
                ), 'bottom'
            )
            ->render('viewPermission');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function input($id = false)
    {
        $permission = 'createPermission';
        $title      = 'New';
        $model      = new Permissionmodel;
        if ($id) {
            $permission = 'updatePermission';
            $title      = 'Update';
            $model      = $model->where(array('id_permission' => $id))->find()->row(0, 'Permissionmodel');
        }

        // collect user input if store in sessions
        if ($this->session->userdata('post')) {
            $post            = json_decode(json_encode($this->session->userdata('post')));
            $model->name     = $post->name;
            $model->modul_id = $post->modul_id;
            $this->session->unset_userdata('post'); // unset session
        }

        // tabs must define before load body
        $this->tabs['list']['src']     = base_url('permission');
        $this->tabs['create']['class'] = 'active';
        $this->tabs['create']['title'] = $title;
        $this->tabs['create']['src']   = '#';

        // content
        $this->data['model'] = $model;
        $this->data['title'] = $title . ' Permission';
        $this->data['body']  = $this->load->view('permission/input', $this->data, true);
        // content

        // breadcrumbs
        $this->breadcrumbs[2] = array('name' => $title, 'url' => '#', 'class' => '');
        $this->setBreadcrumbs($this->breadcrumbs)
            ->setJs(
                array(array('src' => base_url('assets/optimus/js/jquery.chosen.min.js'))),
                'bottom'
            )
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
        $output                    = array();
        $permission                = new Permissionmodel;
        $permission->id_permission = $this->input->post('id_permission');
        $permission->name          = $this->input->post('name', true);
        $permission->modul_id      = $this->input->post('modul_id');

        // validate
        $permission->validate();
        if (!$this->form_validation->run()) {
            $output['errors']['name'] = form_error('name');
            $this->session->set_flashdata('errors', $output['errors']);
            $this->session->set_userdata('post', $_POST);
            redirect(site_url('permission/input/' . $permission->id_permission));
        }

        $id_permission = $permission->save();
        if (!empty($id_permission)) {
            $this->session->set_flashdata('flash-delete', array('success' => 'Saved'));
            redirect(site_url('permission'));
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
        if (!$this->auth->can('deletePermission')) {
            $this->session->set_flashdata('flash-delete', array('error' => 'doesnt have permission for deletePermission'));
            redirect(site_url('permission'), 'refresh');
        }

        $id                        = $this->uri->segment(3);
        $permission                = new Permissionmodel;
        $permission->id_permission = $id;

        if ($permission->delete()) {
            $this->session->set_flashdata('flash-delete', array('success' => 'Deleted'));
            redirect(site_url('permission'));
        }
    }
} // END class
