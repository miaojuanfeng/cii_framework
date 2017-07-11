<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		check_session_timeout();
		check_is_login();
		convert_get_slashes_pretty_link();
		check_permission();

		$this->load->model('cms/book_model');
		$this->load->model('cms/country_model');
		$this->load->model('cms/ai_model');
		$this->load->model('cms/z_ai_type_model');
		$this->load->model('cms/menu_model');
	}

	public function index()
	{
		redirect('cms/book/select');
	}

	public function update()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			if($_FILES['book_photo']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['book_photo']['tmp_name'], '/var/www/uat/minedition/assets/uploads/book/'.$_FILES['book_photo']['name']);
				$thisPOST['book_photo'] = $_FILES['book_photo']['name'];
			}
			$this->book_model->update($thisPOST);

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['book_id'];
			set_log($thisLog);

			redirect($thisPOST['referrer']);
		}else{
			/* book */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4),
				'return' => 'result'
			);
			$data['book'] = $this->book_model->select($thisSelect)[0];

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

			/* book */
			$data['book_menu'] = array();
			$thisSelect = array(
				'where' => array('menu_name' => 'BOOKS', 'menu_hide' => 0),
				'return' => 'result'
			);
			$book_menu = $this->menu_model->select($thisSelect)[0];
			if( $book_menu ){
				$thisSelect = array(
					'where' => array('menu_parent' => $book_menu->menu_id, 'menu_hide' => 0),
					'return' => 'result'
				);
				$data['book_menu'] = $this->menu_model->select($thisSelect);
			}

			$this->load->view('cms/book_view', $data);
		}
	}

	public function delete()
	{
		$thisPOST = $this->input->post();
		$this->book_model->delete($thisPOST);

		$thisLog['log_permission_class'] = $this->router->fetch_class();
		$thisLog['log_permission_action'] = $this->router->fetch_method();
		$thisLog['log_record_id'] = $thisPOST['book_id'];
		set_log($thisLog);

		redirect($this->agent->referrer());
	}

	public function insert()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			if($_FILES['book_photo']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['book_photo']['tmp_name'], '/var/www/uat/minedition/assets/uploads/book/'.$_FILES['book_photo']['name']);
				$thisPOST['book_photo'] = $_FILES['book_photo']['name'];
			}
			$thisInsertId = $this->book_model->insert($thisPOST);
			$thisPOST['book_id'] = $thisInsertId;

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['book_id'];
			set_log($thisLog);
			
			redirect($thisPOST['referrer']);
		}else{
			/* preset empty data */
			$thisArray = array();
			foreach($this->book_model->structure() as $key => $value){
				$thisArray[$value->Field] = '';
			}
			$data['book'] = (object)$thisArray;

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

			$this->load->view('cms/book_view', $data);
		}
	}

	public function select()
	{
		$per_page = 3;

		/* book */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'limit' => $per_page,
			'return' => 'result'
		);
		$data['books'] = $this->book_model->select($thisSelect);

		foreach ($data['books'] as $key => $value) {
			// /* z_ai_type */
			// $thisSelect = array(
			// 	'where' => array('type_id' => 1, 'ai_id' => $value->book_author),
			// 	'return' => 'row_array'
			// );
			// $data['books'][$key]->book_author = $this->z_ai_type_model->select($thisSelect)[0]->ai_name;

			/* author */
			$thisSelect = array(
				'where' => array('ai_id' => $value->book_author),
				'return' => 'row_array'
			);
			$data['books'][$key]->book_author = $this->ai_model->select($thisSelect)['ai_name'];
			/* illustrator */
			$thisSelect = array(
				'where' => array('ai_id' => $value->book_illustrator),
				'return' => 'row_array'
			);
			$data['books'][$key]->book_illustrator = $this->ai_model->select($thisSelect)['ai_name'];
		}

		/* num rows */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'return' => 'num_rows'
		);
		$data['num_rows'] = $this->book_model->select($thisSelect);

		/* pagination */
		$this->pagination->initialize(get_pagination_config($per_page, $data['num_rows']));

		$this->load->view('cms/book_view', $data);
	}

}
