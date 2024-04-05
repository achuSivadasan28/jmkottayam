<?php
include '../../_class/query.php';
$obj = new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$customer_id = $_POST['customer_id'];
$payment_option = $_POST['payment_option'];
$Recived_amt_in_op = $_POST['Recived_amt_in_op'];
//tbl_payment_recived_type
$info_payment_data = array(
	"customer_id" => $customer_id,
	"payment_option" => $payment_option,
	"amount" => $Recived_amt_in_op,
	"added_date" => $days,
	"added_time" => $times,
	"status" => 1
);
$obj->insertData("tbl_payment_recived_type",$info_payment_data);
?>