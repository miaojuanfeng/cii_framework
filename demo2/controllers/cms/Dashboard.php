<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard {

	public function __construct()
	{
		$this->load->model('cms/dashboard_model', 'dashboard_model');
		$this->load->model('cms/user_model', 'user_model');

		$this->load->helper('123', 'helpers/function_helper.php');
	}

	public function index()
	{
		redirect('cms/dashboard/select');
	}

	public function select()
	{
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(),
			'limit' => 4,
			'return' => 'result'
		);
		$data['users'] = $this->user_model->select($thisSelect);

		$this->load->view('cms/dashboard_view', $data);
	}

}
