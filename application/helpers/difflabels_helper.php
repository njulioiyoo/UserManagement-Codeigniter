<?php defined('BASEPATH') OR exit('No direct script access allowed');
if(!function_exists('__ticketnotes_formlabels')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function __ticketnotes_formlabels()
	{
		return array(
			'notes'=>'Notes'
		);
	}
}
if(!function_exists('_ticketnotes_formvalue')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _ticketnotes_formvalue($label, $value)
	{
		switch ($label) {
			case 'notes':
				$text = $value;
				break;
			
			default:
				$text = null;
				break;
		}

		return $text;
	}
}

if(!function_exists('__ticket_formlabels')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function __ticket_formlabels()
	{
		return array(
			'status'=>'Status',
			'priority'=>'Priority',
			'mode'=>'Mode',
			'level'=>'Level',
			'group_id'=>'Group',
			'pic_id'=>'Technician',
			'category'=>'Category',
			'subcategory'=>'Sub Category',
			'item'=>'Item',
			'cause_group'=>'Cause Group',
			'cause_code'=>'Cause Code',
			'subject'=>'Subject',
			'description'=>'Description',
		);
	}
}

if(!function_exists('_historyticketnoted_fielddiff')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _historyticketnoted_fielddiff(Array $first, Array $second)
	{
		$labels = __ticketnotes_formlabels();
		$result = array();
		
		if(sizeof($second)>0 && sizeof($first)<=0){
			foreach ($second as $key => $value) {
				if(isset($labels[$key])){
					$result[$labels[$key]] = _ticketnotes_formvalue($key, $value);
				}
			}
		}

		if(sizeof($second)>0 && sizeof($first)>0){
			$diff = array_diff($second, $first);
			if(sizeof($diff)>0){
				foreach ($diff as $key => $value) {
					if(isset($labels[$key])){
						$result[$labels[$key]] = _ticketnotes_formvalue($key, $value);
					}
				}
			}
		}

		return $result;
	}
}

if(!function_exists('_ticket_formvalue')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _ticket_formvalue($label, $value)
	{
		switch (strtolower($label)) {
			// dropdownlist
			case 'priority':
			case 'mode':
			case 'level':
			case 'category':
			case 'subcategory':
			case 'item':
			case 'cause_group':
			case 'cause_code':
				$text = getTableFieldName('helpdesk_dropdown', array('id_dropdown'=>$value), 'name');
				break;
			
			case 'group_id':
				$text = getTableFieldName('helpdesk_groupuser', array('id_groupuser'=>$value), 'name');
				break;

			case 'pic_id':
				$text = _get_picname($value);
				break;

			case 'status':
				$text = _status_ticket_label($value);
				break;

			case 'subject':
			case 'description':
				$text = nl2br($value);
				break;

			default:
				$text = '';
				break;
		}

		return $text;
	}
}

if(!function_exists('_historyticket_fielddiff')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _historyticket_fielddiff(Array $first, Array $second)
	{
		$labels = __ticket_formlabels();
		$result = array();
		
		if(sizeof($second)>0 && sizeof($first)<=0){
			foreach ($second as $key => $value) {
				if(isset($labels[$key])){
					$result[$labels[$key]] = _ticket_formvalue($key, $value);
				}
			}
		}

		if(sizeof($second)>0 && sizeof($first)>0){
			$diff = array_diff($second, $first);
			if(sizeof($diff)>0){
				foreach ($diff as $key => $value) {
					if(isset($labels[$key])){
						$result[$labels[$key]] = _ticket_formvalue($key, $value);
					}
				}
			}
		}

		return $result;
	}
}

if(!function_exists('getTableFieldName')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function getTableFieldName($tablename, $where, $field)
	{
		$result = __freequery($tablename, $where, $field);
		if(!empty($result)) return $result->{$field};
		return null;
	}
}

if(!function_exists('_get_picname')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _get_picname($id)
	{
		$ci =& get_instance();
		$model = $ci->db->select('p.*, u.name username')
					->from('helpdesk_pic p')
					->join('helpdesk_user u', 'u.id_user = p.user_id', 'inner')
					->where(array('p.id_pic'=>$id))
					->get()
					->row();

		if(!empty($model)) return $model->username;
		
		return null;
	}
}

if(!function_exists('__freequery')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function __freequery($tablename, $where = array(), $field = '*')
	{		
		$ci =& get_instance();
		$result = $ci->db->select($field)
					 ->from($tablename)
					 ->where($where)
					 ->get()
					 ->row();
		return $result;
	}
}