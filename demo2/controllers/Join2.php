<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Join2 {

	public function __construct()
	{
		
	}

	public function index()
	{
		$data = array();

		$this->load->view('web/join2_view', $data);
	}

}
