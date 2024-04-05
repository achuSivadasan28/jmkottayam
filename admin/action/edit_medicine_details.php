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
$medicine_details_id = $_POST['medicine_details_id'];
$tax_data = $_POST['tax_data'];
$purchased_price = $_POST['purchased_price'];
$purchase_date = $_POST['purchase_date'];
$invoice_num = $_POST['invoice_num'];
//tbl_medicine_details
$info_update_medicine = array(
	"no_of_pills" => $no_of_pills,
	"price" => $price,
	"hsn_sac" => $hsn_num,
	"batch" => $batch_name,
	"expiry_date" => $exp_date,
	"discount" => $discount,
	"quantity" => $quantity,
	"updated_date" => $days,
	"updated_time" => $times,
	"tax_data" => $tax_data,
	"purchased_price" => $purchased_price,
	"purchased_date" => $purchase_date,
	"invoice_num" => $invoice_num,
);
$obj->updateData("tbl_medicine_details",$info_update_medicine,"where id=$medicine_details_id");
echo 1;
?>