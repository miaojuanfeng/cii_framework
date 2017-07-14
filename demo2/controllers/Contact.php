<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact {

	public function __construct()
	{
		
	}

	public function index()
	{
		$data = array();

		$this->load->view('web/contact_view', $data);
	}

}
