<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		check_session_timeout();
		check_is_login();
		convert_get_slashes_pretty_link();
		check_permission();

		$this->load->model('cms/role_model');
		$this->load->model('cms/user_model');
		$this->load->model('cms/z_role_user_model');
		$this->load->model('cms/z_user_country_model');
		$this->load->model('cms/country_model');
	}

	public function index()
	{
		redirect('cms/user/select');
	}

	public function update()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$this->user_model->update($thisPOST);
			$this->z_role_user_model->delete($thisPOST);
			$this->z_role_user_model->insert($thisPOST);
			$this->z_user_country_model->delete($thisPOST);
			$this->z_user_country_model->insert($thisPOST);

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['user_id'];
			set_log($thisLog);

			redirect($thisPOST['referrer']);
		}else{
			/* user */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4),
				'return' => 'result'
			);
			$data['user'] = $this->user_model->select($thisSelect)[0];

			/* role */
			$thisSelect = array(
				'return' => 'result'
			);
			$data['roles'] = $this->role_model->select($thisSelect);
			
			/* z_role_user */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4)
			);
			$data['z_role_user_role_ids'] = convert_object_to_array($this->z_role_user_model->select($thisSelect), 'z_role_user_role_id');

			/* country */
			$thisSelect = array(
				'where' => array(),
				'return' => 'result'
			);
			$data['country'] = $this->country_model->select($thisSelect);

			/* z_user_country */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4),
				'return' => 'result'
			);
			$data['z_user_country_ids'] = convert_object_to_array($this->z_user_country_model->select($thisSelect), 'z_user_country_country_id');

			$this->load->view('cms/user_view', $data);
		}
	}

	public function delete()
	{
		$thisPOST = $this->input->post();
		$this->user_model->delete($thisPOST);

		$thisLog['log_permission_class'] = $this->router->fetch_class();
		$thisLog['log_permission_action'] = $this->router->fetch_method();
		$thisLog['log_record_id'] = $thisPOST['user_id'];
		set_log($thisLog);

		redirect($this->agent->referrer());
	}

	public function insert()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$thisInsertId = $this->user_model->insert($thisPOST);
			$thisPOST['user_id'] = $thisInsertId;
			$this->z_role_user_model->insert($thisPOST);

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['user_id'];
			set_log($thisLog);
			
			redirect($thisPOST['referrer']);
		}else{
			/* preset empty data */
			$thisArray = array();
			foreach($this->user_model->structure() as $key => $value){
				$thisArray[$value->Field] = '';
			}
			$data['user'] = (object)$thisArray;

			/* role */
			$thisSelect = array(
				'return' => 'result'
			);
			$data['roles'] = $this->role_model->select($thisSelect);
			
			/* z_role_user */
			$data['z_role_user_role_ids'] = array();

			/* country */
			$thisSelect = array(
				'where' => array(),
				'return' => 'result'
			);
			$data['country'] = $this->country_model->select($thisSelect);

			$this->load->view('cms/user_view', $data);
		}
	}

	public function select()
	{
		$per_page = 3;

		/* user */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'limit' => $per_page,
			'return' => 'result'
		);
		$data['users'] = $this->user_model->select($thisSelect);

		/* num rows */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'return' => 'num_rows'
		);
		$data['num_rows'] = $this->user_model->select($thisSelect);

		/* pagination */
		$this->pagination->initialize(get_pagination_config($per_page, $data['num_rows']));

		$this->load->view('cms/user_view', $data);
	}

}
