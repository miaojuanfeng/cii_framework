<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model{
	
	function __construct()
	{
		$this->load->database('default');
	}

	function check_login($data = array())
	{
		/* where */
		$where = "";
		if(isset($data['where'])){
			foreach($data['where'] as $key => $value){
				switch($key){
					case 'user_username':
					case 'user_password':
						$where .= " and ".$key." = '".$value."'";
						break;
				}
			}
		}

		/* query */
		$sql = "select * from user where user_deleted = 'N'".$where;
		$query = $this->db->query($sql);
		return $query->result();
	}

	function check_country($data = array())
	{
		/* where */
		$where = "";
		if(isset($data['where'])){
			foreach($data['where'] as $key => $value){
				switch($key){
					case 'user_id':
						$where .= " z_user_country_".$key." = '".$value."'";
						break;
					default:
						$where = "0";
						break;
				}
			}
		}

		/* query */
		$sql = "select z_user_country_country_id from z_user_country where ".$where;
		$query = $this->db->query($sql);
		return $query->result();
	}

	function get_permission($data = array())
	{
		/* where */
		$where = "";
		if(isset($data['where'])){
			foreach($data['where'] as $key => $value){
				switch($key){
					case 'user_id':
						$where .= " and ".$key." = '".$value."'";
						break;
				}
			}
		}

		/* query */
		$sql = "select concat(permission_class, '_', permission_action) as permission_name from permission left join z_permission_role on permission_id = z_permission_role_permission_id left join role on z_permission_role_role_id = role_id left join z_role_user on role_id = z_role_user_role_id left join user on z_role_user_user_id = user_id where permission_deleted = 'N' and role_deleted = 'N' and user_deleted = 'N'".$where." group by permission_class, permission_action";
		$query = $this->db->query($sql);
		return $query->result();
	}
 
}