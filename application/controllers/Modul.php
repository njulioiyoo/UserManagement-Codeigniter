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
class Modul extends AdminController
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
        $this->load->model('Modulmodel');
        // breadcrumbs
        $this->breadcrumbs[1] = array('name' => 'Modul', 'url' => base_url('modul/index'), 'class' => '');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function tablemodul()
    {
        if (!$this->input->is_ajax_request()) {
            show_error('undefined request', 500, 'wrong method');
        }

        $sidx = $this->input->post('sidx');
        $sord = $this->input->post('sord');

        $offset = $this->input->post('page');
        $limit  = $this->input->post('rows');

        // individual search
        $like = $this->searchModul();

        $fields = 'sm.*, sm2.name parent';
        $modul  = new Modulmodel;
        $modul->settable('siak_modul sm');
        $modul->with(
            array('siak_modul sm2', 'sm2.id_modul = sm.parent_id', 'LEFT')
        );

        // prev data
        if (sizeof($like) > 0) {
            $modul->like($like);
        }

        $prev = $modul->find($fields)->result();
        // prev data

        $response            = array();
        $response['records'] = sizeof($prev);
        $response['total']   = ceil($response['records'] / $limit);

        $params          = array();
        $params['start'] = ($offset * $limit) - $limit;
        $params['limit'] = $limit;

        // next data
        $modul->settable('siak_modul sm');
        $modul->with(
            array('siak_modul sm2', 'sm2.id_modul = sm.parent_id', 'LEFT')
        );
        $modul->order($sidx, $sord);
        if (sizeof($like) > 0) {
            $modul->like($like);
        }

        $next = $modul->limit($params['limit'], $params['start'])->find($fields)->result();
        // next data

        if (sizeof($next) > 0) {
            foreach ($next as $key => $value) {
                $edit   = '<a href="' . base_url("modul/input/" . $value->id_modul) . '" class="btn btn-small btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                $delete = '<button data-delete="' . base_url("modul/delete/" . $value->id_modul) . '" data-name="' . $value->name . '" class="btn btn-small btn-danger" onclick="deleterow(this)"><i class="fa fa-trash"></i> Delete</button>';

                if (!$this->auth->can('updateModul')) {
                    $edit = '';
                }

                if (!$this->auth->can('deleteModul')) {
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
    private function searchModul()
    {
        $like   = array();
        $name   = $this->input->post('name');
        $parent = $this->input->post('parent');
        if ($name != '') {
            $like['LOWER(sm.name)'] = strtolower($name);
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
        $this->tabs['create']['src'] = base_url('modul/input');

        if (!$this->auth->can('createModul')) {
            unset($this->tabs['create']);
        }

        $this->data['title'] = 'Role Apps';
        $this->data['body']  = $this->load->view('modul/index', $this->data, true);

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
            ->render('viewModul');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function input($id = false)
    {
        $permission = 'createModul';
        $title      = 'New';
        $model      = new Modulmodel;
        if ($id) {

            $permission = 'updateModul';

            $title = 'Update';
            $model = $model->where(array('id_modul' => $id))->find()->row(0, 'Modulmodel');
        }

        // collect user input if store in sessions
        if ($this->session->userdata('post')) {
            $post        = json_decode(json_encode($this->session->userdata('post')));
            $model->name = $post->name;
            $model->url  = $post->url;
            $model->icon = $post->icon;
            $this->session->unset_userdata('post'); // unset session
        }

        // tabs must define before load body
        $this->tabs['list']['src']     = base_url('modul');
        $this->tabs['create']['class'] = 'active';
        $this->tabs['create']['title'] = $title;
        $this->tabs['create']['src']   = '#';

        // content
        $this->data['model'] = $model;
        $this->data['title'] = $title . ' Role';
        $this->data['body']  = $this->load->view('modul/input', $this->data, true);
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
        $output           = array();
        $modul            = new Modulmodel;
        $modul->id_modul  = $this->input->post('id_modul');
        $modul->name      = $this->input->post('name', true);
        $modul->url       = $this->input->post('url');
        $modul->icon      = $this->input->post('icon');
        $modul->parent_id = $this->input->post('parent_id');

        // validate form submit
        $modul->validate();
        if (!$this->form_validation->run()) {
            $output['errors']['name'] = form_error('name');
            $output['errors']['url']  = form_error('url');

            $this->session->set_flashdata('errors', $output['errors']);
            $this->session->set_userdata('post', $_POST);
            redirect(site_url('modul/input/' . $modul->id_modul));
        }

        $id_modul = $modul->save();
        if (!empty($id_modul)) {
            $this->session->set_flashdata('flash-delete', array('success' => 'Saved'));
            redirect(site_url('modul'));
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
        if (!$this->auth->can('deleteModul')) {
            $this->session->set_flashdata('flash-delete', array('error' => 'doesnt have permission for deleteModul'));
            redirect(site_url('modul'), 'refresh');
        }

        $id              = $this->uri->segment(3);
        $modul           = new Modulmodel;
        $modul->id_modul = $id;

        if ($modul->delete()) {
            $this->session->set_flashdata('flash-delete', array('success' => 'Delete'));
            redirect(site_url('modul'));
        }
    }
} // END class
