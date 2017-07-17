<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_model{
	
	function __construct()
	{
		$this->load->database('default');
	}

	function update($data = array())
	{
		$data['banner_modifydate'] = date('Y-m-d H:i:s');
		$data = get_array_prefix('banner_', $data);
		$this->db->where('banner_id', $data['banner_id']);
		$thisResult = $this->db->update('banner', $data);

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);
	}

	function delete($data = array())
	{
		$data['banner_modifydate'] = date('Y-m-d H:i:s');
		$data['banner_deleted'] = 1;
		$data = get_array_prefix('banner_', $data);
		$this->db->where('banner_id', $data['banner_id']);
		$thisResult = $this->db->update('banner', $data);

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);
	}

	function insert($data = array())
	{
		$data['banner_createdate'] = date('Y-m-d H:i:s');
		$data['banner_modifydate'] = date('Y-m-d H:i:s');
		$data['banner_deleted'] = 0;
		$data = get_array_prefix('banner_', $data);
		$thisResult = $this->db->insert('banner', $data);
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
					case 'banner_id':
						$thisField = $key;
						$this->db->where($thisField, urldecode($value));
						break;
					case 'except_id':
						$thisField = "banner_id >";
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

		$this->db->where('banner_deleted', 0);
		$this->db->from('banner');
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
		$query = $this->db->query("show full columns from banner");
		return $query->result();
	}
}