<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}

	function update($data = array())
	{
		$data['permission_modify'] = date('Y-m-d H:i:s');
		$data = get_array_prefix('permission_', $data);
		$this->db->where('permission_id', $data['permission_id']);
		$this->db->update('permission', $data); 
	}

	function delete($data = array())
	{
		$data['permission_modify'] = date('Y-m-d H:i:s');
		$data['permission_deleted'] = 'Y';
		$data = get_array_prefix('permission_', $data);
		$this->db->where('permission_id', $data['permission_id']);
		$this->db->update('permission', $data);
	}

	function insert($data = array())
	{
		$data['permission_create'] = date('Y-m-d H:i:s');
		$data['permission_modify'] = date('Y-m-d H:i:s');
		$data['permission_deleted'] = 'N';
		$data = get_array_prefix('permission_', $data);
		$this->db->insert('permission', $data);
		$thisInsertId = $this->db->insert_id();
		return($thisInsertId);
	}

	function select($data = array())
	{
		/* where */
		$where = "";
		if(isset($data['where'])){
			foreach($data['where'] as $key => $value){
				switch($key){
					case 'permission_id':
						$where .= " and ".$key." = '".$value."'";
						break;
					case 'permission_name':
						$where .= " and ".$key." like '%".$value."%'";
						break;
					case 'page':
						$data['offset'] = $value;
						break;
				}
			}
		}

		/* group */
		$group = "";
		if(isset($data['group'])){
			$group .= " group by ".implode(', ', $data['group']);
		}

		/* limit */
		$limit = "";
		if(isset($data['limit'])){
			$limit = " limit ".$data['limit'];
		}

		/* offset */
		$offset = "";
		if(isset($data['offset'])){
			if(isset($data['limit'])){
				$offset = " offset ".$data['offset'];
			}
		}

		/* query */
		$sql = "select * from permission where permission_deleted = 'N'".$where.$group.$limit.$offset;
		$query = $this->db->query($sql);

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
		$query = $this->db->query("show full columns from permission");
		return $query->result();
	}
 
}