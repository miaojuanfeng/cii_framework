<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model {
	
	function __construct()
	{
		$this->load->database('default');
	}

	function update($data = array())
	{
		$data['page_modifydate'] = date('Y-m-d H:i:s');
		$data = get_array_prefix('page_', $data);
		$this->db->where('page_id', $data['page_id']);
		$thisResult = $this->db->update('page', $data);

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);
	}

	function delete($data = array())
	{
		$data['page_modifydate'] = date('Y-m-d H:i:s');
		$data['page_deleted'] = 1;
		$data = get_array_prefix('page_', $data);
		$this->db->where('page_id', $data['page_id']);
		$thisResult = $this->db->update('page', $data);

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);
	}

	function insert($data = array())
	{
		$data['page_createdate'] = date('Y-m-d H:i:s');
		$data['page_modifydate'] = date('Y-m-d H:i:s');
		$data['page_deleted'] = 0;
		$data = get_array_prefix('page_', $data);
		$thisResult = $this->db->insert('page', $data);
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
					case 'page_id':
					case 'page_title':
						$thisField = $key;
						$this->db->where($thisField, urldecode($value));
						break;
					case 'order':
						$data['order'] = $value;
						break;
					case 'ascend':
						$data['ascend'] = $value;
						break;
					case 'limit':
						$data['limit'] = $value;
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

		// $this->db->where('page_deleted', 0);
		$this->db->from('page');
		$this->db->where('page_deleted', 0);
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
		$query = $this->db->query("show full columns from page");
		return $query->result();
	}
}