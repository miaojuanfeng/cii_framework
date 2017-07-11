<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}

	function select($data = array())
	{
		/* where */
		$where = "";
		if(isset($data['where'])){
			foreach($data['where'] as $key => $value){
				switch($key){
					case 'log_id':
					case 'log_permission_class':
					case 'log_permission_action':
						$where .= " and ".$key." = '".$value."'";
						break;
					case 'page':
						$data['offset'] = $value;
						break;
				}
			}
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
		$sql = "select * from log where log_id > 0".$where." order by log_id desc".$limit.$offset;
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
		$query = $this->db->query("show full columns from log");
		return $query->result();
	}
 
}