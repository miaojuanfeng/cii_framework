<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Join extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = array();

		$this->load->view('web/join_view', $data);
	}

}
