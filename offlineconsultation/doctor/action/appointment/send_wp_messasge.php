<?php
require_once '../../../_class/query.php';
$obj = new query();
$response_arr = array();
$appointment_id = $_POST['appointment_id'];

$select_appointment_data = $obj->selectData("online_confirm_date,online_confirm_time,patient_id,doctor_id","tbl_appointment","where id = $appointment_id");
//echo $select_appointment_data;exit();
if(mysqli_num_rows($select_appointment_data)){
	$select_appointment_row = mysqli_fetch_assoc($select_appointment_data);
	$patient_id = $select_appointment_row['patient_id'];
	$online_confirm_date = $select_appointment_row['online_confirm_date'];
	$online_confirm_time = $select_appointment_row['online_confirm_time'];
	$meeting_link = $select_appointment_row['google_meet'];
	$doctor_id = $select_appointment_row['doctor_id'];

	$select_patient_data = $obj->selectData("phone","tbl_patient","where id = $patient_id");
	if(mysqli_num_rows($select_patient_data)){
		$select_patient_rows = mysqli_fetch_assoc($select_patient_data);
		$phone = $select_patient_rows['phone'];
		$name = $select_patient_rows['name'];
	}

	$select_doctor_details = $obj->selectData("doctor_name","tbl_doctor","where login_id = $doctor_id");
	//echo $select_doctor_details;exit();
	if(mysqli_num_rows($select_doctor_details)){
		$select_doctor_details_rows = mysqli_fetch_assoc($select_doctor_details);
		$doctor_name = $select_doctor_details_rows['doctor_name'];
		
	}
}

try{
	$url = 'https://api.kaleyra.io/v1/HXIN1718319102IN/messages';

	// Form data to be sent in the request
	$data = [
		'to' => '918137868230',
		'from' => '918111869977',
		'channel' => 'whatsapp',
		'type' => 'template',
		'template_name' => 'appointmentscheduled',
		'param_header' => 'Achu',
		'param_1' => '12-12-2000',
		'param_2' => '10:30 PM',
		'param_3' => 'Achu',
		'param_4' => '918137868230',
	];

	// API key in the request header
	$headers = [
		'api-key: Abee8be961d4edf4c2cfff0ab886f5540'
	];

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

	$response = curl_exec($ch);

	if (curl_errno($ch)) {
		echo 'cURL error: ' . curl_error($ch);
	} else {
		echo $response;
	}

	curl_close($ch);
}catch(Exception $e){
	$response_arr[0]['error'] = $e;
}
$response_arr[0]['phn'] = $phone;
$response_arr[0]['date'] = $online_confirm_date;
$response_arr[0]['time'] = $online_confirm_time;
$response_arr[0]['doctor'] = $doctor_name;

echo json_encode($response_arr);
?>
