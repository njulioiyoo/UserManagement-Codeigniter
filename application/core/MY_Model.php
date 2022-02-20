<?php defined('BASEPATH') OR exit('No direct script access allowed');
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
class MY_Model extends CI_Model
{
	protected $_tablename;
	protected $_pk;
	protected $relations;

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function status()
	{
		return array('active'=>'Active', 'inactive'=>'Not Active');
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function setpkey($pkey)
	{
		$this->_pk = $pkey;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function settable($table)
	{
		$this->_tablename = $table;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function order($field, $type = 'desc')
	{
		$this->db->order_by($field, $type);
		return $this;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function like($where)
	{
		$this->db->like($where);
		return $this;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function in($field, $params)
	{
		$this->db->where_in($field, $params);
		return $this;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function not_in($field, $params)
	{
		$this->db->where_not_in($field, $params);
		return $this;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function group($field)
	{
		$this->db->group_by($field);
		return $this;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function with($args)
	{
		$related = func_get_args($args);
		foreach ($related as $key => $with) {
			if(is_array($with)){
				list($table, $join, $type) = $with;
				$this->db->join($table, $join, $type);
			}
		}

		return $this;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function limit($limit = 10, $offset = 0)
	{
		$this->db->limit($limit, $offset);
		return $this;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function where($where)
	{
		$this->db->where($where);
		return $this;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function find($fields = '*')
	{
		$this->db->select($fields);
		return $this->db->get($this->_tablename);
	}

	/**
	 * undocumented function
	 * @param $log Boolean
	 * @return Int
	 * @author 
	 **/
	function save($insertlog = true)
	{
		$bind_tablename = $this->_tablename;
		$prevdata = $this->db->select('*')->where(array($this->_pk => $this->{$this->_pk}))->get($this->_tablename)->row();
		if($this->{$this->_pk} == '' || $this->{$this->_pk} == null){
			$this->db->insert($this->_tablename, $this->fields());
			$action = 'created';
			$_id = $this->db->insert_id();
		}else{
			$_id = $this->{$this->_pk};
			$action = 'updated';
			$this->db->where(array($this->_pk => $this->{$this->_pk}));
	        $this->db->update($this->_tablename, $this->fields());
		}
		
		// // save logs
		$log = array();
		$log['table_id'] = $_id;
		$log['table_name'] = $bind_tablename;
		$log['table_action'] = $action;
		$log['next'] = json_encode($this->fields());
		$log['prev'] = json_encode($prevdata);
		$log['created_by'] = $this->userlogin_id;
		$log['created_at'] = date('Y-m-d H:i:s');

		if($insertlog) $this->db->insert('siak_log', $log); // save log if $insertlog === true

		return $_id;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function delete($insertlog = true)
	{
		// bind previous data
		$prevdata = $this->db->where(array($this->_pk => $this->{$this->_pk}))->select('*')->get($this->_tablename)->row();

		$this->db->where(array($this->_pk => $this->{$this->_pk}));
		$this->db->delete($this->_tablename);

		if($this->db->affected_rows() === 1){

			if($insertlog){			
				// save logs
				$log = array();
				$log['table_id'] = $this->{$this->_pk};
				$log['table_name'] = $this->_tablename;
				$log['table_action'] = 'deleted';
				$log['prev'] = json_encode($prevdata);
				$log['next'] = json_encode(null);
				$log['created_by'] = $this->userlogin_id;
				$log['created_at'] = date('Y-m-d H:i:s');
				$this->db->insert('siak_log', $log);
			}

			return true;
		}

		return false;
	}

	/**
	 * array of field table function
	 * 
	 *
	 * @return array
	 * @author 
	 **/
	protected function fields()
	{
		$fields = array();
		
		unset($this->_pk);
		unset($this->_tablename);

		$rows = call_user_func('get_object_vars', $this);
		if(sizeof($rows)>0){
			foreach ($rows as $key => $value) {
				// enable zero (0) value
				if(is_numeric($value) || !empty($value)){
					$fields[$key] = $value;
				}
			}
		}

		return $fields;
	}

	// /**
	//  * undocumented function
	//  *
	//  * @return void
	//  * @author 
	//  **/
	// function __get($name)
	// {
	// 	$fields = $this->attributelabels();
	// 	if(isset($fields[$name])) return $name;
	// }
} // END class 