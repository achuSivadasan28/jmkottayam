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
$date_arr = [];
	//echo $check_security;exit();
if($check_security == 1){
	$appointment_id = $_POST['appointment_id'];
	$select_appointment_data = $obj->selectData("diet","tbl_diet_followed","where appointment_id=$appointment_id and status!=0");
	if(mysqli_num_rows($select_appointment_data)>0){
		$response_arr[0]['data_status'] = 1;
		$x = 0;
		while($select_appointment_data_row = mysqli_fetch_array($select_appointment_data)){
			$response_arr[$x]['diet'] = $select_appointment_data_row['diet'];
			$x++;
		}
	}else{
		$response_arr[0]['data_status'] = 0;
	}
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