<?php
session_start();
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$product_id = $_POST['product_id'];
$no_of_pills = $_POST['no_of_pills'];
$price = $_POST['price'];
$hsn_num = $_POST['hsn_num'];
$batch_name = $_POST['batch_name'];
$exp_date = $_POST['exp_date'];
$discount = $_POST['discount'];
$quantity = $_POST['quantity'];
$tax_data = $_POST['tax_data'];
//tbl_medicine_details
$info_update_medicine = array(
	"product_id" => $product_id,
	"no_of_pills" => $no_of_pills,
	"price" => $price,
	"hsn_sac" => $hsn_num,
	"batch" => $batch_name,
	"expiry_date" => $exp_date,
	"discount" => $discount,
	"quantity" => $quantity,
	"tax_data" => $tax_data,
	"status" => 1
);
$obj->insertData("tbl_medicine_details",$info_update_medicine);
echo 1;
?>