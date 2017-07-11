<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class R_permission_role_model extends CI_Model {
	
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
			case (isset($data['permission_id'])):
				$thisData['r_permission_role_permission_id'] = $data['permission_id'];
				$data = DO_get_array_prefix('r_permission_role_', $data);
				break;
			case (isset($data['role_id'])):
				$thisData['r_permission_role_role_id'] = $data['role_id'];
				$data = DO_get_array_prefix('r_permission_role_', $data);
				break;
		}
		$this->db->where($thisData);
		$this->db->delete('r_permission_role');
	}

	function insert($data = array())
	{
		switch(true){
			case (isset($data['permission_id'])):
				$thisData['r_permission_role_permission_id'] = $data['permission_id'];
				$data = DO_get_array_prefix('r_permission_role_', $data);
				foreach($data as $key => $value){
					foreach($value as $key1 => $value1){
						$thisData['r_permission_role_role_id'] = $value1;
						$this->db->insert('r_permission_role', $thisData);
					}
				}
				break;
			case (isset($data['role_id'])):
				$thisData['r_permission_role_role_id'] = $data['role_id'];
				$data = DO_get_array_prefix('r_permission_role_', $data);
				foreach($data as $key => $value){
					foreach($value as $key1 => $value1){
						$thisData['r_permission_role_permission_id'] = $value1;
						$this->db->insert('r_permission_role', $thisData);
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
					case 'permission_id':
					case 'role_id':
						$where .= " and ".'r_permission_role_'.$key." = '".$value."'";
						break;
				}
			}
		}

		/* query */
		$sql = "
		select
			*
		from
			permission
			left join r_permission_role on permission_id = r_permission_role_permission_id
			left join role on r_permission_role_role_id = role_id
		where
			permission_deleted = 'N'
			and role_deleted = 'N'
			".$where."
		";
		$query = $this->db->query($sql);
		return $query->result();
	}
 
}