<?php 
	include("../config/db.php");
	$db = new databaseObject();
	$connection = $db->getConnection();
	$request_method = $_SERVER['REQUEST_METHOD'];
	//echo $request_method;
	switch($request_method) {
		case 'GET':
			if(!empty($_GET['id'])) {
				$id = intval($_GET['id']);
				$db->getCompany($connection, $id);
			} else {
				$db->getCompany($connection);
			}
		case 'POST':
			if(isset($_POST)){
				$data = '{"company_name":"Zoom Inc", "company_turn_over":"100,000,000,000", "company_staff_number":"389", "company_established":"2008"}';
				$db->addCompany($connection, $data);
			}
		case 'PUT':
			if(isset($_GET['id'])){
				$data = '{"company_name":"Zoom Inc", "company_turn_over":"100,000,000,000", "company_staff_number":"389", "company_established":"2008"}';
				$db->updateCompany($connection, $id, $data);
			}
		case 'DELETE';
			if(isset($_GET['id']))
				$db->deleteCompany($connection, $id);
		default:
			header("HTTP/1.0 405 Method Not Allowed");
	}
?>