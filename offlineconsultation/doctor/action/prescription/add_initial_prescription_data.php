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
	$appointment_id = $_POST['appointment_id'];
	$remark_data = $_POST['remark_data'];
	$branch = $_POST['branch_id'];
	require_once '../../../_class_branch/query_branch.php';
	$obj_branch = new query_branch();
	$patient_id = 0;
	$check_cross_branch_status = $obj->selectData("id,branch_id,real_branch_id,patient_id","tbl_appointment","where id=$appointment_id");
	if(mysqli_num_rows($check_cross_branch_status)>0){
		$check_cross_branch_status_row = mysqli_fetch_array($check_cross_branch_status);
		if($check_cross_branch_status_row['branch_id'] == $check_cross_branch_status_row['real_branch_id']){
			$cross_appointment_id = 0;
			$patient_id = $check_cross_branch_status_row['patient_id'];
	$info_prescription = array(
		"appointment_id" => $appointment_id,
		"patient_id" => $patient_id,
		"remark" => $remark_data,
		"prescriptions_added_date" => $days,
		"prescriptions_added_time" => $times,
		"status" => 1
	);
	$obj->insertData("tbl_prescriptions",$info_prescription);//exit();
	$select_prescription_id = $obj->selectData("id","tbl_prescriptions","where appointment_id=$appointment_id and patient_id=$patient_id and status=1");
	if(mysqli_num_rows($select_prescription_id)>0){
		while($select_prescription_id_row = mysqli_fetch_array($select_prescription_id)){
			$select_patient_id = $select_prescription_id_row['id'];
		}
	}
	$response_arr[0]['select_patient_id'] = $select_patient_id;
	//tbl_prescriptions
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'success';
			
		}else{
			$cross_appointment_id = 0;
	$select_patient_id = $obj_branch->selectData("id,patient_id","tbl_appointment","where cross_appointment_id=$appointment_id and status!=0");
	if(mysqli_num_rows($select_patient_id)>0){
		while($select_patient_id_row = mysqli_fetch_array($select_patient_id)){
			$patient_id = $select_patient_id_row['patient_id'];
			$cross_appointment_id = $select_patient_id_row['id'];
		}
	}
	$info_prescription = array(
		"appointment_id" => $cross_appointment_id,
		"patient_id" => $patient_id,
		"remark" => $remark_data,
		"prescriptions_added_date" => $days,
		"prescriptions_added_time" => $times,
		"status" => 1
	);
	$obj_branch->insertData("tbl_prescriptions",$info_prescription);
	$select_prescription_id = $obj_branch->selectData("id","tbl_prescriptions","where appointment_id=$cross_appointment_id and patient_id=$patient_id and status=1");
	if(mysqli_num_rows($select_prescription_id)>0){
		while($select_prescription_id_row = mysqli_fetch_array($select_prescription_id)){
			$select_patient_id = $select_prescription_id_row['id'];
		}
	}
	$response_arr[0]['select_patient_id'] = $select_patient_id;
	//tbl_prescriptions
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'success';
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