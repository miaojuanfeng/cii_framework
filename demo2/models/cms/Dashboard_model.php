<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model {
	
	function __construct()
	{
		$this->load->database('default');
	}

	// function select(){
	// 	$sql = "select * from user where user_deleted = 'N'";
	// 	$query = $this->db->query($sql);
	// 	return $query->result();
	// }
 
}