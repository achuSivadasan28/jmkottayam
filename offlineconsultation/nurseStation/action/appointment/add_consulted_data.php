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
	$patient_id = $_POST['patient_id'];
	$food_avoided_plan = $_POST['food_avoided_plan'];
	$diet_plan = $_POST['diet_plan'];
	$food_status = array(
			"status" => 0
		);
			$obj->updateData("tbl_foods_avoid",$food_status,"where appointment_id=$patient_id");
	
	$diet_status = array(
			"status" => 0
		);
			$obj->updateData("tbl_diet_followed",$diet_status,"where appointment_id=$patient_id");
	$info_update_counsulted = array(
		"appointment_status" => 2,
		"diet_no_of_days" => $_POST['no_of_days'],
		"dite_remark" => $_POST['food_remark'],
		"main_remark" =>  $_POST['main_remark'],
		"consulted_by" => $login_id,
	);
	$pending_data = 0;
	$obj->updateData("tbl_appointment",$info_update_counsulted,"where id=$patient_id");
	if(sizeof($food_avoided_plan)!=0){
		for($x1=0;$x1<sizeof($food_avoided_plan);$x1++){
		$food_avoided_plan_array_data = array(
			"appointment_id" => $patient_id,
			"foods_to_be_avoided" => $food_avoided_plan[$x1],
			"added_date" => $days,
			"added_time" => $times,
			"status" => 1
		);
			$obj->insertData("tbl_foods_avoid",$food_avoided_plan_array_data);
		}
		//tbl_foods_avoid
	}
	
		if(sizeof($diet_plan)!=0){
		for($x2=0;$x2<sizeof($diet_plan);$x2++){
		$diet_plan_array_data = array(
			"appointment_id" => $patient_id,
			"diet" => $diet_plan[$x2],
			"added_date" => $days,
			"added_time" => $times,
			"status" => 1
		);
			$obj->insertData("tbl_diet_followed",$diet_plan_array_data);
		}
		//tbl_foods_avoid
	}
	$select_watting_pending_count = $obj->selectData("count(tbl_appointment.appointment_status) as watting_list","tbl_appointment inner join tbl_patient on tbl_appointment.patient_id=tbl_patient.id","where tbl_appointment.doctor_id='$login_id' and tbl_appointment.appointment_date='$c_days' and tbl_appointment.status!=0 and tbl_appointment.appointment_status=1");
	$select_watting_pending_count_row = mysqli_fetch_array($select_watting_pending_count);
	if($select_watting_pending_count_row['watting_list'] != null){
		$pending_data = $select_watting_pending_count_row['watting_list'];
	}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
	$response_arr[0]['pending_count'] = $pending_data;

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