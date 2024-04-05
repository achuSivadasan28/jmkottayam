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
	$medicalTextarea = $_POST['medicalTextarea'];
	$patient_id = $_POST['patient_id'];
	$data_id = $_POST['data_id'];
	$medical_brnach_id = $_POST['medical_brnach_id'];
	$branch = $medical_brnach_id;
	require_once '../../../_class_branch/query_branch.php';
	$obj_branch = new query_branch();
	if($data_id == 0){
		if($medicalTextarea != ''){
	$info_comment = array(
		"patient_id" => $patient_id,
		"comment" => $medicalTextarea,
		"added_date" => $days,
		"added_time" => $times,
		"added_by" => $login_id,
		"status" => 1
	);
	//$obj_branch->insertData("tbl_medical_history",$info_comment);
		}
	}else{
		if($medicalTextarea == ''){
			$info_comment = array(
				"status" => 0,
			);
			//$obj_branch->updateData("tbl_medical_history",$info_comment,"where id=$data_id");
		}else{
			$info_comment = array(
				"dite_remark" => $medicalTextarea,
			);
			$obj_branch->updateData("tbl_appointment",$info_comment,"where id=$data_id");
			$select_patient_id = $obj->selectData("patient_id","tbl_appointment","where id=$data_id");
			if(mysqli_num_rows($select_patient_id)>0){
				$select_patient_id_row = mysqli_fetch_array($select_patient_id);
				$response_arr[0]['patient_id'] = $select_patient_id_row['patient_id'];
			}
		}
	}
	//tbl_comments
	$response_arr[0]['select_patient_id'] = $select_patient_id;
	//tbl_prescriptions
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