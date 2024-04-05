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
			$limit_range = $_POST['limit_range'];
			$search_val = $_POST['search_val'];
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$where_search_data = '';
			$where_date_clause = '';
			if($search_val != ''){
				$where_search_data = " and (tbl_patient.unique_id like '%$search_val%' or  tbl_patient.name like '%$search_val%' or tbl_patient.phone like '%$search_val%' || tbl_appointment.booking_id like '%$search_val%')";
			}

			if($start_date != '' and $end_date == ''){
				$new_start_Date = date("d-m-Y", strtotime($start_date));
				$where_date_clause = " and tbl_appointment.appointment_taken_date='$new_start_Date'";
			}else if($end_date !='' and $start_date == ''){
				$new_end_Date = date("d-m-Y", strtotime($end_date));
				$where_date_clause = " and tbl_appointment.appointment_taken_date='$new_end_Date'";
			}else if($start_date !='' and $end_date !=''){
				$new_start_Date = date("d-m-Y", strtotime($start_date));
				$new_end_Date = date("d-m-Y", strtotime($end_date));
				$End_new_Date = strtotime($new_end_Date);
				$start_new_Date = strtotime($new_start_Date);
				$date_diff = ($End_new_Date-$start_new_Date)/60/60/24;

				if($date_diff!=0){
					$where_date_clause = " and (";
					for($x1=0;$x1<=$date_diff;$x1++){
						$new_date = date('d-m-Y',strtotime($new_start_Date . ' +'.$x1.' day'));
						if($x1 == $date_diff){
							$where_date_clause .= "tbl_appointment.appointment_taken_date='$new_date')";
						}else{
							$where_date_clause .= "tbl_appointment.appointment_taken_date='$new_date' or ";
						}
					}
				}
			}
			$select_appointments = $obj->selectData("id,branch_id,real_branch_id","tbl_appointment","where tbl_appointment.doctor_id='$login_id' and tbl_appointment.status!=0  and appointment_taken_type='Online' and tbl_appointment.appointment_fee_status=1  ORDER by tbl_appointment.id $where_date_clause DESC limit $limit_range");
			if(mysqli_num_rows($select_appointments)>0){
				$x1 = 0;
				while($select_appointment_details = mysqli_fetch_assoc($select_appointments)){
					$branch_id = $select_appointment_details['branch_id'];
					$real_branch_id = $select_appointment_details['real_branch_id'];
					$appointment_id = $select_appointment_details['id'];
					if($real_branch_id == $branch_id){
						$select_todays_appointment = $obj->selectData("tbl_appointment.id as app_id,tbl_appointment.appointment_number,tbl_appointment.present_Illness,tbl_appointment.appointment_date,tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.place,tbl_appointment.appointment_status,tbl_appointment.appointment_taken_date,tbl_appointment.online_confirm_date,tbl_appointment.booking_id","tbl_appointment inner join tbl_patient on tbl_appointment.patient_id=tbl_patient.id","where tbl_appointment.doctor_id='$login_id' and tbl_appointment.status!=0  and appointment_taken_type='Online' and tbl_appointment.appointment_fee_status=1 and tbl_appointment.id = $appointment_id $where_search_data ");
						
						if(mysqli_num_rows($select_todays_appointment)>0){
							$response_arr[0]['data_status'] = 1;
							//$x1 = 0;
							while($select_todays_appointment_row = mysqli_fetch_array($select_todays_appointment)){
								$response_arr[$x1]['appointment_number'] = $select_todays_appointment_row['appointment_number'];
								$response_arr[$x1]['present_Illness'] = $select_todays_appointment_row['present_Illness'];
								$response_arr[$x1]['app_id'] = $select_todays_appointment_row['app_id'];
								$response_arr[$x1]['appointment_date'] = $appointment_date_new;
								$response_arr[$x1]['current_date'] = date('d-m-Y');
								$response_arr[$x1]['unique_id'] = $select_todays_appointment_row['unique_id'];
								$response_arr[$x1]['name'] = $select_todays_appointment_row['name'];
								$response_arr[$x1]['phone'] = $select_todays_appointment_row['phone'];
								$response_arr[$x1]['place'] = $select_todays_appointment_row['place'];
								$response_arr[$x1]['appointment_status'] = $select_todays_appointment_row['appointment_status'];
								$response_arr[$x1]['appointment_taken_date'] = $select_todays_appointment_row['appointment_taken_date'];
								$response_arr[$x1]['booking_id'] = $select_todays_appointment_row['booking_id'];
								if($select_todays_appointment_row['online_confirm_date'] != ''){
									$appointment_date_new = date('d/m/Y',strtotime($select_todays_appointment_row['online_confirm_date']));
								}else{
									$appointment_date_new = '';
								}
								$response_arr[$x1]['online_confirm_date'] = $appointment_date_new;
								//$x1++;
							}
							$x1++;
						}else{
							//$response_arr[0]['data_status'] = 0;
						}

					}else{
						$branch = $branch_id;
						require_once '../../../_class_branch/query_branch.php';
						$obj_branch = new query_branch();
						$select_todays_appointment = $obj_branch->selectData("tbl_appointment.cross_appointment_id as app_id,tbl_appointment.appointment_number,tbl_appointment.present_Illness,tbl_appointment.appointment_date,tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.place,tbl_appointment.appointment_status,tbl_appointment.appointment_taken_date,tbl_appointment.online_confirm_date,tbl_appointment.booking_id","tbl_appointment inner join tbl_patient on tbl_appointment.patient_id=tbl_patient.id","where tbl_appointment.doctor_id='$login_id' and tbl_appointment.status!=0  and appointment_taken_type='Online' and tbl_appointment.appointment_fee_status=1 and tbl_appointment.cross_appointment_id = $appointment_id and cross_branch_id = $real_branch_id $where_search_data and tbl_appointment.cross_appointment_id = $appointment_id");
					
					if(mysqli_num_rows($select_todays_appointment)>0){
						$response_arr[0]['data_status'] = 1;
						//$x1 = 0;
						while($select_todays_appointment_row = mysqli_fetch_array($select_todays_appointment)){
							$response_arr[$x1]['appointment_number'] = $select_todays_appointment_row['appointment_number'];
							$response_arr[$x1]['present_Illness'] = $select_todays_appointment_row['present_Illness'];
							$response_arr[$x1]['app_id'] = $select_todays_appointment_row['app_id'];
							$response_arr[$x1]['appointment_date'] = $appointment_date_new;
							$response_arr[$x1]['current_date'] = date('d-m-Y');
							$response_arr[$x1]['unique_id'] = $select_todays_appointment_row['unique_id'];
							$response_arr[$x1]['name'] = $select_todays_appointment_row['name'];
							$response_arr[$x1]['phone'] = $select_todays_appointment_row['phone'];
							$response_arr[$x1]['place'] = $select_todays_appointment_row['place'];
							$response_arr[$x1]['appointment_status'] = $select_todays_appointment_row['appointment_status'];
							$response_arr[$x1]['appointment_taken_date'] = $select_todays_appointment_row['appointment_taken_date'];
							$response_arr[$x1]['booking_id'] = $select_todays_appointment_row['booking_id'];
							if($select_todays_appointment_row['online_confirm_date'] != ''){
								$appointment_date_new = date('d/m/Y',strtotime($select_todays_appointment_row['online_confirm_date']));
							}else{
								$appointment_date_new = '';
							}
							$response_arr[$x1]['online_confirm_date'] = $appointment_date_new;
							//$x1++;
						}
						$x1++;
					}else{
						//$response_arr[0]['data_status'] = 0;
					}
					}

					
				}
			}

			$response_arr[0]['status'] = 1;
			$response_arr[0]['msg'] = 'Success';
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