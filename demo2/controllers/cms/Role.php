<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		check_session_timeout();
		check_is_login();
		convert_get_slashes_pretty_link();
		check_permission();

		$this->load->model('cms/permission_model');
		$this->load->model('cms/role_model');
		$this->load->model('cms/z_permission_role_model');
	}

	public function index()
	{
		redirect('cms/role/select');
	}

	public function update()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$this->role_model->update($thisPOST);
			$this->z_permission_role_model->delete($thisPOST);
			$this->z_permission_role_model->insert($thisPOST);

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['role_id'];
			set_log($thisLog);

			redirect($thisPOST['referrer']);
		}else{
			/* role */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4),
				'return' => 'result'
			);
			$data['role'] = $this->role_model->select($thisSelect)[0];

			/* permission */
			$thisSelect = array(
				'group' => array('permission_class'),
				'return' => 'result'
			);
			$data['permission_classs'] = $this->permission_model->select($thisSelect);

			$thisSelect = array(
				'return' => 'result'
			);
			$data['permissions'] = $this->permission_model->select($thisSelect);
			
			/* z_permission_role */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4)
			);
			$data['z_permission_role_permission_ids'] = convert_object_to_array($this->z_permission_role_model->select($thisSelect), 'z_permission_role_permission_id');

			$this->load->view('cms/role_view', $data);
		}
	}

	public function delete()
	{
		$thisPOST = $this->input->post();
		$this->role_model->delete($thisPOST);

		$thisLog['log_permission_class'] = $this->router->fetch_class();
		$thisLog['log_permission_action'] = $this->router->fetch_method();
		$thisLog['log_record_id'] = $thisPOST['role_id'];
		set_log($thisLog);

		redirect($this->agent->referrer());
	}

	public function insert()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$thisInsertId = $this->role_model->insert($thisPOST);
			$thisPOST['role_id'] = $thisInsertId;
			$this->z_permission_role_model->insert($thisPOST);

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['role_id'];
			set_log($thisLog);

			redirect($thisPOST['referrer']);
		}else{
			/* preset empty data */
			$thisArray = array();
			foreach($this->role_model->structure() as $key => $value){
				$thisArray[$value->Field] = '';
			}
			$data['role'] = (object)$thisArray;

			/* permission */
			$thisSelect = array(
				'group' => array('permission_class'),
				'return' => 'result'
			);
			$data['permission_classs'] = $this->permission_model->select($thisSelect);

			$thisSelect = array(
				'return' => 'result'
			);
			$data['permissions'] = $this->permission_model->select($thisSelect);
			
			/* z_permission_role */
			$data['z_permission_role_permission_ids'] = array();

			$this->load->view('cms/role_view', $data);
		}
	}

	public function select()
	{
		$per_page = 3;

		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'limit' => $per_page,
			'return' => 'result'
		);
		$data['roles'] = $this->role_model->select($thisSelect);

		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'return' => 'num_rows'
		);
		$data['num_rows'] = $this->role_model->select($thisSelect);

		/* pagination */
		$this->pagination->initialize(get_pagination_config($per_page, $data['num_rows']));

		$this->load->view('cms/role_view', $data);
	}

}
