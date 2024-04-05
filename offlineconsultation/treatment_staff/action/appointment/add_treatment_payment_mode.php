<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$c_days=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');
$payment_type = $_POST['payment_type'];
$amt = $_POST['amt'];
$id = $_POST['id'];
$branch = $_POST['invoice_branch'];
require_once '../../../_class_branch/query_branch.php';
$obj_branch = new query_branch();
//tbl_treatment_payment_mode
$info_data = array(
	"invoice_id" => $id,
	"payment_type" => $payment_type,
	"amount" => $amt,
	"status" => 1
);
$obj->insertData("tbl_treatment_payment_mode",$info_data);
?>