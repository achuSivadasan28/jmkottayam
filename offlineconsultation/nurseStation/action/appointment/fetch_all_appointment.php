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
	$limit_range = $_POST['limit_range'];
	$search_val = $_POST['search_val'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$where_search_data = '';
	$where_date_clause = '';
	if($search_val != ''){
		$where_search_data = " and (tbl_patient.unique_id like '%$search_val%' or  tbl_patient.name like '%$search_val%' or tbl_patient.phone like '%$search_val%')";
	}
	
		if($start_date != '' and $end_date == ''){
		$where_date_clause = " and tbl_appointment.appointment_date='$start_date'";
	}else if($end_date !='' and $start_date == ''){
		$where_date_clause = " and tbl_appointment.appointment_date='$end_date'";
	}else if($start_date !='' and $end_date !=''){
		$new_start_Date = date("Y-m-d", strtotime($start_date));
		$new_end_Date = date("Y-m-d", strtotime($end_date));
		$End_new_Date = strtotime($new_end_Date);
		$start_new_Date = strtotime($new_start_Date);
		$date_diff = ($End_new_Date-$start_new_Date)/60/60/24;
		
		if($date_diff!=0){
			$where_date_clause = " and (";
			for($x1=0;$x1<=$date_diff;$x1++){
				$new_date = date('Y-m-d',strtotime($new_start_Date . ' +'.$x1.' day'));
				if($x1 == $date_diff){
					$where_date_clause .= "tbl_appointment.appointment_date='$new_date')";
				}else{
					$where_date_clause .= "tbl_appointment.appointment_date='$new_date' or ";
				}
			}
		}
	}
	
	$select_todays_appointment = $obj->selectData("tbl_appointment.id as app_id,tbl_appointment.appointment_number,tbl_appointment.present_Illness,tbl_appointment.appointment_date,tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.place,tbl_appointment.appointment_status,tbl_appointment.doctor_id","tbl_appointment inner join tbl_patient on tbl_appointment.patient_id=tbl_patient.id","where tbl_appointment.status!=0 $where_search_data $where_date_clause and tbl_appointment.appointment_status!=2 ORDER by tbl_appointment.id DESC limit $limit_range");
	if(mysqli_num_rows($select_todays_appointment)>0){
		$response_arr[0]['data_status'] = 1;
		$x1 = 0;
		while($select_todays_appointment_row = mysqli_fetch_array($select_todays_appointment)){
			$response_arr[$x1]['appointment_number'] = $select_todays_appointment_row['appointment_number'];
			$response_arr[$x1]['present_Illness'] = $select_todays_appointment_row['present_Illness'];
			$appointment_date_new = date('d/m/Y',strtotime($select_todays_appointment_row['appointment_date']));
			$response_arr[$x1]['app_id'] = $select_todays_appointment_row['app_id'];
			$response_arr[$x1]['appointment_date'] = $appointment_date_new;
			$response_arr[$x1]['unique_id'] = $select_todays_appointment_row['unique_id'];
			$response_arr[$x1]['name'] = $select_todays_appointment_row['name'];
			$response_arr[$x1]['phone'] = $select_todays_appointment_row['phone'];
			$response_arr[$x1]['place'] = $select_todays_appointment_row['place'];
			$response_arr[$x1]['appointment_status'] = $select_todays_appointment_row['appointment_status'];
			$doctor_id = $select_todays_appointment_row['doctor_id'];
			$select_doctor_data = $obj->selectData("doctor_name","tbl_doctor","where login_id=$doctor_id");
			if(mysqli_num_rows($select_doctor_data)>0){
				$select_doctor_data_row = mysqli_fetch_array($select_doctor_data);
				$response_arr[$x1]['doctor_name'] = $select_doctor_data_row['doctor_name'];
			}
			$x1++;
		}
	}else{
		$response_arr[0]['data_status'] = 0;
	}
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
?>