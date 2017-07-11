<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		check_session_timeout();
		check_is_login();

		$this->load->model('cms/dashboard_model');
		$this->load->model('cms/user_model');
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
