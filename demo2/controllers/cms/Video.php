<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video {

	public function __construct()
	{
		$this->load->model('cms/video_model', 'video_model');

		$this->load->helper('123', 'helpers/function_helper.php');

	}

	public function index()
	{
		redirect('cms/video/select');
	}

	public function update()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$this->video_model->update($thisPOST);

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['video_id'];
			set_log($thisLog);

			redirect($thisPOST['referrer']);
		}else{
			/* video */
			$thisSelect = array(
				'where' => $this->uri->uri_to_assoc(4),
				'return' => 'result'
			);
			$data['video'] = $this->video_model->select($thisSelect)[0];

			$this->load->view('cms/video_view', $data);
		}
	}

	public function delete()
	{
		$thisPOST = $this->input->post();
		$this->video_model->delete($thisPOST);

		$path = $_SERVER['DOCUMENT_ROOT'].'/minedition/assets/uploads/video/';
		if (file_exists($path.$thisPOST['video_id'])) {
			unlink($path.$thisPOST['video_id']);
		}

		$thisLog['log_permission_class'] = $this->router->fetch_class();
		$thisLog['log_permission_action'] = $this->router->fetch_method();
		$thisLog['log_record_id'] = $thisPOST['video_id'];
		set_log($thisLog);

		redirect($this->agent->referrer());
	}

	public function insert()
	{
		if($this->input->post()){
			$thisPOST = $this->input->post();
			$thisInsertId = $this->video_model->insert($thisPOST);

			$thisLog['log_permission_class'] = $this->router->fetch_class();
			$thisLog['log_permission_action'] = $this->router->fetch_method();
			$thisLog['log_record_id'] = $thisPOST['video_id'];
			set_log($thisLog);
			
			redirect($thisPOST['referrer']);
		}else{
			/* preset empty data */
			$thisArray = array();
			foreach($this->video_model->structure() as $key => $value){
				$thisArray[$value->Field] = '';
			}
			$data['video'] = (object)$thisArray;

			$this->load->view('cms/video_view', $data);
		}
	}

	public function select()
	{
		$per_page = 3;

		/* video */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'limit' => $per_page,
			'return' => 'result'
		);
		$data['videos'] = $this->video_model->select($thisSelect);

		foreach ($data['videos'] as $key => $value) {
			$data['videos'][$key]->video_video = 'http://uat.dreamover-studio.cn/minedition/assets/uploads/video/'.$value->video_id;
		}

		/* num rows */
		$thisSelect = array(
			'where' => $this->uri->uri_to_assoc(4),
			'return' => 'num_rows'
		);
		$data['num_rows'] = $this->video_model->select($thisSelect);

		/* pagination */
		$this->pagination->initialize(get_pagination_config($per_page, $data['num_rows']));

		$this->load->view('cms/video_view', $data);
	}

}
