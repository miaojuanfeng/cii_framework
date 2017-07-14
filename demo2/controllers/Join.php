<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Join {

	public function __construct()
	{
		
	}

	public function index()
	{
		$data = array();

		$this->load->view('web/join_view', $data);
	}

}
