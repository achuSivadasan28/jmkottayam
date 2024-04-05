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
if(isset($_SESSION['nurse_login_id'])){
$login_id = $_SESSION['nurse_login_id'];
$staff_role = $_SESSION['nurse_role'];
$staff_unique_code = $_SESSION['nurse_unique_code'];
if($staff_role == 'nurse'){
$api_key_value = $_SESSION['api_key_value_nurse'];
$staff_unique_code = $_SESSION['nurse_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);

	//echo $check_security;exit();
if($check_security == 1){
	$url_val = $_POST['url_val'];
	$select_dite_plan = $obj->selectData("diet","tbl_diet_followed","where appointment_id=$url_val and status!=0");
	if(mysqli_num_rows($select_dite_plan)>0){
		$x = 0;
		$response_arr[0]['dite'][0]['dite_data_status'] = 1;
		while($select_dite_plan_row = mysqli_fetch_array($select_dite_plan)){
			$response_arr[0]['dite'][$x]['dite_data'] = $select_dite_plan_row['diet'];
			$x++;
		}
	}else{
		$response_arr[0]['dite'][0]['dite_data_status'] = 0;
	}
	
	$select_food_data = $obj->selectData("foods_to_be_avoided","tbl_foods_avoid","where appointment_id=$url_val and status!=0");
	if(mysqli_num_rows($select_food_data)>0){
		$x1 = 0;
		$response_arr[0]['food'][0]['food_data_status'] = 1;
		while($select_food_data_row = mysqli_fetch_array($select_food_data)){
			$response_arr[0]['food'][$x1]['food_data'] = $select_food_data_row['foods_to_be_avoided'];
			$x1++;
		}
	}else{
		$response_arr[0]['food'][0]['food_data_status'] = 0;
	}
	
	$select_dite_details = $obj->selectData("diet_no_of_days,dite_remark,main_remark","tbl_appointment","where id=$url_val and status!=0");
	if(mysqli_num_rows($select_dite_details)>0){
		while($select_dite_details_row = mysqli_fetch_array($select_dite_details)){
			$response_arr[0]['diet_no_of_days'] = $select_dite_details_row['diet_no_of_days'];
			$response_arr[0]['dite_remark'] = $select_dite_details_row['dite_remark'];
			$response_arr[0]['main_remark'] = $select_dite_details_row['main_remark'];
		}
	}
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