<?php
/**
* Declare headers for POST method
*/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Hedaers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

/**
* initiate Database and Product object
*/
include_once("../config/database.php");
include_once("../objects/product.php");

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

/**
* read product data from a json file
*/
$data = json_decode(file_get_contents("product.json"));

/**
* setting product properties
*/
$product->name = $data->name;
$product->price = $data->price;
$product->description = $data->description;
$product->category_id = $data->category_id;
$product->created = date('Y-m-d H:i:s');

/**
* adding the product into database
*/
if ($product->create()) {
	echo json_encode(array("message" => "Product was created"));
} else {
	echo json_encode(array("message" => "Product was not created"));
}

?>