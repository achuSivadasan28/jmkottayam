<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
require_once '../../../_class_common/query_common.php';
$response_arr = array();
$obj=new query();
$obj_common=new query_common();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$c_year = date('Y');
$curr_year = date('y');
$real_branch_id = 5;
if(isset($_SESSION['doctor_login_id'])){
$login_id = $_SESSION['doctor_login_id'];
$doctor_role = $_SESSION['doctor_role'];
$doctor_unique_code = $_SESSION['doctor_unique_code'];
if($doctor_role == 'doctor'){
$api_key_value = $_SESSION['api_key_value_doctor'];
$doctor_unique_code = $_SESSION['doctor_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$doctor_unique_code);
$branch = 5;
require_once '../../../_class_branch/query_branch.php';
$obj_branch = new query_branch();
	//echo $check_security;exit();
if($check_security == 1){

	$select_doctor_list = $obj_branch->selectData("doctor_name,login_id","tbl_doctor inner join tbl_login on tbl_login.id = tbl_doctor.login_id","where tbl_doctor.status != 0 and tbl_login.role='cheaf_doctor' ");
	//echo $select_doctor_list;exit();
	$x = 0;
	if(mysqli_num_rows($select_doctor_list)>0){
		while($select_doctor_list_rows = mysqli_fetch_assoc($select_doctor_list)){
			$response_arr[$x]['id'] = $select_doctor_list_rows['login_id'];
			$response_arr[$x]['doctor_name'] = $select_doctor_list_rows['doctor_name'];
			$x++;
		}
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
?>
	