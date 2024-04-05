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
	$staff_name = $_POST['staff_name'];
	$staff_phone = $_POST['staff_phone'];
	$branch_data = $_POST['branch_data'];
	$phn_result = validate_phn_num($staff_phone,$obj,$login_id);
	if($phn_result ==1){
	$response_arr[0]['data_status'] = 0;
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Dupilcation Error';
	}else{
		$response_arr[0]['data_status'] = 1;
	$info_array = array(
		"staff_name" => $staff_name,
		"staff_phone" => $staff_phone,
		//"branch_id" => $branch_data
	);
	$obj->updateData("tbl_lab_staff",$info_array,"where login_id=$login_id");
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
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

function validate_phn_num($staff_phone,$obj,$login_id){
	$result = 0;
	$check_phn = $obj->selectData("staff_phone","tbl_staff","where login_id!=$login_id and status!=0 and staff_phone='$staff_phone'");
	if(mysqli_num_rows($check_phn)){
		$result = 1;
	}else{
		$result = 0;
	}
	return $result;
}
?>