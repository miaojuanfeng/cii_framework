<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ai_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}

	function update($data = array())
	{
		$data['ai_prefix'] = ucfirst(substr($data['ai_name'], 0, 1));
		$data['ai_modifydate'] = date('Y-m-d H:i:s');
		$data = get_array_prefix('ai_', $data);
		$this->db->where('ai_id', $data['ai_id']);
		$thisResult = $this->db->update('ai', $data);

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);
	}

	function delete($data = array())
	{
		$data['ai_modifydate'] = date('Y-m-d H:i:s');
		$data['ai_deleted'] = 1;
		$data = get_array_prefix('ai_', $data);
		$this->db->where('ai_id', $data['ai_id']);
		$thisResult = $this->db->update('ai', $data);

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);
	}

	function insert($data = array())
	{
		$data['ai_createdate'] = date('Y-m-d H:i:s');
		$data['ai_modifydate'] = date('Y-m-d H:i:s');
		$data['ai_deleted'] = 0;
		$data = get_array_prefix('ai_', $data);
		$thisResult = $this->db->insert('ai', $data);
		$thisInsertId = $this->db->insert_id();

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);

		return($thisInsertId);
	}

	function select($data = array())
	{
		/* where */
		if(isset($data['where'])){
			foreach($data['where'] as $key => $value){
				$thisField = '';
				switch($key){
					case 'ai_id':
					case 'ai_type':
					case 'ai_prefix':
						$thisField = $key;
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

		$this->db->where('ai_deleted', 0);
		$this->db->where('ai_country', $this->session->userdata('country_id'));
		$this->db->from('ai');
		$query = $this->db->get();
		// echo $this->db->last_query();
		// exit;

		/* return */
		if(isset($data['return'])){
			switch($data['return']){
				case 'num_rows':
					return $query->num_rows();
					break;
				case 'row_array':
					return $query->row_array();
					break;
				default:
					return $query->result();
					break;
			}
		}
	}

	function structure()
	{
		$query = $this->db->query("show full columns from ai");
		return $query->result();
	}
 
}