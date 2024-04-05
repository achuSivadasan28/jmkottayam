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
	$oldPwd = $_POST['oldPwd'];
	$passwordinput = $_POST['passwordinput'];
	$confim_pwd = $_POST['confim_pwd'];
	$oldPwd_to_lower = strtolower($oldPwd);
	$oldPwd_to_lower_eny = md5($oldPwd_to_lower);
	$check_old_pwd = $obj->selectData("id","tbl_login","where password='$oldPwd_to_lower_eny' and id=$login_id");
	if(mysqli_num_rows($check_old_pwd)>0){
		$confim_pwd_lower = strtolower($confim_pwd);
		$confim_pwd_lower_eny = md5($confim_pwd_lower);
			$update_pwd = array(
				"password" => $confim_pwd_lower_eny
			);
			$obj->updateData("tbl_login",$update_pwd,"where id=$login_id");
			$response_arr[0]['status'] = 1;
			$response_arr[0]['msg'] = 'Success';
	}else{
			$response_arr[0]['status'] = 0;
			$response_arr[0]['msg'] = 'Password Error';
			$response_arr[0]['passw_error'] = 1;
	}
	//tbl_branch
}else{
	$response_arr[0]['passw_error'] = 0;
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Something Went Wrong! Try Again';
}
}else{
	$response_arr[0]['passw_error'] = 0;
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Unauthorised login';	
}
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Unauthorised login';
}
echo json_encode($response_arr);
?>