<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		convert_get_slashes_pretty_link();

		$this->load->model('cms/login_model');
	}

	public function index()
	{
		redirect('cms/login/select');
	}

	public function select()
	{
		if($this->input->post()){
			/* check login */
			$thisSelect = array(
				'where' => $this->input->post(),
				'return' => 'result'
			);
			$user = $this->login_model->check_login($thisSelect);

			if($user){
				$user = $user[0];

				/* get permission */
				$thisSelect = array(
					'where' => array('user_id' => $user->user_id),
					'return' => 'result'
				);
				$permissions = convert_object_to_array($this->login_model->get_permission($thisSelect), 'permission_name');

				/* save session */
				$this->session->set_userdata('user_id', $user->user_id);
				$this->session->set_userdata('permission', $permissions);

				//$thisReferrer = $this->uri->uri_to_assoc();
				// if($this->uri->uri_to_assoc(4) && $this->uri->segment(1) == 'cms'){
				// 	redirect(base64_decode(urldecode($this->uri->uri_to_assoc()['referrer'])));
				// }else{
					redirect('cms/dashboard');
				// }
			}else{
				$this->session->set_tempdata('alert', '<div class="btn btn-xs btn-block btn-default">Wrong username & password</div>', 0);
				redirect('cms/login');
			}
		}else{
			$this->session->unset_userdata('user_id');
			$this->session->unset_userdata('permission');
			$this->session->unset_userdata('last_activity');

			$this->load->view('cms/login_view');	
		}
	}

}
