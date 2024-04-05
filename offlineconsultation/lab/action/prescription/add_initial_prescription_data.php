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
	$appointment_id = $_POST['appointment_id'];
	$remark_data = $_POST['remark_data'];
	$patient_id = 0;
	$select_patient_id = $obj->selectData("patient_id","tbl_appointment","where id=$appointment_id and status!=0");
	if(mysqli_num_rows($select_patient_id)>0){
		while($select_patient_id_row = mysqli_fetch_array($select_patient_id)){
			$patient_id = $select_patient_id_row['patient_id'];
		}
	}
	$info_prescription = array(
		"appointment_id" => $appointment_id,
		"patient_id" => $patient_id,
		"remark" => $remark_data,
		"prescriptions_added_date" => $days,
		"prescriptions_added_time" => $times,
		"status" => 1
	);
	$obj->insertData("tbl_prescriptions",$info_prescription);
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