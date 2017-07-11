<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Load extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// check_session_timeout();
		// check_is_login();
		// check_permission();
	}

	public function index()
	{
		// redirect('user/select');
		$this->{$this->input->post('thisTableId')}();
	}

	public function role()
	{
		$this->load->model('cms/z_permission_role_model');
			
		/* z_permission_role */
		$thisSelect = array(
			'where' => array('role_id' => $this->input->post('thisRecordId'))
		);
		$thisData = $this->z_permission_role_model->select($thisSelect);

		if($thisData){
			echo '<table class="table table-hover">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>#</th>';
			echo '<th>Class</th>';
			echo '<th>Action</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
			foreach($thisData as $key => $value){
				echo '<tr>';
				echo '<td>'.($key + 1).'</td>';
				echo '<td>'.ucfirst($value->permission_class).'</td>';
				echo '<td>'.ucfirst($value->permission_action).'</td>';
				echo '</tr>';
			}
			echo '</tbody>';
			echo '</table>';
		}else{
			echo '<table class="table table-hover">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>No record found</th>';
			echo '</tr>';
			echo '</thead>';
			echo '</table>';
		}
	}

	public function user()
	{
		$this->load->model('cms/z_role_user_model');
			
		/* z_role_user */
		$thisSelect = array(
			'where' => array('user_id' => $this->input->post('thisRecordId'))
		);
		$thisData = $this->z_role_user_model->select($thisSelect);

		if($thisData){
			echo '<table class="table table-hover">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Role name</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
			foreach($thisData as $key => $value){
				echo '<tr>';
				echo '<td>'.ucfirst($value->role_name).'</td>';
				echo '</tr>';
			}
			echo '</tbody>';
			echo '</table>';
		}else{
			echo '<table class="table table-hover">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>No record found</th>';
			echo '</tr>';
			echo '</thead>';
			echo '</table>';
		}
	}

	public function log()
	{
		$this->load->model('cms/log_model');
			
		/* log */
		$thisSelect = array(
			'where' => array('log_id' => $this->input->post('thisRecordId')),
			'return' => 'result'
		);
		$thisData = $this->log_model->select($thisSelect);

		if($thisData){
			echo '<table class="table table-hover">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>SQL statement</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
			foreach($thisData as $key => $value){
				echo '<tr>';
				echo '<td>'.$value->log_SQL.'</td>';
				echo '</tr>';
			}
			echo '</tbody>';
			echo '</table>';
		}else{
			echo '<table class="table table-hover">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>No record found</th>';
			echo '</tr>';
			echo '</thead>';
			echo '</table>';
		}
	}

	public function menu()
	{
		$this->load->model('cms/menu_model');
			
		/* menu */
		$thisSelect = array(
			'where' => array('menu_parent' => $this->input->post('thisRecordId')),
			'return' => 'result'
		);
		$thisData = $this->menu_model->select($thisSelect);

		if($thisData){
			echo '<table class="table table-hover">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Submenu name</th>';
			echo '<th width="40"></th>';
			echo '<th width="40" class="text-right"></th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
			foreach($thisData as $key => $value){
				echo '<tr>';
				echo '<td>'.ucfirst($value->menu_name).'</td>';
				echo '<td>';
				echo 	'<a href="'.base_url('cms/menu/update/menu_id/'.$value->menu_id).'" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Update">';
				echo		'<i class="glyphicon glyphicon-pencil"></i>';
				echo 	'</a>';
				echo '</td>';
				echo '<td>';
				echo 	'<a onclick="check_delete('.$value->menu_id.');" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Delete">';
				echo 		'<i class="glyphicon glyphicon-remove"></i>';
				echo 	'</a>';
				echo '</td>';
				echo '</tr>';
			}
			echo '</tbody>';
			echo '</table>';
		}else{
			echo '<table class="table table-hover">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>No record found</th>';
			echo '</tr>';
			echo '</thead>';
			echo '</table>';
		}
	}

}
