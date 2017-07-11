<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		check_session_timeout();
		check_is_login();
		convert_get_slashes_pretty_link();
		check_permission();

		$this->load->model('cms/banner_model');
	}

	public function index()
	{
		redirect('cms/banner/select');
	}

	public function update()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$this->banner_model->update($thisPOST);

			$path = $_SERVER['DOCUMENT_ROOT'].'/joy/km/assets/uploads/banner/';
			if($_FILES['banner_photo']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['banner_photo']['tmp_name'], $path.$thisPOST['banner_id']);
			}

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['banner_id'];
			set_log($thisLog);

			redirect($thisPOST['referrer']);
		}else{
			/* banner */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4),
				'return' => 'result'
			);
			$data['banner'] = $this->banner_model->select($thisSelect)[0];

			$this->load->view('cms/banner_view', $data);
		}
	}

	public function delete()
	{
		$thisPOST = $this->input->post();
		$this->banner_model->delete($thisPOST);

		$path = $_SERVER['DOCUMENT_ROOT'].'/joy/km/assets/uploads/banner/';
		if (file_exists($path.$thisPOST['banner_id'])) {
			unlink($path.$thisPOST['banner_id']);
		}

		$thisLog['log_permission_class'] = $this->router->fetch_class();
		$thisLog['log_permission_action'] = $this->router->fetch_method();
		$thisLog['log_record_id'] = $thisPOST['banner_id'];
		set_log($thisLog);

		redirect($this->agent->referrer());
	}

	public function insert()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$thisInsertId = $this->banner_model->insert($thisPOST);


			$path = $_SERVER['DOCUMENT_ROOT'].'/joy/km/assets/uploads/banner/';

			if (!file_exists($path)) {
				mkdir($path, 0775);
			}

			if($_FILES['banner_photo']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['banner_photo']['tmp_name'], $path.$thisInsertId);
			}


			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['banner_id'];
			set_log($thisLog);
			
			redirect($thisPOST['referrer']);
		}else{
			/* preset empty data */
			$thisArray = array();
			foreach($this->banner_model->structure() as $key => $value){
				$thisArray[$value->Field] = '';
			}
			$data['banner'] = (object)$thisArray;

			$this->load->view('cms/banner_view', $data);
		}
	}

	public function select()
	{
		$per_page = 3;

		/* banner */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'limit' => $per_page,
			'return' => 'result'
		);
		$data['banners'] = $this->banner_model->select($thisSelect);

		foreach ($data['banners'] as $key => $value) {
			$data['banners'][$key]->banner_banner = 'http://uat.dreamover-studio.cn/joy/km/assets/uploads/banner/'.$value->banner_id;
		}

		/* num rows */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'return' => 'num_rows'
		);
		$data['num_rows'] = $this->banner_model->select($thisSelect);

		/* pagination */
		$this->pagination->initialize(get_pagination_config($per_page, $data['num_rows']));

		$this->load->view('cms/banner_view', $data);
	}

}
