<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database('default');
	}

	// function select(){
	// 	$sql = "select * from user where user_deleted = 'N'";
	// 	$query = $this->db->query($sql);
	// 	return $query->result();
	// }

	private function checkout_language(){
		if( $this->session->lang == 'en' ){
			return 'en';
		}else if( $this->session->lang == 'tc' ){
			return 'tc';
		}
	}

	public function main_data_welcome(){
		$sql = "SELECT welcome_content_".$this->checkout_language()." AS welcome_content FROM welcome WHERE welcome_deleted = 'N' AND welcome_id = 1";
		$query = $this->db->query($sql);
		return $query->row_array()["welcome_content"];
	}

	public function business_data_subsidiary(){
		$sql = "SELECT groupbusiness_companyname_".$this->checkout_language()." AS groupbusiness_companyname, groupbusiness_location_".$this->checkout_language()." AS groupbusiness_location, groupbusiness_mainbusiness_".$this->checkout_language()." AS groupbusiness_mainbusiness FROM groupbusiness WHERE groupbusiness_deleted = 'N' ORDER BY groupbusiness_id ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function business_data_registered_office(){
		$sql = "SELECT registeredoffice_title_".$this->checkout_language()." AS registeredoffice_title, registeredoffice_content_".$this->checkout_language()." AS registeredoffice_content FROM registeredoffice WHERE registeredoffice_deleted = 'N' ORDER BY registeredoffice_id ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
 
 	public function directors_data_directors(){
		$sql = "SELECT director_content_".$this->checkout_language()." AS director_content FROM director WHERE director_deleted = 'N' AND director_id = 1";
		$query = $this->db->query($sql);
		return $query->row_array()["director_content"];
	}

 	public function information_data_information(){
		$sql = "SELECT information_content_".$this->checkout_language()." AS information_content FROM information WHERE information_deleted = 'N' AND information_id = 1";
		$query = $this->db->query($sql);
		return $query->row_array()["information_content"];
	}

	public function announcement_data_category(){
		$sql = "SELECT category_url, category_name_".$this->checkout_language()." AS category_name FROM category WHERE category_deleted = 'N' ORDER BY category_id ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function announcement_data_year($category){
		$sql = "SELECT announcement_year FROM announcement LEFT JOIN category ON announcement_category_id = category_id WHERE announcement_deleted = 'N' AND category_deleted = 'N' AND category_url = '".$category."' GROUP BY announcement_year ASC ORDER BY announcement_year DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function announcement_data_announcement($category, $year){
		$sql = "SELECT announcement_id, DATE_FORMAT(announcement_date,'%d/%m/%Y') as announcement_date, announcement_name_".$this->checkout_language()." AS announcement_name, announcement_hkex_".$this->checkout_language()." AS announcement_hkex, announcement_pdf_".$this->checkout_language()." AS announcement_pdf FROM announcement LEFT JOIN category ON announcement_category_id = category_id WHERE announcement_deleted = 'N' AND category_deleted = 'N' AND category_url = '".$category."' AND announcement_year = '".$year."' ORDER BY announcement_date DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function announcement_data_all(){
		$sql = "SELECT announcement_id, DATE_FORMAT(announcement_date,'%d/%m/%Y') as announcement_date, announcement_name_".$this->checkout_language()." AS announcement_name, announcement_hkex_".$this->checkout_language()." AS announcement_hkex, announcement_pdf_".$this->checkout_language()." AS announcement_pdf FROM announcement LEFT JOIN category ON announcement_category_id = category_id WHERE announcement_deleted = 'N' AND category_deleted = 'N' ORDER BY announcement_date DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function send_email($name, $subject, $email, $msg = ''){
		require("PHPMailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->From = $email;
		$mail->FromName = "Minedtion";
		$mail->AddAddress("michael.miao@dreamover-studio.com", "Minedtion");
		// $mail->AddAddress("michael.miao@dreamover-studio.com", "UBA INVESTMENTS LIMITED"); 
		//$mail->AddBCC("ymh@hktours.com.hk", "Hongkong Tour");
		$mail->IsHTML(true);
		$mail->CharSet = "UTF-8";
		$mail->Subject = $subject;
		$mail->Body .=
			"<html>".
				"<body>".
					"Received a message".
					"<br />".
					"-----------------------".
					"<br />".
					"Name: ". $name.
					"<br />".
					"Email: ". $email.
					"<br />".
					"Message: ". $msg.
					"<br />".
					"-----------------------".
					"<br />".
					"Michael Neugebauer Edition,Inc.<br />".
				"</body>".
			"</html>";
		if( !$mail->Send() ){
			return false;
		}
		return true;
	}
}