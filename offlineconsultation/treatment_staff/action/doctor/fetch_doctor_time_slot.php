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
if(isset($_SESSION['doctor_login_id'])){
$login_id = $_SESSION['doctor_login_id'];
$staff_role = $_SESSION['doctor_role'];
$staff_unique_code = $_SESSION['doctor_unique_code'];
if($staff_role == 'doctor'){
$api_key_value = $_SESSION['api_key_value_doctor'];
$staff_unique_code = $_SESSION['doctor_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);
	//echo $check_security;exit();
if($check_security == 1){
	$doctor_id = $login_id;
	$Choose_date = $_POST['date'];
	if($Choose_date == ''){
		$Choose_date = $days1;
	}
	$select_doctor_time_slot = $obj->selectData("id,time_slot_id,status","tbl_doctor_appointment_slot","where doctor_id=$doctor_id and status!=0");
	if(mysqli_num_rows($select_doctor_time_slot)>0){
		$x = 0;
		while($select_doctor_time_slot_row = mysqli_fetch_array($select_doctor_time_slot)){
			$doctor_time_id = $select_doctor_time_slot_row['id'];
			$time_slot_id = $select_doctor_time_slot_row['time_slot_id'];
			$status = $select_doctor_time_slot_row['status'];
			$appointment_id = $select_doctor_time_slot_row['id'];
			$select_time_slot_data = $obj->selectData("id,start_time,end_time,total_num_slot","tbl_appointment_slot","where id=$time_slot_id and status!=0");
			if(mysqli_num_rows($select_time_slot_data)>0){
				$response_arr[0]['data_status'] = 1;
				while($select_time_slot_data_row = mysqli_fetch_array($select_time_slot_data)){
					$start_time = $select_time_slot_data_row['start_time'];
					$end_time = $select_time_slot_data_row['end_time'];
					$total_num_slot = $select_time_slot_data_row['total_num_slot'];
					/**check todays limit**/
					$check_limit = $obj->selectData("count(id) as id","tbl_appointment","where appointment_time_slot_id=$doctor_time_id and status=1 and appointment_date='$Choose_date' and doctor_id=$doctor_id");
					
					$check_limit_row = mysqli_fetch_array($check_limit);
					$admitted_p = 0;
					if($check_limit_row['id'] != null){
						$admitted_p = $check_limit_row['id'];
					}
					if($admitted_p < $total_num_slot){
						$response_arr[$x]['limit_status'] = 0;
					}else{
						$response_arr[$x]['limit_status'] = 1;
					}
					$first_time_arr = explode(":",$start_time);
					$first_time = $first_time_arr[0];
					$last_time_arr = explode(":",$end_time);
					$last_time = $last_time_arr[0];
					if($first_time>12){
						$f_time_section = 'PM';
						$time_data = $first_time-12;
						$f_time_compained_data = $time_data.':'.$first_time_arr[1];
					}else{
						$f_time_section = 'AM';
						$f_time_compained_data = $start_time;
					}
			
					if($last_time>12){
						$l_time_section = 'PM';
						$l_time_data = $last_time-12;
						$l_time_compained_data = $l_time_data.':'.$last_time_arr[1];
					}else{
						$l_time_section = 'AM';
						$l_time_compained_data = $end_time;
					}
					$response_arr[$x]['id'] = $select_doctor_time_slot_row['id'];
					$response_arr[$x]['start_time'] = $f_time_compained_data;
					$response_arr[$x]['end_time'] = $l_time_compained_data;
					$response_arr[$x]['f_time_section'] = $f_time_section;
					$response_arr[$x]['l_time_section'] = $l_time_section;
					$response_arr[$x]['total_num_slot'] = $select_time_slot_data_row['total_num_slot'];
					$response_arr[$x]['time_status'] = $select_doctor_time_slot_row['status'];
					$x++;
					
				}
			}else{
				$response_arr[0]['data_status'] = 0;
			}
		}
	}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
	//tbl_branch
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