<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}

	function update($data = array())
	{
		$data['main_modifydate'] = date('Y-m-d H:i:s');
		$data = get_array_prefix('main_', $data);
		$this->db->where('main_id', $data['main_id']);
		$thisResult = $this->db->update('main', $data);

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);
	}

	function delete($data = array())
	{
		$data['main_modifydate'] = date('Y-m-d H:i:s');
		$data['main_deleted'] = 1;
		$data = get_array_prefix('main_', $data);
		$this->db->where('main_id', $data['main_id']);
		$thisResult = $this->db->update('main', $data);

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);
	}

	function insert($data = array())
	{
		$data['main_createdate'] = date('Y-m-d H:i:s');
		$data['main_modifydate'] = date('Y-m-d H:i:s');
		$data['main_deleted'] = 0;
		$data = get_array_prefix('main_', $data);
		$thisResult = $this->db->insert('main', $data);
		$thisInsertId = $this->db->insert_id();

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);

		return($thisInsertId);
	}

	function select($data = array()){
		/* where */
		$where = "";
		if(isset($data['where'])){
			foreach($data['where'] as $key => $value){
				$thisField = '';
				switch($key){
					case 'main_id':
						$thisField = $key;
						$this->db->where($thisField, urldecode($value));
						break;
					case 'except_id':
						$thisField = "main_id >";
						$this->db->where($thisField, urldecode($value));
						break;
					case 'page':
						$data['offset'] = $value;
						break;
				}
			}
		}

		/* order */
		if(isset($data['order'])){
			$this->db->order_by($data['order'], $data['ascend']);
		}

		/* limit */
		if(isset($data['limit'])){
			$this->db->limit($data['limit']);
		}

		/* offset */
		if(isset($data['offset'])){
			if(isset($data['limit'])){
				$this->db->limit($data['limit'], $data['offset']);
			}
		}

		$this->db->where('main_deleted', 0);
		$this->db->from('main');
		$query = $this->db->get();
		// echo $this->db->last_query();

		/* return */
		if(isset($data['return'])){
			switch($data['return']){
				case 'num_rows':
					return $query->num_rows();
					break;
				default:
					return $query->result();
					break;
			}
		}
	}
 
 	function structure()
	{
		$query = $this->db->query("show full columns from main");
		return $query->result();
	}
}