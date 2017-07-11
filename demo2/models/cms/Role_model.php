<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}

	function update($data = array())
	{
		$data['role_modify'] = date('Y-m-d H:i:s');
		$data = get_array_prefix('role_', $data);
		$this->db->where('role_id', $data['role_id']);
		$thisResult = $this->db->update('role', $data); 

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);
	}

	function delete($data = array())
	{
		$data['role_modify'] = date('Y-m-d H:i:s');
		$data['role_deleted'] = 'Y';
		$data = get_array_prefix('role_', $data);
		$this->db->where('role_id', $data['role_id']);
		$thisResult = $this->db->update('role', $data);

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);
	}

	function insert($data = array())
	{
		$data['role_create'] = date('Y-m-d H:i:s');
		$data['role_modify'] = date('Y-m-d H:i:s');
		$data['role_deleted'] = 'N';
		$data = get_array_prefix('role_', $data);
		$thisResult = $this->db->insert('role', $data);
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
					case 'role_id':
					case 'role_name':
						$thisField = $key;
						$this->db->where($thisField, urldecode($value));
						break;
					case 'role_id_like':
					case 'role_name_like':
						$thisField = str_replace('_like', '', $key);
						$this->db->like($thisField, urldecode($value));
						break;
					case 'role_id_noteq':
					case 'role_name_noteq':
						$thisField = str_replace('_noteq', '', $key);
						$this->db->where($thisField.' !=', urldecode($value));
						break;
					case 'order':
						$data['order'] = $value;
						break;
					case 'ascend':
						$data['ascend'] = $value;
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

		$this->db->where('role_deleted', 'N');
		$this->db->from('role');
		$query = $this->db->get();
		// echo $this->db->last_query();
		// exit;

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
		$query = $this->db->query("show full columns from role");
		return $query->result();
	}
 
}