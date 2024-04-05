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
$date_arr = [];
	//echo $check_security;exit();
if($check_security == 1){
	$x = 0;
	$current_patient_uniqueid = $_POST['current_patient_uniqueid'];
	$select_all_prescription_data = $obj->selectData("id","tbl_patient","where unique_id='$current_patient_uniqueid'");
	if(mysqli_num_rows($select_all_prescription_data)>0){
		while($select_all_prescription_data_row = mysqli_fetch_array($select_all_prescription_data)){
			$patient_data = $select_all_prescription_data_row['id'];
			$select_all_prescription_id = $obj->selectData("id,prescriptions_added_date,prescriptions_added_time","tbl_prescriptions","where status!=0 and patient_id=$patient_data ORDER BY id DESC");
			
			if(mysqli_num_rows($select_all_prescription_id)>0){
				$response_arr[0]['data_status'] = 1;
				while($select_all_prescription_id_row = mysqli_fetch_array($select_all_prescription_id)){
					$prescriptions_id = $select_all_prescription_id_row['id'];
					$prescriptions_added_date = $select_all_prescription_id_row['prescriptions_added_date'];
					$prescriptions_added_time = $select_all_prescription_id_row['prescriptions_added_time'];
					$select_prescription_details = $obj->selectData("id,prescription_id,medicine_id,medicine_name,quantity,morning_section,noon_section,evening_section,no_of_day,remark,after_food,befor_food","tbl_prescription_medicine_data","where prescription_id=$prescriptions_id and status!=0");
					if(mysqli_num_rows($select_prescription_details)>0){
						while($select_prescription_details_row = mysqli_fetch_array($select_prescription_details)){
							$response_arr[$x]['medicine_name'] = $select_prescription_details_row['medicine_name'];
							$response_arr[$x]['quantity'] = $select_prescription_details_row['quantity'];
							$response_arr[$x]['morning_section'] = $select_prescription_details_row['morning_section'];
							$response_arr[$x]['noon_section'] = $select_prescription_details_row['noon_section'];
							$response_arr[$x]['evening_section'] = $select_prescription_details_row['evening_section'];
							$response_arr[$x]['no_of_day'] = $select_prescription_details_row['no_of_day'];
							$response_arr[$x]['remark'] = $select_prescription_details_row['remark'];
							$time_data = '';
							if($select_prescription_details_row['after_food'] == 1){
								$time_data = "After Food";
							}else if($select_prescription_details_row['befor_food'] == 1){
								$time_data = "Before Food";
							}
							$response_arr[$x]['time'] = $time_data;
							$response_arr[$x]['date_time'] = $prescriptions_added_date;
							$x++;
						}
					}
				}
			}else{
				$response_arr[0]['data_status'] = 0;
			}
		}
	}
	//tbl_prescription_medicine_data
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'success';
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