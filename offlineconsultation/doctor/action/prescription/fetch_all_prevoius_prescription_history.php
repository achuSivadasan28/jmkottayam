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
	$x = 0;
	$current_patient_uniqueid = $_POST['current_patient_uniqueid'];
	$branch = $_POST['branch'];
	require_once '../../../_class_branch/query_branch.php';
	$obj_branch = new query_branch();
	$select_all_prescription_data = $obj_branch->selectData("id","tbl_patient","where unique_id='$current_patient_uniqueid'");
	if(mysqli_num_rows($select_all_prescription_data)>0){
		while($select_all_prescription_data_row = mysqli_fetch_array($select_all_prescription_data)){
			$patient_data = $select_all_prescription_data_row['id'];
			$check_prescriptions_today = $obj_branch->selectData("id,prescriptions_added_date,prescriptions_added_time,appointment_id","tbl_prescriptions","where prescriptions_added_date='$days' and status=1 and patient_id=$patient_data ORDER BY id DESC");
			if(mysqli_num_rows($check_prescriptions_today)>0){
				$response_arr[0]['edit_del_status'] = 1;
				$response_arr[0]['data_status'] = 1;
				while($check_prescriptions_today_row = mysqli_fetch_array($check_prescriptions_today)){
					$appointment_id = $check_prescriptions_today_row['appointment_id'];
					$branch_id = 0;
					$select_branch_id = $obj->selectData("branch_id","tbl_appointment","where id=$appointment_id");
					if(mysqli_num_rows($select_branch_id)>0){
						$select_branch_id_row = mysqli_fetch_array($select_branch_id);
						$branch_id = $select_branch_id_row['branch_id'];
					}
					$prescriptions_id = $check_prescriptions_today_row['id'];
					$prescriptions_added_date = $check_prescriptions_today_row['prescriptions_added_date'];
					$prescriptions_added_time = $check_prescriptions_today_row['prescriptions_added_time'];
					$select_prescription_details = $obj_branch->selectData("id,prescription_id,medicine_id,medicine_name,quantity,morning_section,noon_section,evening_section,no_of_day,remark,after_food,befor_food","tbl_prescription_medicine_data","where prescription_id=$prescriptions_id and status!=0 ORDER BY id DESC");
					if(mysqli_num_rows($select_prescription_details)>0){
						while($select_prescription_details_row = mysqli_fetch_array($select_prescription_details)){
							$response_arr[$x]['id'] = $select_prescription_details_row['id'];
							$response_arr[$x]['branch_id'] = $branch_id;
							$response_arr[$x]['medicine_name'] = $select_prescription_details_row['medicine_name'];
							$response_arr[$x]['quantity'] = $select_prescription_details_row['quantity'];
							$response_arr[$x]['morning_section'] = $select_prescription_details_row['morning_section'];
							$response_arr[$x]['noon_section'] = $select_prescription_details_row['noon_section'];
							$response_arr[$x]['evening_section'] = $select_prescription_details_row['evening_section'];
							$response_arr[$x]['no_of_day'] = $select_prescription_details_row['no_of_day'];
							$response_arr[$x]['remark'] = $select_prescription_details_row['remark'];
							$time_data = '';
							if($select_prescription_details_row['after_food'] == 1){
								$time_data = "AF";
							}else if($select_prescription_details_row['befor_food'] == 1){
								$time_data = "BF";
							}
							$response_arr[$x]['time'] = $time_data;
							$response_arr[$x]['date_time'] = $prescriptions_added_date;
							$x++;
						}
					}
					
				}
			}else{
			$select_all_prescription_id = $obj_branch->selectData("id,prescriptions_added_date,prescriptions_added_time,appointment_id","tbl_prescriptions","where status!=0 and patient_id=$patient_data ORDER BY id DESC limit 1");
			if(mysqli_num_rows($select_all_prescription_id)>0){
				$response_arr[0]['data_status'] = 1;
				while($select_all_prescription_id_row = mysqli_fetch_array($select_all_prescription_id)){
					$prescriptions_id = $select_all_prescription_id_row['id'];
					$appointment_id = $select_all_prescription_id_row['appointment_id'];
					$branch_id = 0;
					$select_branch_id = $obj->selectData("branch_id","tbl_appointment","where id=$appointment_id");
					if(mysqli_num_rows($select_branch_id)>0){
						$select_branch_id_row = mysqli_fetch_array($select_branch_id);
						$branch_id = $select_branch_id_row['branch_id'];
					}
					$prescriptions_added_date = $select_all_prescription_id_row['prescriptions_added_date'];
					$prescriptions_added_time = $select_all_prescription_id_row['prescriptions_added_time'];
					$select_prescription_details = $obj_branch->selectData("id,prescription_id,medicine_id,medicine_name,quantity,morning_section,noon_section,evening_section,no_of_day,remark,after_food,befor_food","tbl_prescription_medicine_data","where prescription_id=$prescriptions_id and status!=0");
					if(mysqli_num_rows($select_prescription_details)>0){
						while($select_prescription_details_row = mysqli_fetch_array($select_prescription_details)){
							$response_arr[$x]['id'] = $select_prescription_details_row['id'];
							$response_arr[$x]['branch_id'] = $branch_id;
							$response_arr[$x]['medicine_name'] = $select_prescription_details_row['medicine_name'];
							$response_arr[$x]['quantity'] = $select_prescription_details_row['quantity'];
							$response_arr[$x]['morning_section'] = $select_prescription_details_row['morning_section'];
							$response_arr[$x]['noon_section'] = $select_prescription_details_row['noon_section'];
							$response_arr[$x]['evening_section'] = $select_prescription_details_row['evening_section'];
							$response_arr[$x]['no_of_day'] = $select_prescription_details_row['no_of_day'];
							$response_arr[$x]['remark'] = $select_prescription_details_row['remark'];
							$time_data = '';
							if($select_prescription_details_row['after_food'] == 1){
								$time_data = "AF";
							}else if($select_prescription_details_row['befor_food'] == 1){
								$time_data = "BF";
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
				$response_arr[0]['edit_del_status'] = 0;
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