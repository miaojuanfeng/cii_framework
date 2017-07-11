<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Action extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = array();

		// $this->load->view('web/action_view', $data);
		$this->load->view('web/error_view', $data);
	}

}
