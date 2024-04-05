<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
$response_arr = array();
$obj=new query();
require_once '../../../_class_common/query_common.php';
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
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$where_search_data = '';
			$where_search_data_online = '';
			$where_date_clause = "";
			if($start_date == "" and $end_date == ""){
				$where_date_clause = " and tbl_appointment.appointment_date='$c_days'";
				$where_search_data_online = "and tbl_appointment.online_confirm_date='$c_days'";
			}else if($start_date == $end_date){
				$where_date_clause = " and tbl_appointment.appointment_date='$start_date'";
				$where_search_data_online = "and tbl_appointment.online_confirm_date='$start_date'";
			}else if($start_date != '' and $end_date == ''){
				$where_date_clause = " and tbl_appointment.appointment_date='$start_date'";
				$where_search_data_online = "and tbl_appointment.online_confirm_date='$start_date'";
			}else if($end_date !='' and $start_date == ''){
				$where_date_clause = " and tbl_appointment.appointment_date='$end_date'";
				$where_search_data_online = "and tbl_appointment.online_confirm_date='$end_date'";
			}else if($start_date !='' and $end_date !=''){
				$new_start_Date = date("Y-m-d", strtotime($start_date));
				$new_end_Date = date("Y-m-d", strtotime($end_date));
				$End_new_Date = strtotime($new_end_Date);
				$start_new_Date = strtotime($new_start_Date);
				$date_diff = ($End_new_Date-$start_new_Date)/60/60/24;

				if($date_diff!=0){
					$where_date_clause = " and (";
					$where_search_data_online = " and (";
					for($x1=0;$x1<=$date_diff;$x1++){
						$new_date = date('Y-m-d',strtotime($new_start_Date . ' +'.$x1.' day'));
						if($x1 == $date_diff){
							$where_search_data_online .= "tbl_appointment.online_confirm_date='$new_date')";
							$where_date_clause .= "tbl_appointment.appointment_date='$new_date')";
						}else{
							$where_search_data_online .= "tbl_appointment.online_confirm_date='$new_date' or ";
							$where_date_clause .= "tbl_appointment.appointment_date='$new_date' or ";
						}
					}
				}
			}
			$new_patient = 0;
			$old_patient = 0;
			$select_new_appointment = $obj->selectData("id,patient_id,branch_id,real_branch_id,old_patient,real_branch_id","tbl_appointment","where consulted_by = $login_id and status != 0  and cross_branch_status != 1 and appointment_taken_type = 'Offline' $where_date_clause order by id asc");
			//echo $select_new_appointment;exit();
			if(mysqli_num_rows($select_new_appointment) > 0){
				while($select_new_appointment_row = mysqli_fetch_assoc($select_new_appointment)){
					$patient_id = $select_new_appointment_row['patient_id'];
					$branch_id = $select_new_appointment_row['branch_id'];
					$real_branch_id = $select_new_appointment_row['real_branch_id'];
					$old_patient_status = $select_new_appointment_row['old_patient'];
					$appointment_id = $select_new_appointment_row['id'];
					if($real_branch_id === $branch_id){
						$select_new_count = $obj->selectData("count(id) as visit","tbl_appointment","where patient_id = $patient_id and status != 0  and appointment_taken_type = 'Offline' and  branch_id = $branch_id and id < $appointment_id");
						//echo $select_new_count;exit();
						if(mysqli_num_rows($select_new_count)){
							$select_new_count_rows = mysqli_fetch_assoc($select_new_count);
							$new_visit = $select_new_count_rows['visit'];
							if($old_patient_status != 1){
								if($new_visit > 0){
									$old_patient += 1;
								}else{
									$new_patient += 1;
								}
							}else{
								$old_patient += 1;
							}
						}
					}else{
						$branch = $branch_id;
						require_once '../../../_class_branch/query_branch.php';
						$obj_branch = new query_branch();
						$select_cross_appointment = $obj_branch->selectData('id',"tbl_appointment","where cross_appointment_id = $appointment_id ");
					//	print_r($obj_branch);exit();
						if(mysqli_num_rows($select_cross_appointment)>0){
							$select_cross_appointment_id = mysqli_fetch_assoc($select_cross_appointment);
							$c_appointment_id = $select_cross_appointment_id['id'];
							$select_new_count = $obj_branch->selectData("count(id) as visit","tbl_appointment","where patient_id = $patient_id and status != 0  and appointment_taken_type = 'Offline' and  branch_id = $branch_id and id < $c_appointment_id");
							//echo $select_new_count;exit();
							if(mysqli_num_rows($select_new_count)){
								$select_new_count_rows = mysqli_fetch_assoc($select_new_count);
								$new_visit = $select_new_count_rows['visit'];
								if($new_visit > 0){
									$old_patient += 1;
								}else{
									$new_patient += 1;
								}
							}
						}	
					}
				}
			}
			$total_patient = $old_patient + $new_patient;
			$response_arr[0]['old_patient'] = $old_patient;
			$response_arr[0]['new_patient'] = $new_patient;
			$response_arr[0]['total_patient'] = $total_patient;

			$new_online_patient = 0;
			$old_online_patient = 0;
			$select_online_appointment = $obj->selectData("id,patient_id,branch_id","tbl_appointment","where consulted_by = $login_id and status != 0  and cross_branch_status != 1 and appointment_taken_type = 'Online' and appointment_fee_status != 0 and 	online_conformation_status != 0 $where_search_data_online order by id asc");
			//echo $select_new_appointment;exit();
			if(mysqli_num_rows($select_online_appointment) > 0){
				while($select_online_appointment_row = mysqli_fetch_assoc($select_online_appointment)){
					$patient_id = $select_online_appointment_row['patient_id'];
					$branch = $select_online_appointment_row['branch_id'];

					$appointment_id = $select_online_appointment_row['id'];
					$obj_branch = new query();
					$select_online_count = $obj_branch->selectData("count(id) as visit","tbl_appointment","where patient_id = $patient_id and status != 0  and appointment_taken_type = 'Online' and id < $appointment_id and appointment_fee_status != 0");
					//echo $select_online_count;exit();
					if(mysqli_num_rows($select_online_count)){
						$select_online_count_rows = mysqli_fetch_assoc($select_online_count);
						$online_visit = $select_online_count_rows['visit'];
						if($online_visit > 0){
							$old_online_patient += 1;
						}else{
							$new_online_patient += 1;
						}
					}
				}
			}
			$select_missed_appointment = $obj->selectData("count(id) as visits ","tbl_appointment","where doctor_id = $login_id and status != 0  and cross_branch_status != 1 and appointment_taken_type = 'Online' and appointment_status = 0 and appointment_fee_status != 0 and online_confirm_date != '$c_days' and schedule_appointment = 1 $where_search_data_online");
			//echo $select_missed_appointment;exit();
			if(mysqli_num_rows($select_missed_appointment)){
				$select_missed_appointment_rows = mysqli_fetch_assoc($select_missed_appointment);
				$missed_visits = $select_missed_appointment_rows['visits'];
			}
			$total_online_patient = $old_online_patient + $new_online_patient;
			$response_arr[0]['old_online_patient'] = $old_online_patient;
			$response_arr[0]['new_online_patient'] = $new_online_patient;
			$response_arr[0]['total_online_patient'] = $total_online_patient;
			$response_arr[0]['missed_online_patient'] = $missed_visits;

		}

	}
}
echo json_encode($response_arr);
?>