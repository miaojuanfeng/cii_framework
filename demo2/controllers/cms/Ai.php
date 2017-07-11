<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ai extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		check_session_timeout();
		check_is_login();
		convert_get_slashes_pretty_link();
		check_permission();

		$this->load->model('cms/ai_model');
		$this->load->model('cms/country_model');
		$this->load->model('cms/z_ai_type_model');
	}

	public function index()
	{
		redirect('cms/ai/select');
	}

	public function update()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			if($_FILES['ai_photo']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['ai_photo']['tmp_name'], '/var/www/uat/minedition/assets/uploads/ai/'.$_FILES['ai_photo']['name']);
				$thisPOST['ai_photo'] = $_FILES['ai_photo']['name'];
			}
			$this->ai_model->update($thisPOST);
			$this->z_ai_type_model->delete($thisPOST);
			$this->z_ai_type_model->insert($thisPOST);

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['ai_id'];
			set_log($thisLog);

			redirect($thisPOST['referrer']);
		}else{
			/* ai */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4),
				'return' => 'result'
			);
			$data['ai'] = $this->ai_model->select($thisSelect)[0];

			/* z_ai_type */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4),
				'return' => 'result'
			);
			$data['z_ai_type_type_ids'] = convert_object_to_array($this->z_ai_type_model->select($thisSelect), 'z_ai_type_type_id');

			$this->load->view('cms/ai_view', $data);
		}
	}

	public function delete()
	{
		$thisPOST = $this->input->post();
		$this->ai_model->delete($thisPOST);

		$thisLog['log_permission_class'] = $this->router->fetch_class();
		$thisLog['log_permission_action'] = $this->router->fetch_method();
		$thisLog['log_record_id'] = $thisPOST['ai_id'];
		set_log($thisLog);

		redirect($this->agent->referrer());
	}

	public function insert()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			if($_FILES['ai_photo']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['ai_photo']['tmp_name'], '/var/www/uat/minedition/assets/uploads/ai/'.$_FILES['ai_photo']['name']);
				$thisPOST['ai_photo'] = $_FILES['ai_photo']['name'];
			}
			$thisInsertId = $this->ai_model->insert($thisPOST);
			$thisPOST['ai_id'] = $thisInsertId;

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['ai_id'];
			set_log($thisLog);
			
			redirect($thisPOST['referrer']);
		}else{
			/* preset empty data */
			$thisArray = array();
			foreach($this->ai_model->structure() as $key => $value){
				$thisArray[$value->Field] = '';
			}
			$data['ai'] = (object)$thisArray;

			/* country */
			$thisSelect = array(
				'where' => array(),
				'return' => 'result'
			);
			$data['country'] = $this->country_model->select($thisSelect);

			$this->load->view('cms/ai_view', $data);
		}
	}

	public function select()
	{
		$per_page = 3;

		/* ai */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'limit' => $per_page,
			'return' => 'result'
		);
		$data['ais'] = $this->ai_model->select($thisSelect);

		foreach ($data['ais'] as $key => $value) {
			/* z_ai_type */
			$thisSelect = array(
				'where' => array('ai_id' => $value->ai_id),
				'return' => 'result'
			);
			$z_ai_type_type_ids = convert_object_to_array($this->z_ai_type_model->select($thisSelect), 'z_ai_type_type_id');

			if( in_array(1, $z_ai_type_type_ids) && in_array(2, $z_ai_type_type_ids) ){
				$data['ais'][$key]->ai_type = 'Author / Illustrator';
			}else if( in_array(1, $z_ai_type_type_ids) ){
				$data['ais'][$key]->ai_type = 'Author';
			}else if( in_array(2, $z_ai_type_type_ids) ){
				$data['ais'][$key]->ai_type = 'Illustrator';
			}
		}

		/* num rows */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'return' => 'num_rows'
		);
		$data['num_rows'] = $this->ai_model->select($thisSelect);

		/* pagination */
		$this->pagination->initialize(get_pagination_config($per_page, $data['num_rows']));

		$this->load->view('cms/ai_view', $data);
	}

}
