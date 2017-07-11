<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		check_session_timeout();
		check_is_login();
		convert_get_slashes_pretty_link();
		check_permission();

		$this->load->model('cms/announcement_model');
		$this->load->model('cms/category_model');
	}

	public function index()
	{
		redirect('cms/announcement/select');
	}

	public function update()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			if($_FILES['pdf_en']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['pdf_en']['tmp_name'], '/var/www/UBA/assets/images/pdf/'.$_FILES['pdf_en']['name']);
				$thisPOST['announcement_pdf_en'] = $_FILES['pdf_en']['name'];
			}
			if($_FILES['pdf_tc']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['pdf_tc']['tmp_name'], '/var/www/UBA/assets/images/pdf/'.$_FILES['pdf_tc']['name']);
				$thisPOST['announcement_pdf_tc'] = $_FILES['pdf_tc']['name'];
			}
			$this->announcement_model->update($thisPOST);

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['announcement_id'];
			set_log($thisLog);

			redirect($thisPOST['referrer']);
		}else{
			/* announcement */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4),
				'return' => 'result'
			);
			$data['announcement'] = $this->announcement_model->select($thisSelect)[0];

			/* category */
			$thisSelect = array(
				'return' => 'result'
			);
			$data['categorys'] = $this->category_model->select($thisSelect);

			$this->load->view('cms/announcement_view', $data);
		}
	}

	public function delete()
	{
		$thisPOST = $this->input->post();
		$this->announcement_model->delete($thisPOST);

		$thisLog['log_permission_class'] = $this->router->fetch_class();
		$thisLog['log_permission_action'] = $this->router->fetch_method();
		$thisLog['log_record_id'] = $thisPOST['announcement_id'];
		set_log($thisLog);

		redirect($this->agent->referrer());
	}

	public function insert()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			if($_FILES['pdf_en']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['pdf_en']['tmp_name'], '/var/www/UBA/assets/images/pdf/'.$_FILES['pdf_en']['name']);
				$thisPOST['announcement_pdf_en'] = $_FILES['pdf_en']['name'];
			}
			if($_FILES['pdf_tc']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['pdf_tc']['tmp_name'], '/var/www/UBA/assets/images/pdf/'.$_FILES['pdf_tc']['name']);
				$thisPOST['announcement_pdf_tc'] = $_FILES['pdf_tc']['name'];
			}
			$thisInsertId = $this->announcement_model->insert($thisPOST);
			$thisPOST['announcement_id'] = $thisInsertId;

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['announcement_id'];
			set_log($thisLog);
			
			redirect($thisPOST['referrer']);
		}else{
			/* preset empty data */
			$thisArray = array();
			foreach($this->announcement_model->structure() as $key => $value){
				$thisArray[$value->Field] = '';
			}
			$data['announcement'] = (object)$thisArray;

			/* category */
			$thisSelect = array(
				'return' => 'result'
			);
			$data['categorys'] = $this->category_model->select($thisSelect);

			$this->load->view('cms/announcement_view', $data);
		}
	}

	public function select()
	{
		$per_page = 12;

		/* announcement */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'limit' => $per_page,
			'return' => 'result'
		);
		$data['announcements'] = $this->announcement_model->select($thisSelect);

		/* num rows */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'return' => 'num_rows'
		);
		$data['num_rows'] = $this->announcement_model->select($thisSelect);

		/* pagination */
		$this->pagination->initialize(get_pagination_config($per_page, $data['num_rows']));

		$this->load->view('cms/announcement_view', $data);
	}

}
