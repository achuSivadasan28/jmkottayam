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
	$name = $_POST['name'];
	$number = $_POST['number'];
	$address = $_POST['address'];
	$place = $_POST['place'];
	$age = $_POST['age'];
	$gender_data = $_POST['gender_data'];
	$doctor_data = $login_id;
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
	$appointment_num = check_total_appointments($date,$doctor_data,$time_slot,$obj);
	if($total_num_slot!=0){
	if($total_num_slot > $appointment_num){
	if($unique_id == '0'){
		$unique_No = '';
		$select_max_code = $obj->selectData("no","tbl_patient","ORDER BY id DESC limit 1");
		if(mysqli_num_rows($select_max_code)>0){
			while($select_max_code_row = mysqli_fetch_array($select_max_code)){
				$unique_No = $select_max_code_row['no'];
			}
			$unique_No += 1;
		}else{
			$unique_No = 1;
		}
		$unique_No_id = "JMW/".$c_year."/".$unique_No;
		$unique_id = $unique_No_id;
	$info_insert_data = array(
		"code" => "JMW",
		"year" => $c_years,
		"no" => $unique_No,
		"unique_id" => $unique_No_id,
		"name" => $name,
		"phone" => $number,
		"address" => $address,
		"place" => $place,
		"age" => $age,
		"gender" => $gender_data,
		"added_date" => $days,
		"added_time" => $times,
		"added_by" => $login_id,
		"status" => 1,
		"online_account_status" => 0
	);
		$obj->insertData("tbl_patient",$info_insert_data);
		
	}else{
		$check_user_exist = $obj->selectData("id","tbl_patient","where name='$name' and phone='$number' and status=1");
		$info_insert_data = '';
		if(mysqli_num_rows($check_user_exist)>0){
			if($gender_data != ''){
	$info_insert_data = array(
		"name" => $name,
		"phone" => $number,
		"address" => $address,
		"place" => $place,
		"age" => $age,
		"gender" => $gender_data,
	);
		}else{
	$info_insert_data = array(
		"name" => $name,
		"phone" => $number,
		"address" => $address,
		"place" => $place,
		"age" => $age,
	);
		}
		$obj->updateData("tbl_patient",$info_insert_data,"where unique_id='$unique_id'");
		}else{		
			if($gender_data != ''){
	$info_insert_data = array(
		"name" => $name,
		"phone" => $number,
		"address" => $address,
		"place" => $place,
		"age" => $age,
		"gender" => $gender_data,
	);
		}else{
	$info_insert_data = array(
		"name" => $name,
		"phone" => $number,
		"address" => $address,
		"place" => $place,
		"age" => $age,
	);
		}
		$obj->updateData("tbl_patient",$info_insert_data,"where unique_id='$unique_id'");
		}
		
		
	}
	
	//add appointment
	$patient_id = 0;
	$select_patient_id = $obj->selectData("id","tbl_patient","where unique_id='$unique_id'");
	if(mysqli_num_rows($select_patient_id)>0){
		while($select_patient_id_row = mysqli_fetch_array($select_patient_id)){
			$patient_id = $select_patient_id_row['id'];
			
		}
	}
	$select_admission_fee = $obj->selectData("appointment_fee","tbl_appointment_fee","where status=1");
	$select_admission_fee_row = mysqli_fetch_array($select_admission_fee);
	$admission_fee = $select_admission_fee_row['appointment_fee'];
	$token_num = 0;
	$select_last_num_this_date = $obj->selectData("max(appointment_number) as appointment_number","tbl_appointment","where appointment_date='$date' and status!=0 and doctor_id=$doctor_data");
	$select_last_num_this_date_row = mysqli_fetch_array($select_last_num_this_date);
	if($select_last_num_this_date_row['appointment_number'] != null){
		$token_num = $select_last_num_this_date_row['appointment_number'];
	}
	$token_num +=1;
		
	$info_add_appointment = array(
		"patient_id" => $patient_id,
		"doctor_id" =>$doctor_data,
		"appointment_date" => $date,
		"appointment_taken_type" => "Offline",
		"appointment_year" => $c_year,
		"height" => $height,
		"weight" => $weight,
		"blood_pressure" => $blood_pressure,
		"allergies_if_any" => $allergies_if_any,
		"current_medication" => $current_medication,
		"present_Illness" => $present_illness,
		"any_surgeries" => $any_surgeries,
		"any_metal_Implantation" => $any_metal_lmplantation,
		"appointment_number" => $token_num,
		"appointment_taken_date" => $days,
		"appointment_taken_time" => $times,
		"appointment_taken_by" => 'doctor',
		"appointment_taken_id" => $login_id,
		"appointment_fee" => $admission_fee,
		"appointment_fee_type" => 'Offline',
		"appointment_fee_status" => 1,
		"appointment_time_slot_id" => $time_slot,
		"status" => 1,
		"first_visit" => $fVisit,
	);
	$obj->insertData("tbl_appointment",$info_add_appointment);
		//$sms_result = appointment_success_sms($number,$name,$token_num,$date);
	//add surgical history
		if($any_surgeries != ''){
			$info_surgical_history = array(
				"patient_id" => $unique_id,
				"comment" => $any_surgeries,
				"added_date" => $days,
				"added_time" => $times,
				"added_by" => $login_id,
				"status" => 1
			);
			$obj->insertData("tbl_surgical_history",$info_surgical_history);
		}
		
		//medical history
		if($current_medication != ''){
			$info_medication_history = array(
				"patient_id" => $unique_id,
				"comment" => $any_surgeries,
				"added_date" => $days,
				"added_time" => $times,
				"added_by" => $login_id,
				"status" => 1
			);
			$obj->insertData("tbl_medical_history",$info_medication_history);
		}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
	}else{
	$response_arr[0]['status'] = 2;
	$response_arr[0]['msg'] = 'TimeSlot Not Available';
	}
}else{
	$response_arr[0]['status'] = 2;
	$response_arr[0]['msg'] = 'TimeSlot Error';
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
?>