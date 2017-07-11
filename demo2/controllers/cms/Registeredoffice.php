<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registeredoffice extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		check_session_timeout();
		check_is_login();
		convert_get_slashes_pretty_link();
		check_permission();

		$this->load->model('cms/registeredoffice_model');
	}

	public function index()
	{
		redirect('cms/registeredoffice/select');
	}

	public function update()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$this->registeredoffice_model->update($thisPOST);

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['registeredoffice_id'];
			set_log($thisLog);

			redirect($thisPOST['referrer']);
		}else{
			/* registeredoffice */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4),
				'return' => 'result'
			);
			$data['registeredoffice'] = $this->registeredoffice_model->select($thisSelect)[0];

			$this->load->view('cms/registeredoffice_view', $data);
		}
	}

	public function delete()
	{
		$thisPOST = $this->input->post();
		$this->registeredoffice_model->delete($thisPOST);

		$thisLog['log_permission_class'] = $this->router->fetch_class();
		$thisLog['log_permission_action'] = $this->router->fetch_method();
		$thisLog['log_record_id'] = $thisPOST['registeredoffice_id'];
		set_log($thisLog);

		redirect($this->agent->referrer());
	}

	public function insert()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$thisInsertId = $this->registeredoffice_model->insert($thisPOST);
			$thisPOST['registeredoffice_id'] = $thisInsertId;

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['registeredoffice_id'];
			set_log($thisLog);
			
			redirect($thisPOST['referrer']);
		}else{
			/* preset empty data */
			$thisArray = array();
			foreach($this->registeredoffice_model->structure() as $key => $value){
				$thisArray[$value->Field] = '';
			}
			$data['registeredoffice'] = (object)$thisArray;

			$this->load->view('cms/registeredoffice_view', $data);
		}
	}

	public function select()
	{
		$per_page = 12;

		/* registeredoffice */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'limit' => $per_page,
			'return' => 'result'
		);
		$data['registeredoffice'] = $this->registeredoffice_model->select($thisSelect);

		/* num rows */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'return' => 'num_rows'
		);
		$data['num_rows'] = $this->registeredoffice_model->select($thisSelect);

		/* pagination */
		$this->pagination->initialize(get_pagination_config($per_page, $data['num_rows']));

		$this->load->view('cms/registeredoffice_view', $data);
	}

}
