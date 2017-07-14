<?php
	// session_start();
	// $_SESSION['name'] = 'miaojuanfeng';
	// var_dump($_SESSION);

function redirect($uri){
	header("Location: "."http://localhost:8888/km-dev/".$uri);
	die();
}

function convert_object_to_array($obj){
	return (array)$obj;
}

	$cii = cii_run('configs/config.php');
	echo "<pre>";
	var_dump($cii);
	echo "</pre>";

	// $_SESSION['address'] = 'asdasdasd';
	// $a = $_SESSION;
	// echo "<pre>";
	// var_dump($a);
	// var_dump($_SESSION);
	// var_dump($cii->session);
	// // var_dump($cii->session->unset_userdata('address'));
	// unset($_SESSION['address']);
	// var_dump($_SESSION);
	// var_dump($cii->session);
	// var_dump($a);
	// echo "</pre>";

	// echo "<pre>";
	// //var_dump($_SESSION);
	// $_SESSION['name'] = "miaojuanfeng";
	// //var_dump($_SESSION);
	// $cii->session->age = 25;
	// var_dump($cii->session->age);
	// var_dump($cii->session->unset_userdata('age'));
	// var_dump($cii->session);
	// var_dump($_SESSION);
	// echo "</pre>";
