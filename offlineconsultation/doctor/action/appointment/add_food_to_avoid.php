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
if(isset($_SESSION['doctor_login_id'])){
$login_id = $_SESSION['doctor_login_id'];
$staff_role = $_SESSION['doctor_role'];
$staff_unique_code = $_SESSION['doctor_unique_code'];
if($staff_role == 'doctor'){
	$response_arr[0]['status'] = 1;
	$dite_detail = $_POST['new_food_to_avoid'];
	$check_test_exist = $obj->selectData("id","tbl_food","where food_to_avoid='$dite_detail' and status!=0");
	if(mysqli_num_rows($check_test_exist)>0){
		$response_arr[0]['data_exist'] = 1;	
		$response_arr[0]['data_exist_Msg'] = $dite_detail." alreday exist!";	
	}else{
		$response_arr[0]['data_exist'] = 0;
		$info_add_data = array(
			"food_to_avoid" => $dite_detail,
			"added_date" => $days,
			"added_time" => $times,
			"status" => 1
		);
		$obj->insertData("tbl_food",$info_add_data);
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