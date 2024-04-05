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
$id = $_POST['id'];
$select_total_amount_sum = $obj->selectData("sum(amount) as amount","tbl_treatment_invoice_details","where invoice_id=$id and status!=0");
if(mysqli_num_rows($select_total_amount_sum)>0){
	$select_total_amount_sum_row = mysqli_fetch_array($select_total_amount_sum);
	if($select_total_amount_sum_row['amount'] != null){
		$total_amt = $select_total_amount_sum_row['amount'];
	}else{
		$total_amt = 0;
	}
	$info_data = array(
		"total_amt" => $total_amt
	);
	$obj->updateData("tbl_treatment_invoice",$info_data,"where id=$id");
	//tbl_treatment_invoice
}
echo json_encode($response_arr);
?>