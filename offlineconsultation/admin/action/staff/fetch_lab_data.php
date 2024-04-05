<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
$staff_id = $_POST['val'];
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
	$select_all_branch = $obj->selectData("id,staff_name,staff_phone,staff_email,branch_id","tbl_lab_staff","where id=$staff_id and  status!=0 ORDER BY id DESC");
	if(mysqli_num_rows($select_all_branch)>0){
		$x = 0;
		$response_arr[0]['data_status'] = 1;
		while($select_all_branch_row = mysqli_fetch_array($select_all_branch)){
			$response_arr[$x]['id'] = $select_all_branch_row['id'];
			$response_arr[$x]['staff_name'] = $select_all_branch_row['staff_name'];
			$response_arr[$x]['staff_phone'] = $select_all_branch_row['staff_phone'];
			$response_arr[$x]['staff_email'] = $select_all_branch_row['staff_email'];
			$response_arr[$x]['branch_id'] = $select_all_branch_row['branch_id'];
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