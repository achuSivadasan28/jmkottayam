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
	$select_professional_data = $obj->selectData("designation_data,qualification_data,experiance_data,reg_num","tbl_doctor","where login_id=$login_id and status!=0");
	if(mysqli_num_rows($select_professional_data)>0){
		$x = 0;
		while($select_professional_data_row = mysqli_fetch_array($select_professional_data)){
			$response_arr[$x]['designation_data'] = $select_professional_data_row['designation_data'];
			$response_arr[$x]['qualification_data'] = $select_professional_data_row['qualification_data'];
			$response_arr[$x]['experiance_data'] = $select_professional_data_row['experiance_data'];
			$response_arr[$x]['reg_num'] = $select_professional_data_row['reg_num'];
			$x++;
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