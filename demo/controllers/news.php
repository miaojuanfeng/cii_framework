<?php

class News {

	public function __construct()
	{
		$this->news_model = $this->load->model('news_model');
	}

	public function index()
	{
		$this->news_model->select();
		$this->load->view('news_view');
	}

}