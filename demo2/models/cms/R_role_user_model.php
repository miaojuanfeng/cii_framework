<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class R_role_user_model extends CI_Model {
	
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
			case (isset($data['role_id'])):
				$thisData['r_role_user_role_id'] = $data['role_id'];
				$data = DO_get_array_prefix('r_role_user_', $data);
				break;
			case (isset($data['user_id'])):
				$thisData['r_role_user_user_id'] = $data['user_id'];
				$data = DO_get_array_prefix('r_role_user_', $data);
				break;
		}
		$this->db->where($thisData);
		$thisResult = $this->db->delete('r_role_user');

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
			case (isset($data['role_id'])):
				$thisData['r_role_user_role_id'] = $data['role_id'];
				$data = DO_get_array_prefix('r_role_user_', $data);
				foreach($data as $key => $value){
					foreach($value as $key1 => $value1){
						$thisData['r_role_user_user_id'] = $value1;
						$thisResult = $this->db->insert('r_role_user', $thisData);

						$log_SQL = $this->session->userdata('log_SQL');
						$log_SQL[] = array(
							'result' => $thisResult,
							'sql' => $this->db->last_query()
						);
						$this->session->set_userdata('log_SQL', $log_SQL);
					}
				}
				break;
			case (isset($data['user_id'])):
				$thisData['r_role_user_user_id'] = $data['user_id'];
				$data = DO_get_array_prefix('r_role_user_', $data);
				foreach($data as $key => $value){
					foreach($value as $key1 => $value1){
						$thisData['r_role_user_role_id'] = $value1;
						$thisResult = $this->db->insert('r_role_user', $thisData);

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
					case 'role_id':
					case 'user_id':
						$where .= " and ".'r_role_user_'.$key." = '".$value."'";
						break;
				}
			}
		}

		/* query */
		$sql = "
		select
			*
		from
			role
			left join r_role_user on role_id = r_role_user_role_id
			left join user on r_role_user_user_id = user_id
		where
			role_deleted = 'N'
			and user_deleted = 'N'
			".$where."
		";
		$query = $this->db->query($sql);
		return $query->result();
	}
 
}