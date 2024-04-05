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
	$x = 0;
	$prescription_id = $_POST['prescription_id'];
	$prescription_id_branch_id = $_POST['prescription_id_branch_id'];
	$branch = $prescription_id_branch_id;
	require_once '../../../_class_branch/query_branch.php';
	$obj_branch = new query_branch();
	$select_prescription_details = $obj_branch->selectData("medicine_id,medicine_name,quantity,morning_section,noon_section,evening_section,no_of_day,remark,after_food,befor_food","tbl_prescription_medicine_data","where id=$prescription_id and status !=0");
	if(mysqli_num_rows($select_prescription_details)>0){
		$x1 = 0;
		while($select_prescription_details_row = mysqli_fetch_array($select_prescription_details))		  {
			$response_arr[$x1]['medicine_id'] = $select_prescription_details_row['medicine_id'];
			$response_arr[$x1]['medicine_name'] = $select_prescription_details_row['medicine_name'];
			$response_arr[$x1]['quantity'] = $select_prescription_details_row['quantity'];
			$response_arr[$x1]['morning_section'] = $select_prescription_details_row['morning_section'];
			$response_arr[$x1]['noon_section'] = $select_prescription_details_row['noon_section'];
			$response_arr[$x1]['evening_section'] = $select_prescription_details_row['evening_section'];
			$response_arr[$x1]['no_of_day'] = $select_prescription_details_row['no_of_day'];
			$response_arr[$x1]['remark'] = $select_prescription_details_row['remark'];
			$response_arr[$x1]['after_food'] = $select_prescription_details_row['after_food'];
			$response_arr[$x1]['befor_food'] = $select_prescription_details_row['befor_food'];
			$x1++;
		}
	}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'success';
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