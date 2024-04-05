<?php
require_once '../../_class/query.php';
$obj=new query();
header('Content-type:application/json;charset=utf-8');
$data = json_decode(file_get_contents('php://input'),true);
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$id=$_GET['id'];
$customer_name = $data['customer_name'];
$phone = $data['customer_phn'];
$place = $data['customer_place'];

$update_data = array(
	"customer_name" => $customer_name,
	"phone" => $phone,
	"place" => $place,
	"edit_data" => $days,
	"edit_time" => $times,
	"remark" => "Admin Edited",
	"edit_status" => 1
);
$obj->updateData("tbl_customer",$update_data,"where id=$id");

echo 1;
?>