<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
require_once '../../../_class_common/query_common.php';
$response_arr = array();
$obj=new query();
$obj_common = new query_common();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
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

	//echo $check_security;exit();
if($check_security == 1){
	$current_month = $_POST['month'] + 1;
	$current_year = $_POST['year'];
	$select_dates = $obj->selectData('reffered_date,id','tbl_reffered_dates',"where doctor_id = $login_id and status = 1 and reffered_month = $current_month and reffered_year = $current_year order by reffered_date asc");
	//echo $select_dates;exit();
	    
		if(mysqli_num_rows($select_dates)>0){
			$response_arr[0]['status'] = 1;
			$response_arr[0]['msg'] = 'Success';
			
			$x = 0;
			while($select_dates_rows = mysqli_fetch_assoc($select_dates)){
				
				$input_date = str_replace('-','/',($select_dates_rows['reffered_date']));
				
				$output_format = 'm/d/Y';
				$input_format = 'Y/m/d';
				$date = DateTime::createFromFormat($input_format, $input_date);
				
    			$output_date = $date->format($output_format);
				$reffered_date = $select_dates_rows['reffered_date'];
				$response_arr[$x]['dates'] = $output_date;
				$response_arr[$x]['id'] = $select_dates_rows['id'];
				$select_reffered_app = $obj->selectData('id' ,'tbl_appointment',"where reffer_status = $login_id and status = 1 and reffered_date = '$reffered_date'");
				//echo $select_reffered_app;exit();
				$response_arr[$x]['noofapp'] = mysqli_num_rows($select_reffered_app);
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