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
	$staff_id = $_POST['staff_id'];
	$info_staff_remove = array(
		"status" => 0
	);
	$update_data = $obj->updateData("tbl_staff",$info_staff_remove,"where id=$staff_id");
	$select_log_id = $obj->selectData("login_id","tbl_staff","where id=$staff_id");
	if(mysqli_num_rows($select_log_id)>0){
		while($select_log_id_row = mysqli_fetch_array($select_log_id)){
			$login_id_data = $select_log_id_row['login_id'];
			$update_log_data = array(
				"status" => 0
			);
			$obj->updateData("tbl_login",$update_log_data,"where id=$login_id_data");
			//$login_id_data
		}
	}
	//tbl_branch
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