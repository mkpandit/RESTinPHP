<?php
/**
* Product class to perform different operations on products
*/
class Product{
	
	private $conn;
	
	/**
	* Define the database table name for products
	*/
	private $table_name = "products";
	
	/**
	* product properties
	*/
	public $id;
	public $name;
	public $description;
	public $price;
	public $category_id;
	public $category_name;
	public $created;
	
	public function __construct($db) {
		$this->conn = $db;
	}
	
	/**
	* read method to read records from database
	* @access public
	* return object
	*/
	public function read() {
		//Prepared query statement
		$query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created FROM " . $this->table_name . " p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created DESC";
		$stmt = $this->conn->prepare($query);
		//Execute the prepared query
		$stmt->execute();
		return $stmt;
	}
	
	/**
	* create method to add a product into database
	* @access public
	* return boolean
	*/
	public function create() {
		//Prepare query statement
		$query = "INSERT INTO " . $this->table_name . " SET name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
		$stmt = $this->conn->prepare($query);
		
		//data curation
		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->price = htmlspecialchars(strip_tags($this->price));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->category_id = htmlspecialchars(strip_tags($this->category_id));
		$this->created = htmlspecialchars(strip_tags($this->created));
		
		//binding parameters for prepared statement
		$stmt->bindParam(":name", $this->name);
		$stmt->bindParam(":price", $this->price);
		$stmt->bindParam(":description", $this->description);
		$stmt->bindParam(":category_id", $this->category_id);
		$stmt->bindParam(":created", $this->created);
		
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}
	
	/**
	* delete method to delete a product from database
	* @access public
	* return boolean
	*/
	public function delete() {
		//Prepare query statement
		$query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
		$stmt = $this->conn->prepare($query);
		
		//data curation
		$this->id = htmlspecialchars(strip_tags($this->id));
		
		//binding parameters for prepared statement
		$stmt->bindParam(":id", $this->id);
		
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}
	
}
?>