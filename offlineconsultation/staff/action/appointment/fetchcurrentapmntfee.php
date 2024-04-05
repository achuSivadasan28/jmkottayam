<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$days1 = date('Y-m-d');
$times=date('h:i:s A');
if(isset($_SESSION['staff_login_id'])){
$login_id = $_SESSION['staff_login_id'];
$staff_role = $_SESSION['staff_role'];
$staff_unique_code = $_SESSION['staff_unique_code'];
if($staff_role == 'staff'){
$api_key_value = $_SESSION['api_key_value_staff'];
$staff_unique_code = $_SESSION['staff_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);
	//echo $check_security;exit();
if($check_security == 1){
	$c_visit = $_POST['current_visit'];
	$current_visit = $c_visit+1;
	
	$visit_limit = 0;
	$date_limit = 0;
	$select_add_fee_date_limit = $obj->selectData("visit_limit,appointment_fee,nr","tbl_appointment_fee","where status=1");
	if(mysqli_num_rows($select_add_fee_date_limit)>0){
		while($select_add_fee_date_limit_row = mysqli_fetch_array($select_add_fee_date_limit)){
			$visit_limit = $select_add_fee_date_limit_row['visit_limit'];
			$date_limit = $select_add_fee_date_limit_row['date_limit'];
			$appointment_fee=$select_add_fee_date_limit_row['appointment_fee'];
			$nr=$select_add_fee_date_limit_row['nr'];
		}
	}
	
	
	if($current_visit == 0){
		
	$response_arr[0]['appointmentfee'] =$appointment_fee;	
	}
	else if($current_visit <= $visit_limit){
	
	$response_arr[0]['appointmentfee'] = 0;
		
	}else if($current_visit > $visit_limit){
		
   $response_arr[0]['appointmentfee'] = $nr;
		
	}
	
	
	
	
	
	
}
}
}
echo json_encode($response_arr);
?>