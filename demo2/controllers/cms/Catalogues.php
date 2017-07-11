<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogues extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		check_session_timeout();
		check_is_login();
		convert_get_slashes_pretty_link();
		check_permission();

		$this->load->model('cms/catalogues_model');
		$this->load->model('cms/country_model');
		$this->load->model('cms/ai_model');
		$this->load->model('cms/z_ai_type_model');
	}

	public function index()
	{
		redirect('cms/catalogues/select');
	}

	public function update()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			if($_FILES['catalogues_photo']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['catalogues_photo']['tmp_name'], '/var/www/uat/minedition/assets/uploads/catalogues/photo/'.$_FILES['catalogues_photo']['name']);
				$thisPOST['catalogues_photo'] = $_FILES['catalogues_photo']['name'];
			}
			if($_FILES['catalogues_url']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['catalogues_url']['tmp_name'], '/var/www/uat/minedition/assets/uploads/catalogues/attachment/'.$_FILES['catalogues_photo']['name']);
				$thisPOST['catalogues_url'] = $_FILES['catalogues_url']['name'];
			}
			$this->catalogues_model->update($thisPOST);

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['catalogues_id'];
			set_log($thisLog);

			redirect($thisPOST['referrer']);
		}else{
			/* catalogues */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4),
				'return' => 'result'
			);
			$data['catalogues'] = $this->catalogues_model->select($thisSelect)[0];

			/* country */
			$thisSelect = array(
				'where' => array(),
				'return' => 'result'
			);
			$data['country'] = $this->country_model->select($thisSelect);

			/* author */
			$thisSelect = array(
				'where' => array('type_id' => 1),
				'return' => 'result'
			);
			$data['author'] = $this->z_ai_type_model->select($thisSelect);

			/* illustrator */
			$thisSelect = array(
				'where' => array('type_id' => 2),
				'return' => 'result'
			);
			$data['illustrator'] = $this->z_ai_type_model->select($thisSelect);

			$this->load->view('cms/catalogues_view', $data);
		}
	}

	public function delete()
	{
		$thisPOST = $this->input->post();
		$this->catalogues_model->delete($thisPOST);

		$thisLog['log_permission_class'] = $this->router->fetch_class();
		$thisLog['log_permission_action'] = $this->router->fetch_method();
		$thisLog['log_record_id'] = $thisPOST['catalogues_id'];
		set_log($thisLog);

		redirect($this->agent->referrer());
	}

	public function insert()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			if($_FILES['catalogues_photo']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['catalogues_photo']['tmp_name'], '/var/www/uat/minedition/assets/uploads/catalogues/photo/'.$_FILES['catalogues_photo']['name']);
				$thisPOST['catalogues_photo'] = $_FILES['catalogues_photo']['name'];
			}
			if($_FILES['catalogues_url']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['catalogues_url']['tmp_name'], '/var/www/uat/minedition/assets/uploads/catalogues/attachment/'.$_FILES['catalogues_photo']['name']);
				$thisPOST['catalogues_url'] = $_FILES['catalogues_url']['name'];
			}
			$thisInsertId = $this->catalogues_model->insert($thisPOST);
			$thisPOST['catalogues_id'] = $thisInsertId;

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['catalogues_id'];
			set_log($thisLog);
			
			redirect($thisPOST['referrer']);
		}else{
			/* preset empty data */
			$thisArray = array();
			foreach($this->catalogues_model->structure() as $key => $value){
				$thisArray[$value->Field] = '';
			}
			$data['catalogues'] = (object)$thisArray;

			/* country */
			$thisSelect = array(
				'where' => array(),
				'return' => 'result'
			);
			$data['country'] = $this->country_model->select($thisSelect);

			/* author */
			$thisSelect = array(
				'where' => array('type_id' => 1),
				'return' => 'result'
			);
			$data['author'] = $this->z_ai_type_model->select($thisSelect);

			/* illustrator */
			$thisSelect = array(
				'where' => array('type_id' => 2),
				'return' => 'result'
			);
			$data['illustrator'] = $this->z_ai_type_model->select($thisSelect);

			$this->load->view('cms/catalogues_view', $data);
		}
	}

	public function select()
	{
		$per_page = 3;

		/* catalogues */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'limit' => $per_page,
			'return' => 'result'
		);
		$data['catalogues'] = $this->catalogues_model->select($thisSelect);

		/* num rows */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'return' => 'num_rows'
		);
		$data['num_rows'] = $this->catalogues_model->select($thisSelect);

		/* pagination */
		$this->pagination->initialize(get_pagination_config($per_page, $data['num_rows']));

		$this->load->view('cms/catalogues_view', $data);
	}

}
