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
if(isset($_SESSION['nurse_login_id'])){
$login_id = $_SESSION['nurse_login_id'];
$staff_role = $_SESSION['nurse_role'];
$staff_unique_code = $_SESSION['nurse_unique_code'];
if($staff_role == 'nurse'){
$api_key_value = $_SESSION['api_key_value_nurse'];
$staff_unique_code = $_SESSION['nurse_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);

	//echo $check_security;exit();
if($check_security == 1){
	$doctor_name = '';
	$branch_name = '';
	$select_doctor_data = $obj->selectData("doctor_name,branch_id,proPic","tbl_doctor","where login_id=$login_id");
	if(mysqli_num_rows($select_doctor_data)>0){
		while($select_doctor_data_row = mysqli_fetch_array($select_doctor_data)){
			$response_arr[0]['proPic'] = $select_doctor_data_row['proPic'];
			$doctor_name = $select_doctor_data_row['doctor_name'];
			$branch_id = $select_doctor_data_row['branch_id'];
			$select_branch_name = $obj->selectData("branch_name","tbl_branch","where id=$branch_id");
			if(mysqli_num_rows($select_branch_name)>0){
				while($select_branch_name_row = mysqli_fetch_array($select_branch_name)){
					$branch_name = $select_branch_name_row['branch_name'];
				}
			}
		}
	}
	$response_arr[0]['doctor_name'] = $doctor_name;
	$response_arr[0]['branch_name'] = $branch_name;
	
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