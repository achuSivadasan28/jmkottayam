<?php
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$ProductName = $_POST['ProductName'];
$product_id = $_POST['product_id'];
$product_id_details = $_POST['product_id_details'];
$Price = $_POST['Price'];
$Quantity = $_POST['Quantity'];
$Rate = $_POST['Rate'];
$update_arr = array(
	"product_name" => $ProductName,
	"no_quantity" => $Quantity,
	"price" => $Price,
	"total_price" => $Rate,
	"product_id" => $product_id
);
$obj->updateData("tbl_productdetails",$update_arr,"where id=$product_id_details");

?>