<?php

class News_model{
	
	function __construct()
	{
		$this->load->database();
	}

	public function select()
	{
		$result = $this->db->query('select * from user');
	}
}