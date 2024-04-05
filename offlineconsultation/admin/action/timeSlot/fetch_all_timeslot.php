<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
if(isset($_SESSION['admin_login_id'])){
$login_id = $_SESSION['admin_login_id'];
$admin_role = $_SESSION['admin_role'];
$admin_unique_code = $_SESSION['admin_unique_code'];
if($admin_role == 'admin'){
$api_key_value = $_SESSION['api_key_value'];
$admin_unique_code = $_SESSION['admin_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$admin_unique_code);
	//echo $check_security;exit();
if($check_security == 1){
	$select_all_branch = $obj->selectData("id,start_time,end_time,total_num_slot,status,slot_name","tbl_appointment_slot","where status!=0 ORDER BY id DESC");
	
	if(mysqli_num_rows($select_all_branch)>0){
		$x = 0;
		$response_arr[0]['data_status'] = 1;
		while($select_all_branch_row = mysqli_fetch_array($select_all_branch)){
			$response_arr[$x]['id'] = $select_all_branch_row['id'];
			$start_time = $select_all_branch_row['start_time'];
			$end_time = $select_all_branch_row['end_time'];
			$slot_name = $select_all_branch_row['slot_name'];
			$time_section = '';
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
			$response_arr[$x]['slot_name'] = $slot_name;
			$response_arr[$x]['start_time'] = $f_time_compained_data;
			$response_arr[$x]['end_time'] = $l_time_compained_data;
			$response_arr[$x]['f_time_section'] = $f_time_section;
			$response_arr[$x]['l_time_section'] = $l_time_section;
			$response_arr[$x]['total_num_slot'] = $select_all_branch_row['total_num_slot'];
			$response_arr[$x]['time_status'] = $select_all_branch_row['status'];
			$x++;
		}
	}else{
		$response_arr[0]['data_status'] = 0;
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