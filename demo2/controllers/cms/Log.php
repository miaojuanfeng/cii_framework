<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		check_session_timeout();
		check_is_login();
		convert_get_slashes_pretty_link();
		check_permission();

		$this->load->model('cms/log_model');
		$this->load->model('cms/permission_model');
	}

	public function index()
	{
		redirect('cms/log/select');
	}

	public function select()
	{
		$per_page = 10;

		/* log */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(),
			'limit' => $per_page,
			'return' => 'result'
		);
		$data['logs'] = $this->log_model->select($thisSelect);

		/* num rows */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(),
			'return' => 'num_rows'
		);
		$data['num_rows'] = $this->log_model->select($thisSelect);

		/* permission */
		$thisSelect = array(
			'group' => array('permission_class'),
			'return' => 'result'
		);
		$data['permission_classs'] = $this->permission_model->select($thisSelect);

		/* permission */
		$thisSelect = array(
			'group' => array('permission_action'),
			'return' => 'result'
		);
		$data['permission_actions'] = $this->permission_model->select($thisSelect);

		/* pagination */
		$this->pagination->initialize(get_pagination_config($per_page, $data['num_rows']));

		$this->load->view('cms/log_view', $data);
	}

}
