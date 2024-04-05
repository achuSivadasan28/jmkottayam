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
$apmnt_id = $_POST['apmnt_id'];
$check_data = $obj->selectData("treatment_fee_status","tbl_appointment","where id=$apmnt_id");
if(mysqli_num_rows($check_data)>0){
	$check_data_row = mysqli_fetch_array($check_data);
	$treatment_fee_status = $check_data_row['treatment_fee_status'];
	echo $treatment_fee_status;
}
?>