<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page {

	public function __construct()
	{
		$this->load->model('cms/page_model', 'page_model');
	}

	public function index()
	{
		redirect('cms/page/select');
	}

	public function update()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$this->page_model->update($thisPOST);

			$path = $_SERVER['DOCUMENT_ROOT'].'/joy/km/assets/uploads/page/';
			if($_FILES['page_photo']['error'] == UPLOAD_ERR_OK){
				move_uploaded_file($_FILES['page_photo']['tmp_name'], $path.$thisPOST['page_id']);
			}

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['page_id'];
			set_log($thisLog);

			redirect($thisPOST['referrer']);
		}else{
			/* page */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4),
				'return' => 'result'
			);
			$data['page'] = $this->page_model->select($thisSelect)[0];

			$this->load->view('cms/page_view', $data);
		}
	}

	public function delete()
	{
		$thisPOST = $this->input->post();
		$this->page_model->delete($thisPOST);

		$thisLog['log_permission_class'] = $this->router->fetch_class();
		$thisLog['log_permission_action'] = $this->router->fetch_method();
		$thisLog['log_record_id'] = $thisPOST['page_id'];
		set_log($thisLog);

		redirect($this->agent->referrer());
	}

	public function insert()
	{
		// if($this->input->post()){
		// 	$thisPOST = $this->input->post();
		// 	$thisInsertId = $this->page_model->insert($thisPOST);
		// 	$thisPOST['page_id'] = $thisInsertId;

		// 	$thisLog['log_permission_class'] = $this->router->fetch_class();
		// 	$thisLog['log_permission_action'] = $this->router->fetch_method();
		// 	$thisLog['log_record_id'] = $thisPOST['page_id'];
		// 	set_log($thisLog);
			
		// 	redirect($thisPOST['referrer']);
		// }else{
		// 	/* preset empty data */
		// 	$thisArray = array();
		// 	foreach($this->page_model->structure() as $key => $value){
		// 		$thisArray[$value->Field] = '';
		// 	}
		// 	$data['page'] = (object)$thisArray;

		// 	$this->load->view('cms/page_view', $data);
		// }
	}

	public function select()
	{
		$per_page = 3;

		/* page */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'limit' => $per_page,
			'return' => 'result'
		);
		$data['pages'] = $this->page_model->select($thisSelect);

		/* num rows */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'return' => 'num_rows'
		);
		$data['num_rows'] = $this->page_model->select($thisSelect);

		/* pagination */
		$this->pagination->initialize(get_pagination_config($per_page, $data['num_rows']));

		$this->load->view('cms/page_view', $data);
	}

}
