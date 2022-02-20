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
class Groupuser extends AdminController
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

        $this->load->model('Groupusermodel');

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
        $this->breadcrumbs[1] = array('name' => 'Group User List');
        // breadcrumbs

        $this->data['title'] = 'Page - Group User';
        $this->data['body']  = $this->load->view('groupuser/index', $this->data, true);
        $this->setBreadcrumbs($this->breadcrumbs)
            ->setCss(
                array(
                    array('href' => base_url('assets/lib/jqgrid/css/ui.jqgrid-bootstrap.css'), 'rel' => 'stylesheet'),
                    // array('href'=>base_url('assets/lib/jqgrid/css/ui.jqgrid-bootstrap-ui.css'), 'rel'=>'stylesheet'),
                )
            )
            ->setJs(
                array(
                    array('src' => base_url('assets/lib/jqgrid/js/i18n/grid.locale-en.js')),
                    array('src' => base_url('assets/lib/jqgrid/js/jquery.jqGrid.min.js')),
                ), 'bottom'
            )
            ->render();

    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function input($id = false)
    {
        $model = new Groupusermodel;
        $title = "Input";

        if ($id) {
            $title = "Update";
            $model = $model->where(array('id_groupuser' => $id))->find()->row();
        }

        // breadcrumbs
        $this->breadcrumbs[1] = array('name' => 'Group User List', 'url' => base_url('groupuser'), 'class' => 'active');
        $this->breadcrumbs[2] = array('name' => $title);
        // breadcrumbs

        $this->data['model']  = $model;
        $this->data['title']  = $title;
        $this->data['status'] = $this->statusactive();

        if ($this->input->is_ajax_request()) {
            die($this->load->view('groupuser/_form', $this->data, true));
        }

        $this->data['body'] = $this->load->view('groupuser/input', $this->data, true);
        $this->setBreadcrumbs($this->breadcrumbs)
            ->setCss(
                array(
                    array('href' => base_url('assets/lib/select2/css/select2.min.css'), 'rel' => 'stylesheet'),
                    array('href' => base_url('assets/lib/select2/css/select2-bootstrap.min.css'), 'rel' => 'stylesheet'),
                )
            )
            ->setJs(
                array(array('src' => base_url('assets/lib/select2/js/select2.full.js')))
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
        $group               = new Groupusermodel;
        $group->id_groupuser = $this->input->post('id_groupuser');
        $group->name         = $this->input->post('name');
        $group->remarks      = $this->input->post('remarks');
        $group->status       = $this->input->post('status');
        $group->updated_at   = $this->createdTime();
        $group->updated_by   = $this->userlogin_id;

        if ($group->id_group == '') {
            $group->created_at = $this->createdTime();
            $group->created_by = $this->userlogin_id;
        }

        $group->save();

        redirect(site_url("groupuser"));

    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function delete()
    {
        $id                  = $this->uri->segment(3);
        $group               = new Groupusermodel;
        $group->id_groupuser = $id;
        $group->delete();

        redirect(site_url("groupuser"));
    }
} // END class
