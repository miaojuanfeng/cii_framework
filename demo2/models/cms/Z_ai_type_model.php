<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Z_ai_type_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}

	function update($data = array())
	{
		// do update here.
	}

	function delete($data = array())
	{
		switch(true){
			case (isset($data['type_id'])):
				$thisData['z_ai_type_type_id'] = $data['type_id'];
				$data = get_array_prefix('z_ai_type_', $data);
				break;
			case (isset($data['ai_id'])):
				$thisData['z_ai_type_ai_id'] = $data['ai_id'];
				$data = get_array_prefix('z_ai_type_', $data);
				break;
		}
		$this->db->where($thisData);
		$thisResult = $this->db->delete('z_ai_type');

		$log_SQL = $this->session->userdata('log_SQL');
		$log_SQL[] = array(
			'result' => $thisResult,
			'sql' => $this->db->last_query()
		);
		$this->session->set_userdata('log_SQL', $log_SQL);
	}

	function insert($data = array())
	{
		switch(true){
			case (isset($data['type_id'])):
				$thisData['z_ai_type_type_id'] = $data['type_id'];
				$data = get_array_prefix('z_ai_type_', $data);
				foreach($data as $key => $value){
					foreach($value as $key1 => $value1){
						$thisData['z_ai_type_ai_id'] = $value1;
						$thisResult = $this->db->insert('z_ai_type', $thisData);

						$log_SQL = $this->session->userdata('log_SQL');
						$log_SQL[] = array(
							'result' => $thisResult,
							'sql' => $this->db->last_query()
						);
						$this->session->set_userdata('log_SQL', $log_SQL);
					}
				}
				break;
			case (isset($data['ai_id'])):
				$thisData['z_ai_type_ai_id'] = $data['ai_id'];
				$data = get_array_prefix('z_ai_type_', $data);
				foreach($data as $key => $value){
					foreach($value as $key1 => $value1){
						$thisData['z_ai_type_type_id'] = $value1;
						$thisResult = $this->db->insert('z_ai_type', $thisData);

						$log_SQL = $this->session->userdata('log_SQL');
						$log_SQL[] = array(
							'result' => $thisResult,
							'sql' => $this->db->last_query()
						);
						$this->session->set_userdata('log_SQL', $log_SQL);
					}
				}
				break;
		}
	}

	function select($data = array())
	{
		/* where */
		$where = "";
		if(isset($data['where'])){
			foreach($data['where'] as $key => $value){
				switch($key){
					case 'type_id':
					case 'ai_id':
						$where .= " and ".'z_ai_type_'.$key." = '".$value."'";
						break;
				}
			}
		}

		/* query */
		$sql = "
		select
			*
		from
			ai
			left join z_ai_type on ai_id = z_ai_type_ai_id
		where
			ai_deleted = 0
			".$where."
		";
		$query = $this->db->query($sql);
		// echo $this->db->last_query();
		return $query->result();
	}
 
}