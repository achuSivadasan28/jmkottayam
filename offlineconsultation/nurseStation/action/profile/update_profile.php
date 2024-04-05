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
	$doctor_name = $_POST['doctor_name'];
	$phn_no = $_POST['phn_no'];
	$email = $_POST['email'];
	$propic = $_POST['propic'];
	$check_num_exist = 0;
	$check_email_exist = 0;
	$check_phn = $obj->selectData("id","tbl_doctor","where phone_no='$phn_no' and status!=0 and login_id!=$login_id");
	if(mysqli_num_rows($check_phn)>0){
		$check_num_exist = 1;
	}
	$check_email = $obj->selectData("id","tbl_doctor","where email='$email' and status!=0 and login_id!=$login_id");
	if(mysqli_num_rows($check_email)>0){
		$check_email_exist = 1;
	}
	if($check_num_exist != 1 and $check_email_exist!=1){
	$info_update_pro = array(
		"doctor_name" => $doctor_name,
		"phone_no" => $phn_no,
		"email" => $email,
		"proPic" => $propic,
	);
	$obj->updateData("tbl_doctor",$info_update_pro,"where login_id=$login_id");
	$info_update_login = array(
		"user_name" => $email
	);
	$obj->updateData("tbl_login",$info_update_login,"where id=$login_id");
	//tbl_doctor
		$response_arr[0]['error_status'] = 1;
	}else{
		$response_arr[0]['error_status'] = 0;
		if($check_num_exist == 1){
			$response_arr[0]['phn_status'] = 1;
		}else{
			$response_arr[0]['phn_status'] = 0;
		}
		if($check_email_exist == 1){
			$response_arr[0]['mail_status'] = 1;
		}else{
			$response_arr[0]['mail_status'] = 0;
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