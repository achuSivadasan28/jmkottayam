<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
require_once '../../../_class_common/query_common.php';
$response_arr = array();
$obj=new query();
$obj_common=new query_common();
date_default_timezone_set('Asia/Kolkata');
$days=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');
$curr_year = date('y');
$real_branch_id = 5;
if(isset($_SESSION['doctor_login_id'])){
$login_id = $_SESSION['doctor_login_id'];
$doctor_role = $_SESSION['doctor_role'];
$doctor_unique_code = $_SESSION['doctor_unique_code'];
if($doctor_role == 'doctor'){
$api_key_value = $_SESSION['api_key_value_doctor'];
$doctor_unique_code = $_SESSION['doctor_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$doctor_unique_code);
$branch = 5;
require_once '../../../_class_branch/query_branch.php';
$obj_branch = new query_branch();

	//echo $check_security;exit();
if($check_security == 1){
	$month = $_POST['month']+1;
	$year  = $_POST['year'];
	$id = $_POST['login_id'];
	
	$select_refer_month = $obj_branch->selectData("distinct reffered_month","tbl_reffered_dates","where reffered_month >= $month and reffered_year >= $year and status != 0 and doctor_id = $id order by reffered_month asc");
	//echo $select_refer_month;exit();
	if(mysqli_num_rows($select_refer_month)>0){
		$x = 0;
		while($select_refer_month_rows  = mysqli_fetch_assoc($select_refer_month)){
			$reffered_month = $select_refer_month_rows['reffered_month'];
			$response_arr[$x]['monthname'] = $select_refer_month_rows['reffered_month'];
			$select_referred_dates = $obj_branch->selectData("reffered_date,id,patient_limit","tbl_reffered_dates","where reffered_month = $reffered_month and status != 0 and doctor_id = $id and reffered_date >= '$days' order by reffered_date asc ");
			//echo $select_referred_dates;exit();
			
			$y = 0;
			if(mysqli_num_rows($select_referred_dates)>0){
				while($select_refferd_dates_row = mysqli_fetch_assoc($select_referred_dates)){
					$response_arr[$x]['month'][$y]['id'] = $select_refferd_dates_row['id'];
					$patient_limit = $select_refferd_dates_row['patient_limit'];
					$response_arr[$x]['month'][$y]['reffered_date'] = $select_refferd_dates_row['reffered_date'];
					$reffered_date = $select_refferd_dates_row['reffered_date'];
					$select_no_of_appointment = $obj_branch->selectData("count(id) as id","tbl_appointment","where reffer_status = $id and status !=0 and reffered_date = '$reffered_date'");
					
					if(mysqli_num_rows($select_no_of_appointment)>0){
						$select_no_of_appointment_rows = mysqli_fetch_assoc($select_no_of_appointment);
						$response_arr[$x]['month'][$y]['appoints'] = $patient_limit - $select_no_of_appointment_rows['id'];
					}
					
					$y++;
				}
			
			}
			$x++;
		}
	
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
?>