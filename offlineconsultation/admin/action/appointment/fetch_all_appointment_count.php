<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$days_re=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');
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
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$search_val = $_POST['search_val'];
	$where_date_clause = '';
	$where_date_serach = '';
	$response_arr[0]['current_date'] = '';
	if($search_val != ''){
		$where_date_serach = " and (tbl_patient.name like '%$search_val%' or tbl_patient.phone like '%$search_val%' or tbl_patient.place like '%$search_val%' or tbl_appointment.appointment_number like '%$search_val%' or tbl_patient.unique_id like '%$search_val%')";
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
	}else{
		//$where_date_clause = " and tbl_appointment.appointment_date='$days_re'";
		//$response_arr[0]['current_date'] = $days_re;
	}
	
	$select_all_data = $obj->selectData("count(tbl_appointment.id) as id","tbl_appointment inner join tbl_patient on tbl_appointment.patient_id=tbl_patient.id inner join tbl_doctor on tbl_appointment.doctor_id=tbl_doctor.login_id","where tbl_appointment.status!=2 and tbl_appointment.cross_branch_status=0 $where_date_clause $where_date_serach ORDER BY tbl_appointment.id desc");
	
	if(mysqli_num_rows($select_all_data)>0){
		$response_arr[0]['data_status'] = 1;
		$x = 0;
		while($select_all_data_row = mysqli_fetch_array($select_all_data)){
			$response_arr[$x]['count_id'] = $select_all_data_row['id'];
		}
	}else{
		$response_arr[$x]['count_id'] = 0;
		$response_arr[0]['data_status'] = 0;
	}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
}else{
	$response_arr[$x]['count_id'] = 0;
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Something Went Wrong! Try Again';
}
}else{
	$response_arr[$x]['count_id'] = 0;
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Unauthorised login';	
}
}else{
	$response_arr[$x]['count_id'] = 0;
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Unauthorised login';
}
echo json_encode($response_arr);
?>