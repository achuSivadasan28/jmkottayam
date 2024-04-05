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
$c_year = date('Y');
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
	$select_staff_profile_details = $obj->selectData("staff_name,staff_phone,staff_email,branch_id","tbl_staff","where login_id=$login_id and status!=0");
	if(mysqli_num_rows($select_staff_profile_details)>0){
		while($select_staff_profile_details_row = mysqli_fetch_array($select_staff_profile_details)){
			$response_arr[0]['login_id'] = $login_id;
			$response_arr[0]['staff_name'] = $select_staff_profile_details_row['staff_name'];
			$response_arr[0]['staff_phone'] = $select_staff_profile_details_row['staff_phone'];
			$response_arr[0]['staff_email'] = $select_staff_profile_details_row['staff_email'];
			$response_arr[0]['branch_id'] = $select_staff_profile_details_row['branch_id'];
			$branch_id = $select_staff_profile_details_row['branch_id'];
			$select_branch_name = $obj->selectData("branch_name","tbl_branch","where id=$branch_id");
			if(mysqli_num_rows($select_branch_name)>0){
				while($select_branch_name_row = mysqli_fetch_array($select_branch_name)){
					$response_arr[0]['branch_name'] = $select_branch_name_row['branch_name'];
				}
			}
			$response_arr[0]['staff_name'] = $select_staff_profile_details_row['staff_name'];
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