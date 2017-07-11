<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		check_session_timeout();
		check_is_login();
		convert_get_slashes_pretty_link();
		check_permission();

		$this->load->model('cms/news_model');
		$this->load->model('cms/country_model');
	}

	public function index()
	{
		redirect('cms/news/select');
	}

	public function update()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$this->news_model->update($thisPOST);

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['news_id'];
			set_log($thisLog);

			redirect($thisPOST['referrer']);
		}else{
			/* news */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4),
				'return' => 'result'
			);
			$data['news'] = $this->news_model->select($thisSelect)[0];

			/* country */
			$thisSelect = array(
				'where' => array(),
				'return' => 'result'
			);
			$data['country'] = $this->country_model->select($thisSelect);

			$this->load->view('cms/news_view', $data);
		}
	}

	public function delete()
	{
		$thisPOST = $this->input->post();
		$this->news_model->delete($thisPOST);

		$thisLog['log_permission_class'] = $this->router->fetch_class();
		$thisLog['log_permission_action'] = $this->router->fetch_method();
		$thisLog['log_record_id'] = $thisPOST['news_id'];
		set_log($thisLog);

		redirect($this->agent->referrer());
	}

	public function insert()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$thisInsertId = $this->news_model->insert($thisPOST);
			$thisPOST['news_id'] = $thisInsertId;

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['news_id'];
			set_log($thisLog);
			
			redirect($thisPOST['referrer']);
		}else{
			/* preset empty data */
			$thisArray = array();
			foreach($this->news_model->structure() as $key => $value){
				$thisArray[$value->Field] = '';
			}
			$data['news'] = (object)$thisArray;

			/* country */
			$thisSelect = array(
				'where' => array(),
				'return' => 'result'
			);
			$data['country'] = $this->country_model->select($thisSelect);

			$this->load->view('cms/news_view', $data);
		}
	}

	public function select()
	{
		$per_page = 3;

		/* news */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'limit' => $per_page,
			'return' => 'result'
		);
		$data['newss'] = $this->news_model->select($thisSelect);

		/* num rows */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'return' => 'num_rows'
		);
		$data['num_rows'] = $this->news_model->select($thisSelect);

		/* pagination */
		$this->pagination->initialize(get_pagination_config($per_page, $data['num_rows']));

		$this->load->view('cms/news_view', $data);
	}

}
