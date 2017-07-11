<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogues_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}

	function update($data = array())
	{
		$data['catalogues_modifydate'] = date('Y-m-d H:i:s');
		$data = get_array_prefix('catalogues_', $data);
		$this->db->where('catalogues_id', $data['catalogues_id']);
		$thisResult = $this->db->update('catalogues', $data);

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);
	}

	function delete($data = array())
	{
		$data['catalogues_modifydate'] = date('Y-m-d H:i:s');
		$data['catalogues_deleted'] = 1;
		$data = get_array_prefix('catalogues_', $data);
		$this->db->where('catalogues_id', $data['catalogues_id']);
		$thisResult = $this->db->update('catalogues', $data);

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);
	}

	function insert($data = array())
	{
		$data['catalogues_createdate'] = date('Y-m-d H:i:s');
		$data['catalogues_modifydate'] = date('Y-m-d H:i:s');
		$data['catalogues_deleted'] = 0;
		$data = get_array_prefix('catalogues_', $data);
		$thisResult = $this->db->insert('catalogues', $data);
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
					case 'catalogues_id':
					case 'catalogues_name':
						$thisField = $key;
						$this->db->where($thisField, urldecode($value));
						break;
					case 'catalogues_id_like':
					case 'catalogues_name_like':
						$thisField = str_replace('_like', '', $key);
						$this->db->like($thisField, urldecode($value));
						break;
					case 'catalogues_id_noteq':
					case 'catalogues_name_noteq':
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

		$this->db->where('catalogues_deleted', 0);
		$this->db->where('catalogues_country', $this->session->userdata('country_id'));
		$this->db->from('catalogues');

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
		$query = $this->db->query("show full columns from catalogues");
		return $query->result();
	}
 
}