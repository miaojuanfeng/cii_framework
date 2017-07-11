<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}

	// function select(){
	// 	$sql = "select * from user where user_deleted = 'N'";
	// 	$query = $this->db->query($sql);
	// 	return $query->result();
	// }
 
}