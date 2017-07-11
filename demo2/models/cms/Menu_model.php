<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}

	function update($data = array())
	{
		$data['menu_modifydate'] = date('Y-m-d H:i:s');
		$data = get_array_prefix('menu_', $data);
		$this->db->where('menu_id', $data['menu_id']);
		$thisResult = $this->db->update('menu', $data);

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);
	}

	function delete($data = array())
	{
		$data['menu_modifydate'] = date('Y-m-d H:i:s');
		$data['menu_deleted'] = 1;
		$data = get_array_prefix('menu_', $data);
		$this->db->where('menu_id', $data['menu_id']);
		$thisResult = $this->db->update('menu', $data);

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);
	}

	function insert($data = array())
	{
		$data['menu_createdate'] = date('Y-m-d H:i:s');
		$data['menu_modifydate'] = date('Y-m-d H:i:s');
		$data['menu_deleted'] = 0;
		$data = get_array_prefix('menu_', $data);
		$thisResult = $this->db->insert('menu', $data);
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
					case 'menu_id':
					case 'menu_name':
					case 'menu_hide':
						$thisField = $key;
						$this->db->where($thisField, urldecode($value));
						break;
					case 'menu_parent':
						$thisField = $key;
						$this->db->where('menu_parent', urldecode($value));
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

		$this->db->where('menu_deleted', 0);
		$this->db->where('menu_country', $this->session->userdata('country_id'));
		$this->db->from('menu');
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
		$query = $this->db->query("show full columns from menu");
		return $query->result();
	}
 
}