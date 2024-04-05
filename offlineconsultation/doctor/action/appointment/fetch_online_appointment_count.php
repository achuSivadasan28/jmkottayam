<?php
session_start();
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$Cdays=date('Y-m-d');
$current_Y=date('Y');
$times=date('h:i:s A');
if(isset($_SESSION['doctor_login_id'])){
	$login_id = $_SESSION['doctor_login_id'];
	$select_all_online_appointment = $obj->selectData("count(id) as id","tbl_appointment","where doctor_id=$login_id and status!=0 and appointment_taken_type='online' and online_conformation_status=0");
	//echo $select_all_online_appointment;exit();
	$select_all_online_appointment_row = mysqli_fetch_array($select_all_online_appointment);
	if($select_all_online_appointment_row['id'] != null){
		$response_arr[0]['online_count'] = $select_all_online_appointment_row['id'];
	}else{
		$response_arr[0]['online_count'] = 0;
	}
$select_all_all_online_appointment = $obj->selectData("count(id) as id","tbl_appointment","where doctor_id=$login_id and status!=0 and appointment_taken_type='online'");
	//echo $select_all_online_appointment;exit();
	$select_all_all_online_appointment_row = mysqli_fetch_array($select_all_all_online_appointment);
	if($select_all_all_online_appointment_row['id'] != null){
		$response_arr[0]['all_online_count'] = $select_all_all_online_appointment_row['id'];
	}else{
		$response_arr[0]['all_online_count'] = 0;
	}
	
$select_all_sheduled_online_appointment = $obj->selectData("count(id) as sheduled_id","tbl_appointment","where doctor_id=$login_id and status!=0 and appointment_taken_type='online' and online_conformation_status=1 and online_confirm_date='$Cdays'");
	//echo $select_all_all_online_appointment;exit();
	$select_all_sheduled_online_appointment_row = mysqli_fetch_array($select_all_sheduled_online_appointment);
	if($select_all_sheduled_online_appointment_row['sheduled_id'] != null){
		$response_arr[0]['sheduled_count'] = $select_all_sheduled_online_appointment_row['sheduled_id'];
	}else{
		$response_arr[0]['sheduled_count'] = 0;
	}
}
echo json_encode($response_arr);
?>