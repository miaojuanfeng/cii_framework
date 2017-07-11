<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Z_user_country_model extends CI_Model {
	
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
			case (isset($data['country_id'])):
				$thisData['z_user_country_country_id'] = $data['country_id'];
				$data = get_array_prefix('z_user_country_', $data);
				break;
			case (isset($data['user_id'])):
				$thisData['z_user_country_user_id'] = $data['user_id'];
				$data = get_array_prefix('z_user_country_', $data);
				break;
		}
		$this->db->where($thisData);
		$thisResult = $this->db->delete('z_user_country');

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
			case (isset($data['country_id'])):
				$thisData['z_user_country_country_id'] = $data['country_id'];
				$data = get_array_prefix('z_user_country_', $data);
				foreach($data as $key => $value){
					foreach($value as $key1 => $value1){
						$thisData['z_user_country_user_id'] = $value1;
						$thisResult = $this->db->insert('z_user_country', $thisData);

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
				$thisData['z_user_country_user_id'] = $data['user_id'];
				$data = get_array_prefix('z_user_country_', $data);
				foreach($data as $key => $value){
					foreach($value as $key1 => $value1){
						$thisData['z_user_country_country_id'] = $value1;
						$thisResult = $this->db->insert('z_user_country', $thisData);

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
					case 'country_id':
					case 'user_id':
						$where .= " and ".'z_user_country_'.$key." = '".$value."'";
						break;
				}
			}
		}

		/* query */
		$sql = "
		select
			*
		from
			country
			left join z_user_country on country_id = z_user_country_country_id
			left join user on z_user_country_user_id = user_id
		where
			user_deleted = 'N'
			".$where."
		";
		$query = $this->db->query($sql);
		return $query->result();
	}
 
}