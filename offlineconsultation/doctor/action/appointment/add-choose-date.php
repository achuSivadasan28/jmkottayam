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
	$input_date = $_POST['date'];
	
	$date = date('Y-m-d',strtotime($input_date));
	$reffered_month = explode('-',$date)[1];
	$reffered_year = explode('-',$date)[0];
	if($login_id == 86 || $login_id == 58){
		
	    $select_dates = $obj->selectData("reffered_date,status,id","tbl_reffered_dates","where reffered_date = '$date' and doctor_id = '$login_id'");
	
		if(mysqli_num_rows($select_dates)>0){
			$select_dates_rows = mysqli_fetch_assoc($select_dates);
			$id = $select_dates_rows['id'];
			
			if($select_dates_rows['status'] == 1){
				$update_date = ['status' => 0];
				
				$obj->updateData('tbl_reffered_dates',$update_date,"where id = '$id'");
			}else{
				$update_date = ['status' => 1];
				$obj->updateData('tbl_reffered_dates',$update_date,"where id = '$id'");
			}
		}else{
			$insert_data = [
			"reffered_date" => $date,
			"doctor_id" => $login_id,
			"added_date" => $days,
			"added_time" => $times,
		    "reffered_month" => $reffered_month,
			"reffered_year" => $reffered_year,
			"status" => 1,
		  ];
          $obj->insertData('tbl_reffered_dates',$insert_data);
		
		}
		
		$response_arr[0]['status'] = 1;
	    $response_arr[0]['msg'] = 'Success';
		
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