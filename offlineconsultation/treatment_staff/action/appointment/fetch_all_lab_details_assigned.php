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
$patitent_id = $_POST['patitent_id'];
$select_appointment = $obj->selectData("id,appointment_id,test_id,test_name,test_price","tbl_add_lab_data","where status!=0 and appointment_id=$patitent_id");
if(mysqli_num_rows($select_appointment)>0){
	$x = 0;
	while($select_appointment_row = mysqli_fetch_array($select_appointment)){
		$response_arr[$x]['id'] = $select_appointment_row['id'];
		$response_arr[$x]['test_name'] = $select_appointment_row['test_name'];
		$response_arr[$x]['test_price'] = $select_appointment_row['test_price'];
		$response_arr[$x]['test_id'] = $select_appointment_row['test_id'];
		$x++;
	}
}
echo json_encode($response_arr);
?>