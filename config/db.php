<?php
/**
* Database class, contains database connection and different operations
*/

class databaseObject {
	
	/**
	* Define database credentials
	*/
	var $host_name = "localhost";
	var $user_name = "root";
	var $pass_word = "";
	var $database_name = "rest_in_php";
	
	/**
	* Establish the database connection
	* If connection is successful, returns the connection
	*/
	function getConnection() {
		$conn = mysqli_connect($this->host_name, $this->user_name, $this->pass_word, $this->database_name) or die("Connection failed: " . mysqli_connect_error());
		if (mysqli_connect_errno()) {
			printf ("Connection failed: %s\n", mysqli_connect_error());
			exit();
		} else {
			$this->conn = $conn;
		}
		return $this->conn;
	}
	
	/**
	* getCompany method returns the list of company in JSON format form the database
	* @access public
	* returns JSON
	*/
	function getCompany($connection, $id = 0) {
		$query = "SELECT * FROM company_details";
		if ($id != 0) {
			$query .= " WHERE id = " . $id . " LIMIT 1";
		}
		$result = mysqli_query($connection, $query);
		$response = array();
		while($row = mysqli_fetch_assoc($result)) {
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	/**
	* addCompany method add a new entry into the database
	* @access public
	* return JSON
	*/
	function addCompany($connection, $data){
		$company_data = json_decode($data, true);
		$company_name = $company_data['company_name'];
		$company_turn_over = $company_data['company_turn_over'];
		$company_staff_number = $company_data['company_staff_number'];
		$company_established = $company_data['company_established'];
		
		$query = "INSERT INTO company_details (`company_name`, `company_turn_over`, `company_staff_number`, `company_established`) VALUES ('".$company_name."', '".$company_turn_over."', '".$company_staff_number."', '".$company_established."')";
		if(mysqli_query($connection, $query)) {
			$response = array(
				'status' => 1,
				'status_message' => 'Company added successfully'
			);
		} else {
			$response = array(
				'status' => 0,
				'status_message' => 'Company addition failed'
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	/**
	* updateCompany method updates a specific entry
	* @access public
	* returns JSON
	*/
	function updateCompany($connection, $id, $data){
		$company_data = json_decode($data, true);
		$company_name = $company_data['company_name'];
		$company_turn_over = $company_data['company_turn_over'];
		$company_staff_number = $company_data['company_staff_number'];
		$company_established = $company_data['company_established'];
		
		$query = "UPDATE company_details SET company_name = '".$company_name."', company_turn_over = '".$company_turn_over."', company_staff_number = '".$company_staff_number."', company_established = '".$company_established."' WHERE id = ".$id;
		if(mysqli_query($connection, $query)) {
			$response = array(
				'status' => 1,
				'status_message' => 'Company updated successfully'
			);
		} else {
			$response = array(
				'status' => 0,
				'status_message' => 'Company updating failed'
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	/**
	* deleteCompany method deletes an entry from the database
	* @access public
	* returns JSON
	*/
	function deleteCompany($connection, $id) {
		$query = "DELETE FROM company_details WHERE id = ".$id;
		if(mysqli_query($connection, $query)) {
			$response = array(
				'status' => 1,
				'status_message' => 'Company deleted successfully'
			);
		} else {
			$response = array(
				'status' => 0,
				'status_message' => 'Company deletion failed'
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
}
	
?>