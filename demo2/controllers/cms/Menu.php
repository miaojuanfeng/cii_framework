<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		check_session_timeout();
		check_is_login();
		convert_get_slashes_pretty_link();
		check_permission();

		$this->load->model('cms/menu_model');
		$this->load->model('cms/country_model');
	}

	public function index()
	{
		redirect('cms/menu/select');
	}

	public function update()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$this->menu_model->update($thisPOST);

			if( !empty($_FILES['footer_photo']) ){
				$path = $_SERVER['DOCUMENT_ROOT'].'/minedition/assets/uploads/footer/';
				if (!file_exists($path)) {
					mkdir($path, 0775);
				}
				if($_FILES['footer_photo']['error'] == UPLOAD_ERR_OK){
					move_uploaded_file($_FILES['footer_photo']['tmp_name'], $path.$thisPOST['menu_id']);
				}
			}

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['menu_id'];
			set_log($thisLog);

			redirect($thisPOST['referrer']);
		}else{
			/* menu */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4),
				'return' => 'result'
			);
			$data['menu'] = $this->menu_model->select($thisSelect)[0];

			/* parent */
			$thisSelect = array(
				'where' => array('menu_name' => 'BOOKS'),
				'return' => 'result'
			);
			$data['parent'] = $this->menu_model->select($thisSelect);

			$this->load->view('cms/menu_view', $data);
		}
	}

	public function delete()
	{
		$thisPOST = $this->input->post();
		$this->menu_model->delete($thisPOST);

		$thisLog['log_permission_class'] = $this->router->fetch_class();
		$thisLog['log_permission_action'] = $this->router->fetch_method();
		$thisLog['log_record_id'] = $thisPOST['menu_id'];
		set_log($thisLog);

		redirect($this->agent->referrer());
	}

	public function insert()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$thisInsertId = $this->menu_model->insert($thisPOST);
			$thisPOST['menu_id'] = $thisInsertId;

			if( !empty($_FILES['footer_photo']) ){
				$path = $_SERVER['DOCUMENT_ROOT'].'/minedition/assets/uploads/footer/';
				if (!file_exists($path)) {
					mkdir($path, 0775);
				}
				if($_FILES['footer_photo']['error'] == UPLOAD_ERR_OK){
					move_uploaded_file($_FILES['footer_photo']['tmp_name'], $path.$thisInsertId);
				}
			}

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['menu_id'];
			set_log($thisLog);
			
			redirect($thisPOST['referrer']);
		}else{
			/* preset empty data */
			$thisArray = array();
			foreach($this->menu_model->structure() as $key => $value){
				$thisArray[$value->Field] = '';
			}
			$data['menu'] = (object)$thisArray;

			/* parent */
			$thisSelect = array(
				'where' => array('menu_name' => 'BOOKS'),
				'return' => 'result'
			);
			$data['parent'] = $this->menu_model->select($thisSelect);

			$this->load->view('cms/menu_view', $data);
		}
	}

	public function select()
	{
		$per_page = 6;

		/* menu */
		$thisSelect = array(
			'where' => array_merge($this->uri->uri_to_assoc(4), array('menu_parent' => 0)),
			'limit' => $per_page,
			'return' => 'result'
		);
		$data['menus'] = $this->menu_model->select($thisSelect);

		/* num rows */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'return' => 'num_rows'
		);
		// $data['num_rows'] = $this->menu_model->select($thisSelect);
		$data['num_rows'] = 6;

		/* pagination */
		$this->pagination->initialize(get_pagination_config($per_page, $data['num_rows']));

		$this->load->view('cms/menu_view', $data);
	}

}
