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
$times=date('h:i:s A');
$c_year = date('Y');
if(isset($_SESSION['staff_login_id'])){
$login_id = $_SESSION['staff_login_id'];
$staff_role = $_SESSION['staff_role'];
$staff_unique_code = $_SESSION['staff_unique_code'];
if($staff_role == 'staff'){
$api_key_value = $_SESSION['api_key_value_staff'];
$staff_unique_code = $_SESSION['staff_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);
$url_val = $_POST['url_val'];
	//echo $check_security;exit();
if($check_security == 1){
	$name = $_POST['name'];
	$number = $_POST['number'];
	$address = $_POST['address'];
	$place = $_POST['place'];
	$age = $_POST['age'];
	$gender_data = $_POST['gender_data'];
	$doctor_data = $_POST['doctor_data'];
	$date = $_POST['date'];
	$unique_id = $_POST['unique_id'];
	$time_slot = $_POST['time_slot'];
	$height = $_POST['height'];
	$weight = $_POST['weight'];
	$blood_pressure = $_POST['blood_pressure'];
	$allergies_if_any = $_POST['allergies_if_any'];
	$current_medication = $_POST['current_medication'];
	$present_illness = $_POST['present_illness'];
	$any_surgeries = $_POST['any_surgeries'];
	$any_metal_lmplantation = $_POST['any_metal_lmplantation'];
	$fVisit = $_POST['fVisit'];
	$total_num_slot = check_doctor_time_limit($time_slot,$obj);
	$check_doctor_already_added = check_doctor_allready_added($time_slot,$doctor_data,$url_val,$obj,$date);
	if($check_doctor_already_added == 1){
		$appointment_num = 'same';
	}else{
		$appointment_num = check_total_appointments($date,$doctor_data,$time_slot,$obj);
	}
	$appointment_data = 0;
	if($appointment_num != 'same'){
		if($total_num_slot > $appointment_num){
			$appointment_data = 1;
		}
	}else{
		$appointment_data = 1;
	}
	if($appointment_data == 1){
		$patient_id = '';
		$select_patient_id = $obj->selectData("patient_id","tbl_appointment","where id=$url_val");
		if(mysqli_num_rows($select_patient_id)>0){
			while($select_patient_id_row = mysqli_fetch_array($select_patient_id)){
				$patient_id = $select_patient_id_row['patient_id'];
			}
		
		$info_insert_data = array(
		"name" => $name,
		"phone" => $number,
		"address" => $address,
		"place" => $place,
		"age" => $age,
		"gender" => $gender_data,
	);
		$obj->updateData("tbl_patient",$info_insert_data,"where id=$patient_id");
		
		$info_add_appointment = array(
		"doctor_id" =>$doctor_data,
		"appointment_date" => $date,
		"appointment_year" => $c_year,
		"height" => $height,
		"weight" => $weight,
		"blood_pressure" => $blood_pressure,
		"allergies_if_any" => $allergies_if_any,
		"current_medication" => $current_medication,
		"present_Illness" => $present_illness,
		"any_surgeries" => $any_surgeries,
		"any_metal_Implantation" => $any_metal_lmplantation,
		"appointment_time_slot_id" => $time_slot,
		"updated_date_time" => $days,
		"updated_by" => $login_id,
		"first_visit" => $_POST['fVisit']
	);
		$obj->updateData("tbl_appointment",$info_add_appointment,"where id=$url_val");
		
		$response_arr[0]['status'] = 1;
		$response_arr[0]['msg'] = 'Success';
		}else{
			$response_arr[0]['status'] = 0;
			$response_arr[0]['msg'] = 'Something Went Wrong! Try Again';
		}
	}else{
		$response_arr[0]['status'] = 2;
		$response_arr[0]['msg'] = 'TimeSlot Not Available';
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

function check_doctor_allready_added($time_slot,$doctor_data,$url_val,$obj,$date){
	$result_data = 0;
	$check_doctor = $obj->selectData("id","tbl_appointment","where doctor_id=$doctor_data and appointment_time_slot_id=$time_slot and id=$url_val and appointment_date='$date'");
	if(mysqli_num_rows($check_doctor)>0){
		$result_data = 1;
	}
	return $result_data;
}
?>