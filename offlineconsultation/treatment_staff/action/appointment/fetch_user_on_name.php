<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$days1 = date('Y-m-d');
$times=date('h:i:s A');
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
	$number = $_POST['phone_num'];
	$user_name = $_POST['user_name'];
	$visit_limit = 0;
	$date_limit = 0;
	$select_add_fee_date_limit = $obj->selectData("visit_limit,date_limit","tbl_appointment_fee","where status=1");
	if(mysqli_num_rows($select_add_fee_date_limit)>0){
		while($select_add_fee_date_limit_row = mysqli_fetch_array($select_add_fee_date_limit)){
			$visit_limit = $select_add_fee_date_limit_row['visit_limit'];
			$date_limit = $select_add_fee_date_limit_row['date_limit'];
		}
	}
	$check_phn = $obj->selectData("id,unique_id,name,phone,address,place,age,gender,whatsApp","tbl_patient","where phone='$number' and name='$user_name' and  status!=0");
	if(mysqli_num_rows($check_phn)>0){
		$response_arr[0]['data_exist'] = 1;
		while($check_phn_row = mysqli_fetch_array($check_phn)){
			$response_arr[0]['id'] = $check_phn_row['id'];
			$patient_id = $check_phn_row['id'];
			$response_arr[0]['unique_id'] = $check_phn_row['unique_id'];
			$response_arr[0]['phone'] = $check_phn_row['phone'];
			$response_arr[0]['address'] = $check_phn_row['address'];
			$response_arr[0]['place'] = $check_phn_row['place'];
			$response_arr[0]['age'] = $check_phn_row['age'];
			$response_arr[0]['gender'] = $check_phn_row['gender'];
			$response_arr[0]['whatsApp'] = $check_phn_row['whatsApp'];
			$select_First_visit = $obj->selectData("first_visit","tbl_appointment","where patient_id='$patient_id' and status!=0");
				if(mysqli_num_rows($select_First_visit)>0){
					while($select_First_visit_row = mysqli_fetch_array($select_First_visit)){
						$response_arr[0]['first_visit'] = $select_First_visit_row['first_visit'];
						if($select_First_visit_row['first_visit'] != ''){
							break;
						}
					}
				}
			if($visit_limit !=0 and $date_limit!=0){
			$appointment_date = '';
			$appointment_id = 0;
			$check_last_appointmnet_with_fee = $obj->selectData("id,appointment_date","tbl_appointment","where status!=0 and appointment_fee!=0 and patient_id = $patient_id ORDER BY id DESC limit 1");
	if(mysqli_num_rows($check_last_appointmnet_with_fee)>0){
			$check_last_appointmnet_with_fee_row = mysqli_fetch_array($check_last_appointmnet_with_fee);
			$appointment_date = $check_last_appointmnet_with_fee_row['appointment_date'];
			$appointment_id = $check_last_appointmnet_with_fee_row['id'];
	}
				
	
	
	//select total visit after payment
			$total_visit_count = 0;
	$select_visit_count = $obj->selectData("count(id) as id","tbl_appointment","where  id>=$appointment_id and patient_id=$patient_id and status!=0");
	$select_visit_count_row = mysqli_fetch_array($select_visit_count);
	if($select_visit_count_row['id'] != null){
		(int)$total_visit_count = $select_visit_count_row['id'];
	}
	$month_limit = "+".$date_limit." months";
	$new_format_appointment_date = date("d-m-Y", strtotime($appointment_date));
	$new_format_appointment_date = date('Y-m-d', strtotime("$month_limit", strtotime($new_format_appointment_date)));
	$new_format_appointment_date1 = date("d-m-Y", strtotime($new_format_appointment_date));
//echo $new_format_appointment_date;exit();
	if($total_visit_count<$visit_limit)	{
		if($days1<$new_format_appointment_date){
			$response_arr[0]['appointment_fee'] = 0;
			$remaining_visit = $visit_limit-$total_visit_count;
			$response_arr[0]['appointment_fee_msg'] = "Remaining Visit ".$remaining_visit." or up to ".$new_format_appointment_date1;
		}else{
			$response_arr[0]['appointment_fee'] = 1;
		}
	}else{
		$response_arr[0]['appointment_fee'] = 1;
	}
		}else{
				$response_arr[0]['appointment_fee'] = 1;
			}
		}
	}else{
		$response_arr[0]['data_exist'] = 0;
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