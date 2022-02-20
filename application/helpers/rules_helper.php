<?php defined('BASEPATH') OR exit('No direct script access allowed');
// STATIC USER - DEVELOPMENT USE ONLY
if(!function_exists('_static_users')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _static_users()
	{
		$ci =& get_instance();
		$models = $ci->db->select('u.*')
					 ->from('helpdesk_user u')
					 ->get()
					 ->result();

		$users = array();
		if(sizeof($models)>0){
			foreach ($models as $key => $value) {
				$users[$value->sso_id]['name'] = $value->name;
				$users[$value->sso_id]['email'] = $value->email;
			}
		}
		return $users;
	}
}

if(!function_exists('_rules_user')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function __rules_user($where = array())
	{
		$ci =& get_instance();
		$ci->load->model('Usermodel');

		$where['p.status'] = 'active';
		if(!empty($ci->userlogin_id)) $where['u.sso_id'] = $ci->userlogin_id;

		$fields = '
					u.sso_id,
					u.name username,
					p.user_id,
					p.group_id,
					p.default_group,
					g.name groupname,
					g2.name default_groupname,
					r.created,
					r.closed,
					r.updated
				';
		$user = new Usermodel;
		$user->settable('helpdesk_user u');
		$models = $user->where($where)
					   ->with(
							array('helpdesk_pic p', 'p.user_id = u.id_user', 'inner'),
							array('helpdesk_groupuser g', 'g.id_groupuser = p.group_id', 'inner'),
							array('helpdesk_ticketrules r', 'r.group_id = g.id_groupuser', 'inner'),
							array('helpdesk_groupuser g2', 'g2.id_groupuser = p.default_group', 'left')
						)
					   ->find($fields)
					   ->result();

		// echo $ci->db->last_query();

		return $models;
	}
}

if(!function_exists('_default_creator')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _default_creator()
	{
		// NOTES: validasi creator ticket berdasarkan default_group atau group_id ???
		// **saat ini masih pakai group_id

		$default = array();
		$rules = __rules_user();
		if(sizeof($rules)>0){
			foreach ($rules as $key => $value) {
				if(!empty($value->default_group)){
					$default['group_id'] = $value->default_group;
					$default['group_name'] = $value->default_groupname;
				}
			}
		}

		return $default;
	}
}

if(!function_exists('_can_create')){
	/**
	 * check if user can create ticket
	 *
	 * @return void
	 * @author 
	 **/
	function _can_create()
	{
		$create = array();
		$rules = __rules_user();
		if(sizeof($rules)>0){
			foreach ($rules as $key => $value) {
				if(strtolower($value->created) === 'y') $create[] = $value->created;
			}
		}

		return in_array('Y', $create);
	}
}

if(!function_exists('_can_update')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _can_update()
	{
		$update = array();
		$rules = __rules_user();
		if(sizeof($rules)>0){
			foreach ($rules as $key => $value) {
				if(strtolower($value->updated) === 'y') $update[] = $value->updated;
			}
		}

		return in_array('Y', $update);
	}
}

if(!function_exists('_groups_pic')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _groups_pic()
	{
		$groups = array();
		$rules = __rules_user();
		if(sizeof($rules)>0){
			foreach ($rules as $key => $value) {
				if(strtolower($value->updated) === 'y'){
					$groups['action'][] = $value->updated;
					$groups['group_id'][] = $value->group_id;
					$groups['group_name'][] = $value->groupname;
				}
			}
		}

		return $groups;
	}
}

if(!function_exists('_listed_groupuser')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _listed_groupuser($id)
	{
		$groups = _groups_pic();
		return in_array($id, $groups['group_id']);
	}
}

if(!function_exists('_first_response')){
	/**
	 * undocumented function
	 *
	 * @return Boolean
	 * @author 
	 **/
	function _first_response($status)
	{
		return in_array($status, array('open')); 
	}
}

if(!function_exists('_diff_in_minutes')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _diff_in_minutes($first, $second)
	{
		$start = strtotime($first);
		$end = strtotime($second);
		return round(abs($start - $end)/ 60);
	}
}