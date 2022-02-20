<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * ***************************************************************
 * Script : PHP
 * Version : Codeigniter 3.1.9
 * Author : Julio Notodiprodyo
 * Email : njulioiyoo@gmail.com
 * ***************************************************************
 */

class MysqlModel extends CI_Model
{
	protected $_tablename;
	protected $_pk;
	protected $_inserted_id;

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
	function whereSql($sql)
	{
		$this->db->where($sql, NULL, FALSE);
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
	function order($field, $type="desc")
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
	function find($fields = '*')
	{
		// save logs
		// if($this->db->last_query()){		
		// 	$log = array();
		// 	$log['table_id'] = 0;
		// 	$log['table_name'] = $this->_tablename;
		// 	$log['table_action'] = 'select';
		// 	$log['content'] = json_encode($this->db->last_query());
		// 	$log['created_by'] = $this->userlogin_id;
		// 	$log['created_at'] = date('Y-m-d H:i:s');
		// 	$this->db->insert('helpdesk_log', $log);
		// }

		$this->db->select($fields);
		$this->db->from($this->_tablename);
		
		return $this->db->get();
	}

	/**
	 * undocumented function
	 * @param $log Boolean
	 * @return void
	 * @author 
	 **/
	function save($insertlog = true)
	{
		$prev = $this->db->select('*')->where(array($this->_pk => $this->{$this->_pk}))->get($this->_tablename)->row();

		if($this->{$this->_pk} == '' || $this->{$this->_pk} == null){
			$this->db->insert($this->_tablename, $this->fields());
			$this->_inserted_id = $this->db->insert_id();
			$_id = $this->_inserted_id;
			$action = 'insert';
		}else{
			$_id = $this->{$this->_pk};
			$action = 'update';
			$this->db->where(array($this->_pk => $this->{$this->_pk}));
	        $this->db->update($this->_tablename, $this->fields());
		}
		
		// save logs
		$log = array();
		$log['table_id'] = $_id;
		$log['table_name'] = $this->_tablename;
		$log['table_action'] = $action;
		$log['next'] = json_encode($this->fields());
		$log['prev'] = json_encode($prev);
		$log['created_by'] = $this->userlogin_id;
		$log['created_at'] = date('Y-m-d H:i:s');

		if($insertlog) $this->db->insert('helpdesk_log', $log); // save log if $insertlog === true

		return $_id;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function delete()
	{
		// bind previous data
		$prevdata = $this->db->where(array($this->_pk => $this->{$this->_pk}))->select('*')->get($this->_tablename)->row();

		$this->db->where(array($this->_pk => $this->{$this->_pk}));
		$this->db->delete($this->_tablename);

		if($this->db->affected_rows() === 1){
			// save logs
			$log = array();
			$log['table_id'] = $this->{$this->_pk};
			$log['table_name'] = $this->_tablename;
			$log['table_action'] = 'delete';
			$log['prev'] = json_encode($prevdata);
			$log['next'] = null;
			$log['created_by'] = $this->userlogin_id;
			$log['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('helpdesk_log', $log);

			return true;
		}

		return false;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function getFields()
	{
		return $this->fields();
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
		$rows = call_user_func('get_object_vars', $this);
		if(sizeof($rows)>0){
			foreach ($rows as $key => $value) {
				// enable zero (0) value
				if(is_numeric($value) || !empty($value)){
				// if(is_numeric($value) || $value !== null){
					$fields[$key] = $value;
				}
			}
		}

		return $fields;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function printMysqlQueries()
	{
		$this->db->reset_query();
		return $this->db->queries;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function printLastQuery()
	{
		return $this->db->last_query();
	}
}