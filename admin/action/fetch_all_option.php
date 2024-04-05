<?php
session_start();
$adminLogId = $_SESSION['adminLogId'];
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$payment_val = $_POST['payment_val'];
$days_time = $days.' '.$times;
$info_data = array(
	"payment_option" => $payment_val,
	"added_date_time" => $days_time,
	"status" => 1
);
$obj->insertData("tbl_payment_option",$info_data);
//tbl_payment_option
?>