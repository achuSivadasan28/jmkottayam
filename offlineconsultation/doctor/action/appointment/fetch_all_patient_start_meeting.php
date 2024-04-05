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
$times=date('h:i:s');
$c_year = date('Y');
$url_val = $_POST['url_val'];
if(isset($_SESSION['doctor_login_id'])){
	$login_id = $_SESSION['doctor_login_id'];
	$select_patient_start_meeting = $obj->selectData("id,patient_id,meeting_click_time","tbl_appointment","where doctor_id=$login_id and status!=0 and appointment_status=0 and online_conformation_status=1 and meeting_click_status=1 and meeting_click_date='$days' and id!=$url_val and meeting_close_status=0");
	if(mysqli_num_rows($select_patient_start_meeting)>0){
		$x = 0;
		while($select_patient_start_meeting_row = mysqli_fetch_array($select_patient_start_meeting)){
			$id = $select_patient_start_meeting_row['id'];
			$patient_id = $select_patient_start_meeting_row['patient_id'];
			$meeting_click_time = $select_patient_start_meeting_row['meeting_click_time'];
			$times_1 = date_create($times);
			$dateTimeObject1 = date_create($meeting_click_time); 
			$dateTimeObject2 = date_create($times); 
			$interval=date_diff($dateTimeObject1,$dateTimeObject2);
			$minutes = $interval->days * 24 * 60;
			$minutes += $interval->h * 60;
			$minutes += $interval->i;
			if($minutes<=5){
			$select_patient_data = $obj->selectData("name","tbl_patient","where id=$patient_id and status!=0");
			if(mysqli_num_rows($select_patient_data)>0){
				$select_patient_data_row = mysqli_fetch_array($select_patient_data);
				$name = $select_patient_data_row['name'];
				$response_arr[$x]['name'] = $name;
				$response_arr[$x]['id'] = $id;
			}
				$x++;
			}
		}
	}
}
echo json_encode($response_arr);
?>