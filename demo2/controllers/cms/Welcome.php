<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		check_session_timeout();
		check_is_login();
		convert_get_slashes_pretty_link();
		check_permission();

		$this->load->model('cms/welcome_model');
	}

	public function index()
	{
		redirect('cms/welcome/update/welcome_id/1');
	}

	public function update()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$this->welcome_model->update($thisPOST);

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['welcome_id'];
			set_log($thisLog);

			// redirect($thisPOST['referrer']);
			redirect('cms/welcome/update/welcome_id/1');
		}else{
			/* welcome */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(),
				'return' => 'result'
			);
			$data['welcome'] = $this->welcome_model->select($thisSelect)[0];

			$this->load->view('cms/welcome_view', $data);
		}
	}

	public function delete()
	{
		// do delete here
	}

	public function insert()
	{
		// do insert here
	}

	public function select()
	{
		// do select here
	}

}
