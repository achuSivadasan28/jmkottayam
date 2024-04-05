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
if(isset($_SESSION['lab_login_id'])){
$login_id = $_SESSION['lab_login_id'];
$staff_role = $_SESSION['lab_role'];
$staff_unique_code = $_SESSION['lab_unique_code'];
if($staff_role == 'lab'){
$api_key_value = $_SESSION['api_key_value_lab'];
$staff_unique_code = $_SESSION['lab_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);

	//echo $check_security;exit();
if($check_security == 1){
	$appointment_id = $_POST['appointment_id'];
	$medicine_details = $_POST['medicine_details'];
	$quantity_data = $_POST['quantity_data'];
	$morning_data = $_POST['morning_data'];
	$noon_data = $_POST['noon_data'];
	$evening_data = $_POST['evening_data'];
	$no_days = $_POST['no_days'];
	$appointment_id = $_POST['appointment_id'];
	$patient_id_data = $_POST['patient_id_data'];
	$medicine_name = $_POST['medicine_name'];
	$after_food = $_POST['after_food'];
	$befor_food = $_POST['befor_food'];
	$position = $_POST['position'];
	$info_insert_prescription_data = array(
		"prescription_id" => $patient_id_data,
		"medicine_id" => $medicine_details,
		"medicine_name" => $medicine_name,
		"quantity" => $quantity_data,
		"morning_section" => $morning_data,
		"noon_section" => $noon_data,
		"evening_section" => $evening_data,
		"no_of_day" => $no_days,
		"status" => 1,
		"after_food" => $after_food,
		"befor_food" => $befor_food,
		"position_data" => $position,
	);
	$obj->insertData("tbl_prescription_medicine_data",$info_insert_prescription_data);
	//tbl_prescription_medicine_data
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'success';
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Something Went Wrong! Try Again';
}
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Unauthorised login';	
}
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Unauthorised login';
}
echo json_encode($response_arr);

?>