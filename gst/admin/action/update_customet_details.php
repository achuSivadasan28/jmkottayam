<?php
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$customer_name = $_POST['customer_name'];
$phone = $_POST['phone'];
$place = $_POST['place'];
$Tprice = $_POST['Tprice'];
$Tdiscount = $_POST['Tdiscount'];
$tamount = $_POST['tamount'];
$url_val = $_POST['url_val'];
$update_data = array(
	"customer_name" => $customer_name,
	"phone" => $phone,
	"place" => $place,
	"total_price" => $Tprice,
	"total_discount" => $Tdiscount,
	"total_amonut" => $tamount,
	"edit_data" => $days,
	"edit_time" => $times,
	"remark" => "Admin Edited",
	"edit_status" => 1
);
$obj->updateData("tbl_customer",$update_data,"where id=$url_val");


?>