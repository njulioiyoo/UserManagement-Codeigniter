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
class Rolepermission extends AdminController
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
        $this->load->model('Rolepermissionmodel');
        $this->load->model('Rolemodel');
        $this->load->model('Modulmodel');

        unset($this->tabs['create']);

        $this->breadcrumbs[1] = array('name' => 'Role Permission', 'url' => base_url('rolepermission/index'), 'class' => '');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function tablerolepermission()
    {
        if (!$this->input->is_ajax_request()) {
            show_error('undefined request', 500, 'wrong method');
        }

        $sidx = $this->input->post('sidx');
        $sord = $this->input->post('sord');

        $offset = $this->input->post('page');
        $limit  = $this->input->post('rows');

        // individual search
        $like = $this->searchRolePermission();

        $fields     = 'r.*, COUNT(rp.permission_id) total';
        $permission = new Rolemodel;
        $permission->settable('siak_role r');
        $permission->with(
            array('siak_role_permission rp', 'rp.role_id = r.id_role', 'LEFT')
        );

        // prev data
        if (sizeof($like) > 0) {
            $permission->like($like);
        }

        $prev = $permission->group('r.id_role')->find($fields)->result();
        // prev data

        $response            = array();
        $response['records'] = sizeof($prev);
        $response['total']   = ceil($response['records'] / $limit);

        $params          = array();
        $params['start'] = ($offset * $limit) - $limit;
        $params['limit'] = $limit;

        // next data
        $permission->settable('siak_role r');
        $permission->with(
            array('siak_role_permission rp', 'rp.role_id = r.id_role', 'LEFT')
        );
        $permission->order($sidx, $sord);
        if (sizeof($like) > 0) {
            $permission->like($like);
        }

        $next = $permission->group('r.id_role')->limit($params['limit'], $params['start'])->find($fields)->result();
        // next data

        if (sizeof($next) > 0) {
            foreach ($next as $key => $value) {
                $edit   = '<a href="' . base_url("rolepermission/input/" . $value->id_role) . '" class="btn btn-small btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                $delete = '<button data-delete="' . base_url("rolepermission/delete/" . $value->id_role) . '" data-name="' . $value->name . '" class="btn btn-small btn-danger" onclick="deleterow(this)"><i class="fa fa-trash"></i> Delete</button>';

                if (!$this->auth->can('updateRolePermission')) {
                    $edit = '';
                }

                if (!$this->auth->can('deleteRolePermission')) {
                    $delete = '';
                }

                $response['rows'][] = array(
                    'act'   => $edit . "&nbsp;" . $delete,
                    'name'  => $value->name,
                    'total' => $value->total,
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
    private function searchRolePermission()
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
        // $this->tabs['create']['src'] = base_url('rolepermission/input');

        $this->data['title'] = 'Role Permission Apps';
        $this->data['body']  = $this->load->view('rolepermission/index', $this->data, true);
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
            ->render('viewRolePermission');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function input($role_id = false)
    {
        $title = 'Update';

        $_rp            = array();
        $rolepermission = (new Rolepermissionmodel)->where(array('role_id' => $role_id))->find()->result();
        if (sizeof($rolepermission) > 0) {
            foreach ($rolepermission as $key => $value) {
                $_rp[$value->permission_id] = $value->id_rolepermission;
            }
        }

        $fields = 'm.id_modul, m.name modulname, m.url, p.id_permission, p.name permissionname';
        $modul  = new Modulmodel;
        $modul->settable('siak_modul m');
        $modul->with(
            array('siak_permission p', 'p.modul_id = m.id_modul', 'INNER')
        );
        $moduls = $modul->find($fields)->result();

        $_moduls = array('modulname' => null, 'permissionlist' => null);
        if (sizeof($moduls) > 0) {
            foreach ($moduls as $key => $value) {

                $_moduls['modulname'][$value->url]        = $value->modulname;
                $_moduls['permissionlist'][$value->url][] = array(
                    'permission_id'  => $value->id_permission,
                    'permissionname' => $value->permissionname,
                );

                if (isset($_rp[$value->id_permission])) {
                    $_rp[$value->url] = true;
                }

            }
        }

        // tabs must define before load body
        $this->tabs['list']['src']     = base_url('rolepermission');
        $this->tabs['create']['class'] = 'active';
        $this->tabs['create']['title'] = $title;
        $this->tabs['create']['src']   = '#';

        // content
        $this->data['rolepermission'] = $_rp;
        $this->data['role_id']        = $role_id;
        $this->data['moduls']         = $_moduls;
        $this->data['title']          = $title . ' Role Permission';
        $this->data['body']           = $this->load->view('rolepermission/input', $this->data, true);
        // content

        // breadcrumbs
        $this->breadcrumbs[2] = array('name' => $title, 'url' => '#', 'class' => '');
        $this->setBreadcrumbs($this->breadcrumbs)
            ->setJs(
                array(array('src' => base_url('assets/optimus/js/jquery.chosen.min.js'))),
                'bottom'
            )
            ->render('updateRolePermission');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function save()
    {
        $id_role           = $this->input->post('id_role');
        $id_rolepermission = $this->input->post('id_rolepermission'); // array
        $permissions       = $this->input->post('permission_id'); // array

        $old = (new Rolepermissionmodel)->where(array('role_id' => $id_role))->find()->result();

        if (sizeof($id_rolepermission) > 0) {
            foreach ($id_rolepermission as $key => $id) {
                if (sizeof($old) > 0) {
                    foreach ($old as $index => $data) {
                        if ($id === $data->id_rolepermission) {
                            unset($old[$index]);
                        }
                    }
                }
                $rp                    = new Rolepermissionmodel;
                $rp->id_rolepermission = $id;
                $rp->permission_id     = $permissions[$key];
                $rp->role_id           = $id_role;
                $rp->save();
            }
        }

        if (sizeof($old) > 0) {
            foreach ($old as $key => $value) {
                $rp                    = new Rolepermissionmodel;
                $rp->id_rolepermission = $value->id_rolepermission;
                $rp->delete();
            }
        }

        $this->session->set_flashdata('flash-delete', array('success' => 'Saved'));
        redirect(site_url('rolepermission'));
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function delete()
    {
        if (!$this->auth->can('deleteRolePermission')) {
            $this->session->set_flashdata('flash-delete', array('error' => 'doesnt have permission for deleteRolePermission'));
            redirect(site_url('rolepermission'), 'refresh');
        }

        $id = $this->uri->segment(3);
        $rp = new Rolepermissionmodel;
        $rp->setpkey('role_id');
        $rp->role_id = $id;

        if ($rp->delete()) {
            $this->session->set_flashdata('flash-delete', array('success' => 'Deleted'));
            redirect(site_url('rolepermission'));
        }
    }
} // END class
