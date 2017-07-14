<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer {

	public function __construct()
	{
		
	}

	public function index()
	{
		$data = array();

		// $this->load->view('web/customer_view', $data);
		$this->load->view('web/error_view', $data);
	}

	public function detail()
	{
		$data = array();

		$this->load->view('web/customer_detail_view', $data);
	}

}
