<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact2 {

	public function __construct()
	{
		
	}

	public function index()
	{
		$data = array();

		$this->load->view('web/contact2_view', $data);
	}

}
