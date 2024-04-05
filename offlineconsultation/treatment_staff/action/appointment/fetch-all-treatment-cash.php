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
$response_arr[0]['date'] = $days;
	//echo $check_security;exit();
if($check_security == 1){
	$select_report = $obj->selectData("count(id) as id","tbl_treatment_invoice","where added_date='$days' and status!=0");
	$select_report_row = mysqli_fetch_array($select_report);
	if($select_report_row['id'] != null){
		$response_arr[0]['invoice_count'] = $select_report_row['id'];
	}else{
		$response_arr[0]['invoice_count'] = 0;
	}
	$select_total_amt = $obj->selectData("sum(total_amt) as total_amt","tbl_treatment_invoice","where added_date='$days' and status!=0");
	$select_total_amt_row = mysqli_fetch_array($select_total_amt);
	if($select_total_amt_row['total_amt'] != null){
		$response_arr[0]['total_collection']  = $select_total_amt_row['total_amt'];
	}else{
		$response_arr[0]['total_collection']  = 0;
	}
	//gpay
	$select_total_amt = $obj->selectData("sum(tbl_treatment_payment_mode.amount) as amount","tbl_treatment_invoice inner join tbl_treatment_payment_mode on tbl_treatment_invoice.id=tbl_treatment_payment_mode.invoice_id","where tbl_treatment_invoice.added_date='$days' and tbl_treatment_invoice.status!=0 and tbl_treatment_payment_mode.payment_type=1");
	$select_total_amt_row = mysqli_fetch_array($select_total_amt);
	if($select_total_amt_row['amount'] != null){
		$response_arr[0]['total_collection_gpay']  = $select_total_amt_row['amount'];
	}else{
		$response_arr[0]['total_collection_gpay']  = 0;
	}
	
		//cash
	$select_total_amt = $obj->selectData("sum(tbl_treatment_payment_mode.amount) as amount","tbl_treatment_invoice inner join tbl_treatment_payment_mode on tbl_treatment_invoice.id=tbl_treatment_payment_mode.invoice_id","where tbl_treatment_invoice.added_date='$days' and tbl_treatment_invoice.status!=0 and tbl_treatment_payment_mode.payment_type=2");
	$select_total_amt_row = mysqli_fetch_array($select_total_amt);
	if($select_total_amt_row['amount'] != null){
		$response_arr[0]['total_collection_cash']  = $select_total_amt_row['amount'];
	}else{
		$response_arr[0]['total_collection_cash']  = 0;
	}
	
			//card
	$select_total_amt = $obj->selectData("sum(tbl_treatment_payment_mode.amount) as amount","tbl_treatment_invoice inner join tbl_treatment_payment_mode on tbl_treatment_invoice.id=tbl_treatment_payment_mode.invoice_id","where tbl_treatment_invoice.added_date='$days' and tbl_treatment_invoice.status!=0 and tbl_treatment_payment_mode.payment_type=3");
	$select_total_amt_row = mysqli_fetch_array($select_total_amt);
	if($select_total_amt_row['amount'] != null){
		$response_arr[0]['total_collection_card']  = $select_total_amt_row['amount'];
	}else{
		$response_arr[0]['total_collection_card']  = 0;
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
	$check_total_appointments_data = $obj->selectData("count(id) as id","tbl_appointment","where appointment_date='$date' and appointment_time_slot_id=$time_slot and status!=0");
	if(mysqli_num_rows($check_total_appointments_data)>0){
		$check_total_appointments_row = mysqli_fetch_array($check_total_appointments_data);
		if($check_total_appointments_row['id'] != null){
			$total_num_appointment  = $check_total_appointments_row['id'];
		}
	}
	return $total_num_appointment;
}
?>