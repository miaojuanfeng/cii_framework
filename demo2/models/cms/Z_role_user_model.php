<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Z_role_user_model extends CI_Model {
	
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
				$thisData['z_role_user_role_id'] = $data['role_id'];
				$data = get_array_prefix('z_role_user_', $data);
				break;
			case (isset($data['user_id'])):
				$thisData['z_role_user_user_id'] = $data['user_id'];
				$data = get_array_prefix('z_role_user_', $data);
				break;
		}
		$this->db->where($thisData);
		$thisResult = $this->db->delete('z_role_user');

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
				$thisData['z_role_user_role_id'] = $data['role_id'];
				$data = get_array_prefix('z_role_user_', $data);
				foreach($data as $key => $value){
					foreach($value as $key1 => $value1){
						$thisData['z_role_user_user_id'] = $value1;
						$thisResult = $this->db->insert('z_role_user', $thisData);

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
				$thisData['z_role_user_user_id'] = $data['user_id'];
				$data = get_array_prefix('z_role_user_', $data);
				foreach($data as $key => $value){
					foreach($value as $key1 => $value1){
						$thisData['z_role_user_role_id'] = $value1;
						$thisResult = $this->db->insert('z_role_user', $thisData);

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
						$where .= " and ".'z_role_user_'.$key." = '".$value."'";
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
			left join z_role_user on role_id = z_role_user_role_id
			left join user on z_role_user_user_id = user_id
		where
			role_deleted = 'N'
			and user_deleted = 'N'
			".$where."
		";
		$query = $this->db->query($sql);
		return $query->result();
	}
 
}