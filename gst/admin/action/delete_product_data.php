<?php
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$btn_id = $_POST['btn_id'];
$url_val = $_POST['url_val'];
$total_amt = $_POST['total_amt'];
$g_total_amt = $_POST['g_total_amt'];
$total_dis = $_POST['total_dis'];
$p_actual_price = $_POST['p_actual_price'];
$p_total_price = $_POST['p_total_price'];
$info_update_data = array(
	"status" => 0,
	"remark" => "Admin Removed on ".$days." ".$times,
);
$obj->updateData("tbl_productdetails",$info_update_data,"where id=$btn_id");

$total_amt_g_total = $g_total_amt-$p_total_price;
$info_update_total = array(
	"total_price" => $total_amt_g_total,
	"total_discount" => $total_dis,
	"total_amonut" => $total_amt_g_total,
	"edit_status" => 1
);
$obj->updateData("tbl_customer",$info_update_total,"where id=$url_val");
//tbl_customer
?>