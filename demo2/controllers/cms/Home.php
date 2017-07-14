<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home {

	public function __construct()
	{
		// check_session_timeout();
		// check_is_login();
		// convert_get_slashes_pretty_link();
		// check_permission();

		$this->load->model('cms/main_model');
	}

	public function index()
	{
		redirect('cms/main/select');
		// echo "Hello world";
	}

	public function update()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$this->main_model->update($thisPOST);

			$path = $_SERVER['DOCUMENT_ROOT'].'/minedition/assets/uploads/main/';
			if($_FILES['main_photo']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['main_photo']['tmp_name'], $path.$thisPOST['main_id']);
			}

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['main_id'];
			set_log($thisLog);

			redirect($thisPOST['referrer']);
		}else{
			/* main */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4),
				'return' => 'result'
			);
			$data['main'] = $this->main_model->select($thisSelect)[0];

			/* country */
			$thisSelect = array(
				'where' => array(),
				'return' => 'result'
			);
			$data['country'] = $this->country_model->select($thisSelect);

			$this->load->view('cms/main_view', $data);
		}
	}

	public function delete()
	{
		$thisPOST = $this->input->post();
		$this->main_model->delete($thisPOST);

		$path = $_SERVER['DOCUMENT_ROOT'].'/minedition/assets/uploads/main/';
		if (file_exists($path.$thisPOST['main_id'])) {
			unlink($path.$thisPOST['main_id']);
		}

		$thisLog['log_permission_class'] = $this->router->fetch_class();
		$thisLog['log_permission_action'] = $this->router->fetch_method();
		$thisLog['log_record_id'] = $thisPOST['main_id'];
		set_log($thisLog);

		redirect($this->agent->referrer());
	}

	public function insert()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$thisInsertId = $this->main_model->insert($thisPOST);

			$path = $_SERVER['DOCUMENT_ROOT'].'/minedition/assets/uploads/main/';

			if (!file_exists($path)) {
				mkdir($path, 0775);
			}

			if($_FILES['main_photo']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['main_photo']['tmp_name'], $path.$thisInsertId);
			}

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['main_id'];
			set_log($thisLog);
			
			redirect($thisPOST['referrer']);
		}else{
			/* preset empty data */
			$thisArray = array();
			foreach($this->main_model->structure() as $key => $value){
				$thisArray[$value->Field] = '';
			}
			$data['main'] = (object)$thisArray;

			$this->load->view('cms/main_view', $data);
		}
	}

	public function select()
	{
		$per_page = 3;

		/* main */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			// 'limit' => $per_page,
			'return' => 'result'
		);
		$data['mains'] = $this->main_model->select($thisSelect);

		foreach ($data['mains'] as $key => $value) {
			$data['mains'][$key]->main_banner = 'http://uat.dreamover-studio.cn/minedition/assets/uploads/main/'.$value->main_id;
		}

		/* num rows */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'return' => 'num_rows'
		);
		$data['num_rows'] = $this->main_model->select($thisSelect);

		/* pagination */
		$this->pagination->initialize(get_pagination_config($per_page, $data['num_rows']));

		$this->load->view('cms/main_view', $data);
	}

}
