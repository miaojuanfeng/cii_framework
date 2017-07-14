<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About {

	public function __construct()
	{
		$this->load->model('cms/page_model', 'page_model');
	}

	public function index()
	{
		// echo "<pre>";
		// var_dump($this);
		// echo "</pre>";
		// die();
		/* page */
		$thisSelect = array(
			'where' => array('page_id' => 1),
			'order' => 'page_id',
			'ascend' => 'ASC',
			'limit' => 2,
			'page' => 0,
			'return' => 'result'
		);

		$data['page'] = $this->page_model->select($thisSelect)[0];

		$this->load->view('web/about_view', $data);
	}

}
