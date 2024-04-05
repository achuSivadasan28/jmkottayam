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
	$staff_name = $_POST['staff_name'];
	$staff_phn = $_POST['staff_phn'];
	$staff_email = $_POST['staff_email'];
	$staff_branch = $_POST['staff_branch'];
	$val = $_POST['val'];
	$login_data_1 = 0;
	$select_log_id_1 = $obj->selectData("login_id","tbl_nurse","where id=$val");
	if(mysqli_num_rows($select_log_id_1)>0){
		$select_log_id_1_row = mysqli_fetch_array($select_log_id_1);
		$login_data_1 = $select_log_id_1_row['login_id'];
	}
	$email_result = validate_email($staff_email,$login_data_1,$obj);
	$phn_result = validate_phn($staff_phn,$login_data_1,$obj);
	if($email_result != 1 and $phn_result != 1){
	
	$info_staff = array(
		"staff_name" => $staff_name,
		"staff_phone" => $staff_phn,
		"staff_email" => $staff_email,
		"branch_id" => $staff_branch,
	);
	$obj->updateData("tbl_nurse",$info_staff,"where id=$val");
	$select_log_id = $obj->selectData("login_id","tbl_nurse","where id=$val");
	if(mysqli_num_rows($select_log_id)>0){
		while($select_log_id_row = mysqli_fetch_array($select_log_id)){
			$login_id_data = $select_log_id_row['login_id'];
			$update_log_data = array(
				"user_name" => $staff_email,
				"phone_number" => $staff_phn,
			);
			$obj->updateData("tbl_login",$update_log_data,"where id=$login_id_data");
			//$login_id_data
		}
	}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
	}else{
	$response_arr[0]['status'] = 2;
	$response_arr[0]['phn_error'] = '';
	$response_arr[0]['email_error'] = '';
	if($phn_result == 1){
		$response_arr[0]['phn_error'] = 'Phone Number Already Exist!';
	}
	if($email_result == 1){
		$response_arr[0]['email_error'] = 'Email Already Exist!';
	}
	$response_arr[0]['msg'] = 'Duplication Occurs';
	}
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

	function validate_phn($phone_no,$val,$obj){
		$phn_res = 1;
		$check_phn = $obj->selectData("id","tbl_login","where phone_number='$phone_no' and status!=0 and id != $val");
		if(mysqli_num_rows($check_phn)>0){
			$phn_res = 1;
		}else{
			$phn_res = 0;
		}
		return $phn_res;
	}
	function validate_email($email,$val,$obj){
		$email_res = 1;
		$check_email = $obj->selectData("id","tbl_login","where user_name='$email' and status!=0 and id != $val");
		if(mysqli_num_rows($check_email)>0){
			$email_res = 1;
		}else{
			$email_res = 0;
		}
		return $email_res;
	}
?>