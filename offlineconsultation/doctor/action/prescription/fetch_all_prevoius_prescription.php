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
			$x = 0;
			$current_patient_uniqueid = $_POST['current_patient_uniqueid'];
			$branch = $_POST['branch_id'];
			require_once '../../../_class_branch/query_branch.php';
			$obj_branch = new query_branch();
			$select_all_prescription_data = $obj_branch->selectData("id","tbl_patient","where unique_id='$current_patient_uniqueid'");
			if(mysqli_num_rows($select_all_prescription_data)>0){
				while($select_all_prescription_data_row = mysqli_fetch_array($select_all_prescription_data)){
					$patient_data = $select_all_prescription_data_row['id'];
					$select_all_prescription_by_date = $obj_branch->selectData("distinct prescriptions_added_date","tbl_prescriptions","where status != 0 and patient_id = $patient_data ORDER BY  appointment_id DESC");
					//echo $select_all_prescription_by_date;exit();
					if(mysqli_num_rows($select_all_prescription_by_date)){
						$x = 0;
						while($select_all_prescription_by_date_rows = mysqli_fetch_assoc($select_all_prescription_by_date)){
							$id = $select_all_prescription_by_date_rows['id'];
							 $p_added_date = $response_arr[$x]['added_date'] = $select_all_prescription_by_date_rows['prescriptions_added_date'];
							$select_all_prescription_id = $obj_branch->selectData("id,prescriptions_added_date,prescriptions_added_time","tbl_prescriptions","where prescriptions_added_date = '$p_added_date' and patient_id = $patient_data   ORDER BY id DESC");

							if(mysqli_num_rows($select_all_prescription_id)>0){
								$response_arr[0]['data_status'] = 1;
								$y = 0;
								while($select_all_prescription_id_row = mysqli_fetch_array($select_all_prescription_id)){
									$prescriptions_id = $select_all_prescription_id_row['id'];
									$prescriptions_added_date = $select_all_prescription_id_row['prescriptions_added_date'];
									$prescriptions_added_time = $select_all_prescription_id_row['prescriptions_added_time'];
									$select_prescription_details = $obj_branch->selectData("id,prescription_id,medicine_id,medicine_name,quantity,morning_section,noon_section,evening_section,no_of_day,remark,after_food,befor_food","tbl_prescription_medicine_data","where prescription_id=$prescriptions_id and status!=0");
									if(mysqli_num_rows($select_prescription_details)>0){
										while($select_prescription_details_row = mysqli_fetch_array($select_prescription_details)){
											$response_arr[$x]['prescription'][$y]['medicine_name'] = $select_prescription_details_row['medicine_name'];
											$response_arr[$x]['prescription'][$y]['quantity'] = $select_prescription_details_row['quantity'];
											$response_arr[$x]['prescription'][$y]['morning_section'] = $select_prescription_details_row['morning_section'];
											$response_arr[$x]['prescription'][$y]['noon_section'] = $select_prescription_details_row['noon_section'];
											$response_arr[$x]['prescription'][$y]['evening_section'] = $select_prescription_details_row['evening_section'];
											$response_arr[$x]['prescription'][$y]['no_of_day'] = $select_prescription_details_row['no_of_day'];
											$response_arr[$x]['prescription'][$y]['remark'] = $select_prescription_details_row['remark'];
											$time_data = '';
											if($select_prescription_details_row['after_food'] == 1){
												$time_data = "After Food";
											}else if($select_prescription_details_row['befor_food'] == 1){
												$time_data = "Before Food";
											}
											$response_arr[$x]['prescription'][$y]['time'] = $time_data;
											$response_arr[$x]['prescription'][$y]['date_time'] = $prescriptions_added_date;
											$y++;
										}
									}
								}
							}else{
								$response_arr[0]['data_status'] = 0;
							}

							$x++;
						}
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