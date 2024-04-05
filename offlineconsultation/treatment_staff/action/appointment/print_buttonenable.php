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
$appintment_id = $_POST['appointment_id'];
	$select_appointment = $obj->selectData("id","tbl_appointment","where appointment_status =2 and id='$appintment_id'");
	if(mysqli_num_rows($select_appointment)>0){
		
		
		$response_arr[0]['consulted_status'] = 1;
		
	}else{
	
	$response_arr[0]['consulted_status'] = 2;
	}

echo json_encode($response_arr);
?>