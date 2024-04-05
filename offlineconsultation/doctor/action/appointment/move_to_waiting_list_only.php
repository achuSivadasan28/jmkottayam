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
$api_key_value = $_SESSION['api_key_value_doctor'];
$staff_unique_code = $_SESSION['doctor_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);

	//echo $check_security;exit();
if($check_security == 1){
	$data_id = $_POST['data_id'];
	$branch = $_POST['watting_branch_id'];
	require_once '../../../_class_branch/query_branch.php';
	$obj_branch = new query_branch();
	$update_appointment = array(
		"appointment_status" => 1
	);
	$obj->updateData("tbl_appointment",$update_appointment,"where id=$data_id");
	$check_cross_branch = $obj->selectData("real_branch_id,branch_id","tbl_appointment","where id=$data_id");
	if(mysqli_num_rows($check_cross_branch)>0){
		$check_cross_branch_row = mysqli_fetch_array($check_cross_branch);
		if($check_cross_branch_row['real_branch_id'] != $check_cross_branch_row['branch_id']){
		$update_appointment = array(
			"appointment_status" => 1
		);
		$obj->updateData("tbl_appointment",$update_appointment,"where cross_appointment_id=$data_id");
		}
	}
	
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';

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