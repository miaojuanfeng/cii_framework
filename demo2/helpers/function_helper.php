<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if(!function_exists('get_country_id'))
{
	function get_country_id(){
		$CI =& cii_get_instance();
		if( !$CI->session->userdata('country_id') ){
			$CI->session->set_userdata('country_id', 3);
		}
		return $CI->session->userdata('country_id');
	}
}

if(!function_exists('get_country_name'))
{
	function get_country_name(){
		$CI =& cii_get_instance();
		if( !$CI->session->userdata('country_id') ){
			$CI->session->set_userdata('country_id', 3);
		}
		if($CI->session->userdata('country_id')==1){
			
		};
	}
}

if(!function_exists('set_country_id'))
{
	function set_country_id($country_id){
		$CI =& cii_get_instance();
		$CI->session->set_userdata('country_id', $country_id);
	}
}

////////////////////////////////////

if(!function_exists('get_category'))
{
	function get_category($thisId){
		$CI =& cii_get_instance();
		$CI->load->model('cms/category_model');

		/* user */
		$thisSelect = array(
			'where' => array(
				'category_id' => $thisId
			),
			'return' => 'result'
		);
		$data = $CI->category_model->select($thisSelect)[0];

		if($data){
			return $data;
		}else{
			return false;
		}
	}
}

if(!function_exists('get_user'))
{
	function get_user($thisId){
		$CI =& cii_get_instance();
		$CI->load->model('cms/user_model', 'user_model');

		/* user */
		$thisSelect = array(
			'where' => array(
				'user_id' => $thisId
			),
			'return' => 'result'
		);
		$data = $CI->user_model->select($thisSelect)[0];

		if($data){
			return $data;
		}else{
			return false;
		}
	}
}

if(!function_exists('get_role'))
{
	function get_role($thisId){
		$CI =& cii_get_instance();
		$CI->load->model('cms/role_model');

		/* role */
		$thisSelect = array(
			'where' => array(
				'role_id' => $thisId
			),
			'return' => 'result'
		);
		$data = $CI->role_model->select($thisSelect)[0];

		if($data){
			return $data;
		}else{
			return false;
		}
	}
}

if(!function_exists('get_pagination_config'))
{
	function get_pagination_config($per_page, $num_rows){
		$CI =& cii_get_instance();
		$page_link = $CI->uri->uri_to_assoc(4);
		unset($page_link['page']);

		$config['base_url'] = cii_base_url('cms/'.$CI->router->fetch_class().'/select/'.$CI->uri->assoc_to_uri($page_link).'/page');
		$config['total_rows'] = $num_rows;
		$config['per_page'] = $per_page;
		$config['num_links'] = 1;
		$config['first_link'] = '<<';
		$config['last_link'] = '>>';
		$config['full_tag_open'] = '<span class="pagination-area">';
		$config['full_tag_close'] = '</span>';

		return $config;
	}
}

if(!function_exists('get_order_link'))
{
	function get_order_link($order_field){
		$CI =& cii_get_instance();

		/* convert order link */
		$thisOrderLink = $CI->uri->uri_to_assoc(4);
		unset($thisOrderLink['order']);
		unset($thisOrderLink['ascend']);

		/* get asc desc */
		$thisAscend = 'asc';
		if(isset($CI->uri->uri_to_assoc(4)['ascend'])){
			if($CI->uri->uri_to_assoc(4)['ascend'] == 'asc'){
				$thisAscend = 'desc';
			}else{
				$thisAscend = 'asc';	
			}
		}

		/* create link */
		return cii_base_url(
			'/cms/'
			.$CI->router->fetch_class().'/'
			.$CI->router->fetch_method()
			.'/order/'.$order_field
			.'/ascend/'.$thisAscend
			.'/'.$CI->uri->assoc_to_uri($thisOrderLink).'/'
		);
	}
}

if(!function_exists('convert_comma_to_array'))
{
	function convert_comma_to_array($thisData){
		if($thisData != ''){
			return explode(',', $thisData);
		}else{
			return false;
		}
	}
}

if(!function_exists('convert_array_to_comma'))
{
	function convert_array_to_comma($thisArray){
		if(is_array($thisArray)){
			return implode(',', $thisArray);
		}else{
			return false;
		}
	}
}

if(!function_exists('convert_get_to_slashes'))
{
	function convert_get_to_slashes(){
		$CI =& cii_get_instance();
		$thisGET = $CI->input->get();
		if($thisGET){
			foreach($thisGET as $key => $value){
				if($value == ''){
					unset($thisGET[$key]);
				}
			}
			redirect(cii_base_url('cms/'.$CI->router->fetch_class().'/'.$CI->router->fetch_method().'/'.$CI->uri->assoc_to_uri($thisGET)));
		}
	}
}

if(!function_exists('convert_get_slashes_pretty_link'))
{
	function convert_get_slashes_pretty_link(){
		$CI =& cii_get_instance();
		
		/* get to pretty link */
		$thisGET = $CI->input->get();
		if($thisGET){
			foreach($thisGET as $key => $value){
				if($value == ''){
					unset($thisGET[$key]);
				}
			}
			redirect(cii_base_url('cms/'.$CI->router->fetch_class().'/'.$CI->router->fetch_method().'/'.$CI->uri->assoc_to_uri($thisGET)));
			exit;
		}

		/* slashes to pretty link */
		$emptyValueSlashes = false;
		$thisSlashes = $CI->uri->uri_to_assoc(4);
		if($thisSlashes){
			foreach($thisSlashes as $key => $value){
				if($value == ''){
					$emptyValueSlashes = true;
					unset($thisSlashes[$key]);
				}
			}
			if($emptyValueSlashes){
				redirect(cii_base_url('cms/'.$CI->router->fetch_class().'/'.$CI->router->fetch_method().'/'.$CI->uri->assoc_to_uri($thisSlashes)));
				exit;
			}
		}
	}
}

if(!function_exists('get_array_prefix'))
{
	function get_array_prefix($thisPrefix, $thisData = array()){
		$thisArray = array();
		if(!empty($thisData)){
			foreach($thisData as $key => $value){
				if(strpos($key, $thisPrefix, 0) === 0){
					$thisArray[$key] = $value;
				}
			}
		}
		return $thisArray;
	}
}

if(!function_exists('convert_object_to_array'))
{
	function convert_object_to_array($thisObject = array(), $thisKey = ''){
		$thisArray = array();
		foreach($thisObject as $key => $value){
			$thisArray[] = $value->{$thisKey};
		}
		return $thisArray;
	}
}

if(!function_exists('convert_datetime_to_date'))
{
	function convert_datetime_to_date($thisDate){
		return date("Y-m-d", strtotime($thisDate));
	}
}

if(!function_exists('check_session_timeout'))
{
	function check_session_timeout(){
		$CI =& cii_get_instance();
		if($CI->session->userdata('last_activity') != '' && (time() - $CI->session->userdata('last_activity') > 3600)){
			redirect('cms/login/select/referrer/'.urlencode(base64_encode(current_url())));
		}
		$CI->session->set_userdata('last_activity', time());
	}
}

if(!function_exists('check_is_login'))
{
	function check_is_login(){
		$CI =& cii_get_instance();
		if($CI->session->userdata('user_id') === null or $CI->session->userdata('user_id') < 1){
			redirect('cms/login/select/referrer/'.urlencode(base64_encode(current_url())));
		}
	}
}

if(!function_exists('check_permission'))
{
	function check_permission($thisType = 'access'){
		$CI =& cii_get_instance();
		if($CI->router->fetch_method() != 'index'){
			if(!in_array($CI->router->fetch_class().'_'.$CI->router->fetch_method(), $CI->session->userdata('permission') )){
				if($thisType == 'access'){
					// redirect to access denied page and logout
					die('Access denied');
				}
				if($thisType == 'display'){
					return ' disabled="disabled"';
				}
			}else{
				return true;
			}
		}
	}
}

if(!function_exists('set_log'))
{
	function set_log($thisLog = array()){
		$CI =& cii_get_instance();

		$log_SQL = '';
		foreach($CI->session->userdata('log_SQL') as $key => $value){
			$thisResult = ($value['result']) ? '<b class="sql-success">SUCCESS</b> ' : '<b class="sql-failed">FAILED</b> ';
			$log_SQL .= '<div>'.$thisResult.htmlentities($value['sql']).'</div>';
		}
		$CI->session->unset_userdata('log_SQL');

		$thisLog['log_IP'] = $CI->input->ip_address();
		$thisLog['log_user_id'] = $CI->session->userdata('user_id');
		$thisLog['log_path'] = current_url();
		$thisLog['log_SQL'] = $log_SQL;
		$thisLog['log_create'] = date('Y-m-d H:i:s');

		$CI->db->insert('log', $thisLog);
	}
}

if(!function_exists('chuyan'))
{
	function chuyan($thisArray){
		echo '<pre>';
		print_r($thisArray);
		echo '</pre>';
	}
}

// if(!function_exists('escape_form_value'))
// {
// 	function escape_form_value($form_value){
// 		foreach($form_value as $key => $value){
// 			if(!is_array($value)){
// 				$form_value[$key] = trim($form_value[$key]);
// 				//$form_value[$key] = $mysqli->real_escape_string($form_value[$key]);
// 			}else{
// 				$value = escape_form_value($value);
// 				$form_value[$key] = $value;
// 			}
// 		}
// 		return $form_value;
// 	}
// }