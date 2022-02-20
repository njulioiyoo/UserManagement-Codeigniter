<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('_activelable')){
	/**
	 * undocumented function
	 *
	 * @return String
	 * @author 
	 **/
	function _activelable($status)
	{
		switch (strtolower($status)) {
			case 'active':
				$lbl = '<label class="label label-success"><i class="fa fa-open"></i> Active</label>';
				break;
			
			default:
				$lbl = '<label class="label label-danger"><i class="fa fa-lock"></i> In Active</label>';
				break;
		}

		return $lbl;
	}
}

if(!function_exists('_status_activelist')){
	/**
	 * undocumented function
	 *
	 * @return Array
	 * @author 
	 **/
	function _status_activelist()
	{
		return array(
			'active'=>'Active',
			'inactive'=>'In Active',
		);
	}
}

if(!function_exists('_status_ticket')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _status_ticket()
	{
		return array(
			'cancelled' => 'CANCELLED',
			'close' => 'CLOSE',
			'hold' => 'HOLD',
			'monitoring' => 'MONITORING',
			'open' => 'OPEN',
			'resolve' => 'RESOLVE',
			'progress' => 'ON PROGRESS',
		);
	}
}

if(!function_exists('_status_ticket_label')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _status_ticket_label($status)
	{
		switch (strtolower($status)) {
			case 'cancelled':
				$lbl = '<label class="label label-success"><i class="fa fa-lock"></i> CANCELLED</label>';
				break;

			case 'close':
				$lbl = '<label class="label label-success"><i class="fa fa-lock"></i> CLOSE</label>';
				break;

			case 'hold':
				$lbl = '<label class="label label-info"><i class="fa fa-pause"></i> HOLD</label>';
				break;

			case 'monitoring':
				$lbl = '<label class="label label-info"><i class="fa fa-eye"></i> MONITORING</label>';
				break;

			case 'open':
				$lbl = '<label class="label label-danger"><i class="fa fa-unlock"></i> OPEN</label>';
				break;
			
			case 'progress':
				$lbl = '<label class="label label-info"><i class="fa fa-spinner fa-spin"></i> ON PROGRESS</label>';
				break;
			
			default:
				$lbl = '<label class="label label-warning"><i class="fa fa-reload"></i> RESOLVE</label>';
				break;
		}

		return $lbl;
	}
}

if(!function_exists('_get_detail_status_from_log')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _get_detail_status_from_log($idlog)
	{
		$where = array();
		$where['l.id_log'] = $idlog;
		$ci =& get_instance();
		$model = $ci->db->select('l.created_at, i.*')
					->from('helpdesk_log l')
					->join('helpdesk_ticket_interupted i', 'i.created_at = l.created_at', 'inner')
					->where($where)
					->get()
					->row();

		return $model;
	}
}