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
class Auth
{
    private $ci;
    private $userlogin_id;
    private $authlist = array();
    private $pagelist = array();
    private $errors   = array();

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function __construct()
    {
        $this->ci = &get_instance();
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function user($id)
    {

        $this->userlogin_id = $id;

        $where              = array();
        $where['u.id_user'] = $id;
        $this->ci->db->select('u.id_user, u.username, r.name rolename, p.name permission, m.url')
            ->from('siak_user u')
            ->join('siak_user_role ur', 'ur.user_id = u.id_user', 'INNER')
            ->join('siak_role r', 'r.id_role = ur.role_id', 'INNER')
            ->join('siak_role_permission rp', 'rp.role_id = r.id_role', 'INNER')
            ->join('siak_permission p', 'p.id_permission = rp.permission_id', 'INNER')
            ->join('siak_modul m', 'm.id_modul = p.modul_id', 'INNER')
            ->where($where)
            ->group_by('p.id_permission');

        $models = $this->ci->db->get()->result();

        $this->errors['user'] = 'Permission of User ID#' . $this->userlogin_id . ' was not found.';
        if (sizeof($models) > 0) {
            foreach ($models as $key => $value) {
                $this->authlist[$value->permission] = true;
                $this->pagelist[$value->url][]      = $value->permission;
            }
            $this->errors['user'] = 'Permission exists, try $this->auth->can($permission) to see available Permission.';
        }

        return $this;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function available()
    {
        $available = '';
        if (sizeof($this->authlist) > 0) {
            $i = 1;
            foreach ($this->authlist as $key => $value) {
                if (!empty($key)) {
                    $available .= $i . ').' . $key . "<br>";
                    $i++;
                }
            }
        }
        return $available;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function countpermission($uri)
    {
        return sizeof($this->pagelist[$uri]);
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function menu($uri)
    {
        return isset($this->pagelist[$uri]);
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function can($permission)
    {
        return isset($this->authlist[$permission]);
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function error($index = 'user')
    {
        return isset($this->errors[$index]) ? $this->errors[$index] : "undefined index";
    }
} // END class
