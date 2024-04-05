<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
if(isset($_SESSION['admin_login_id'])){
$login_id = $_SESSION['admin_login_id'];
$admin_role = $_SESSION['admin_role'];
$admin_unique_code = $_SESSION['admin_unique_code'];
if($admin_role == 'admin'){
$api_key_value = $_SESSION['api_key_value'];
$admin_unique_code = $_SESSION['admin_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$admin_unique_code);
	//echo $check_security;exit();
if($check_security == 1){
$select_all_appointment_fee = $obj->selectData("appointment_fee,status,added_date,visit_limit,date_limit,nr,nr_date_limit","tbl_appointment_fee"," ORDER BY id DESC");
	if(mysqli_num_rows($select_all_appointment_fee)>0){
		$response_arr[0]['data_status'] = 1;
		$x = 0;
		while($select_all_appointment_fee_row = mysqli_fetch_array($select_all_appointment_fee)){
			$response_arr[$x]['appointment_fee'] = $select_all_appointment_fee_row['appointment_fee'];
			$response_arr[$x]['visit_limit'] = $select_all_appointment_fee_row['visit_limit'];
			$response_arr[$x]['date_limit'] = $select_all_appointment_fee_row['date_limit'];
			$response_arr[$x]['nr'] = $select_all_appointment_fee_row['nr'];
			$response_arr[$x]['nr_date_limit'] = $select_all_appointment_fee_row['nr_date_limit'];
			$response_arr[$x]['status'] = $select_all_appointment_fee_row['status'];
			$response_arr[$x]['added_date'] = $select_all_appointment_fee_row['added_date'];
			$x++;
		}
	}else{
		$response_arr[0]['data_status'] = 0;
	}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
	//tbl_branch
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