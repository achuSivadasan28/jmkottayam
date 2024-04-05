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
if(isset($_SESSION['staff_login_id'])){
$login_id = $_SESSION['staff_login_id'];
$staff_role = $_SESSION['staff_role'];
$staff_unique_code = $_SESSION['staff_unique_code'];
if($staff_role == 'treatment_staff'){
$api_key_value = $_SESSION['api_key_value_staff'];
$staff_unique_code = $_SESSION['staff_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);

	//echo $check_security;exit();
if($check_security == 1){
	$prescription_id = $_POST['prescription_id'];
	$info_update_p = array(
		"status" => 0
	);
	$obj->updateData("tbl_prescription_medicine_data",$info_update_p,"where id=$prescription_id");
	
	$select_prescription_id = $obj->selectData("prescription_id","tbl_prescription_medicine_data","where id=$prescription_id");
	if(mysqli_num_rows($select_prescription_id)>0){
		while($select_prescription_id_row = mysqli_fetch_array($select_prescription_id)){
			$prescription_id_pk = $select_prescription_id_row['prescription_id'];
			$check_pres = $obj->selectData("id","tbl_prescription_medicine_data","where prescription_id=$prescription_id_pk and status!=0");
			if(mysqli_num_rows($check_pres) == 0){
				$info_pres_update = array(
					"status" => 0
				);
				$obj->updateData("tbl_prescriptions",$info_pres_update,"where id=$prescription_id_pk");
			}
			$select_patient_id = $obj->selectData("patient_id","tbl_prescriptions","where id=$prescription_id_pk");
			if(mysqli_num_rows($select_patient_id)>0){
				while($select_patient_id_row = mysqli_fetch_array($select_patient_id)){
					$patient_id = $select_patient_id_row['patient_id'];
					$patient_unique_id = $obj->selectData("unique_id","tbl_patient","where id=$patient_id");
					if(mysqli_num_rows($patient_unique_id)>0){
						$patient_unique_id_row = mysqli_fetch_array($patient_unique_id);
						$response_arr[0]['unique_id'] = $patient_unique_id_row['unique_id'];
					}
				}
			}
		}
	}
	//tbl_prescription_medicine_data
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



function check_doctor_time_limit($time_slot,$obj){
	$total_num_slot = 0;
	$select_time_slot_id = $obj->selectData("time_slot_id","tbl_doctor_appointment_slot","where id=$time_slot and status!=0");
	if(mysqli_num_rows($select_time_slot_id)>0){
		$select_time_slot_id_row = mysqli_fetch_array($select_time_slot_id);
		$time_solot_id = $select_time_slot_id_row['time_slot_id'];
		$select_max_appointments = $obj->selectData("total_num_slot","tbl_appointment_slot","where id=$time_solot_id and status!=0");
		if(mysqli_num_rows($select_max_appointments)){
			$select_max_appointments_row = mysqli_fetch_array($select_max_appointments);
			$total_num_slot = $select_max_appointments_row['total_num_slot'];
			
		}
	}
	return $total_num_slot;
}

function check_total_appointments($date,$doctor_data,$time_slot,$obj){
	$total_num_appointment = 0;
	$check_total_appointments_data = $obj->selectData("count(id) as id","tbl_appointment","where doctor_id=$doctor_data and appointment_date='$date' and appointment_time_slot_id=$time_slot and status!=0");
	if(mysqli_num_rows($check_total_appointments_data)>0){
		$check_total_appointments_row = mysqli_fetch_array($check_total_appointments_data);
		if($check_total_appointments_row['id'] != null){
			$total_num_appointment  = $check_total_appointments_row['id'];
		}
	}
	return $total_num_appointment;
}
?>