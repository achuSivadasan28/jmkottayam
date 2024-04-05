<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$search_val = $_POST['search_val'];
$start_date = $_POST['start_val'];
$end_date = $_POST['end_val'];
$where_date_serach = '';
$where_date_clause = '';

if($search_val != ''){
		$where_date_serach = " and (doctor_name like '%$search_val%')";
	}
	if($start_date != '' and $end_date == ''){
		$where_date_clause = " and appointment_date='$start_date'";
	}else if($end_date !='' and $start_date == ''){
		$where_date_clause = " and appointment_date='$end_date'";
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
					$where_date_clause .= "appointment_date='$new_date')";
				}else{
					$where_date_clause .= "appointment_date='$new_date' or ";
				}
			}
		}
	}
		
$select_all_doctors = $obj->selectData("id,login_id,doctor_name,phone_no,email","tbl_doctor","where status!=0 $where_date_serach");
//echo $select_all_doctors;exit();
if(mysqli_num_rows($select_all_doctors)>0){
	$x = 0;
	while($select_all_doctors_row = mysqli_fetch_array($select_all_doctors)){
		$response_arr[$x]['id'] = $select_all_doctors_row['id'];
		$response_arr[$x]['login_id'] = $select_all_doctors_row['login_id'];
		$login_id = $select_all_doctors_row['login_id'];
		$response_arr[$x]['doctor_name'] = $select_all_doctors_row['doctor_name'];
		$response_arr[$x]['phone_no'] = $select_all_doctors_row['phone_no'];
		$response_arr[$x]['email'] = $select_all_doctors_row['email'];
		$select_patient_list_offline = $obj->selectData("count(id) as id","tbl_appointment","where doctor_id=$login_id and appointment_status=2 and appointment_taken_type='Offline' and cross_branch_status=0  $where_date_clause");
		$select_patient_list_offline_row = mysqli_fetch_array($select_patient_list_offline);
		if($select_patient_list_offline_row['id'] != null){
			$response_arr[$x]['patient_num_offline'] = $select_patient_list_offline_row['id'];
		}
		$new_patient_count = 0;
		$select_patient_list_new_offline = $obj->selectData("patient_id,id","tbl_appointment","where doctor_id=$login_id and appointment_status=2 and appointment_taken_type='Offline' and status!=0 and cross_branch_status=0  $where_date_clause");
		if(mysqli_num_rows($select_patient_list_new_offline)>0){
			while($select_patient_list_new_offline_row = mysqli_fetch_array($select_patient_list_new_offline)){
				$patient_id = $select_patient_list_new_offline_row['patient_id'];
				$appointment_id = $select_patient_list_new_offline_row['id'];
				$check_patient_id = $obj->selectData("count(id) as id","tbl_appointment","where patient_id=$patient_id and  doctor_id=$login_id and appointment_status=2 and appointment_taken_type='Offline' and status!=0 and cross_branch_status=0 and id<=$appointment_id ");
				$check_patient_id_row = mysqli_fetch_array($check_patient_id);
				if($check_patient_id_row['id'] != null){
					if($check_patient_id_row['id'] == 1){
						$new_patient_count += 1;
					}
				}
			}
		}
		$response_arr[$x]['new_patient_count'] = $new_patient_count;
		$response_arr[$x]['old_patient_count'] =$response_arr[$x]['patient_num_offline']-$new_patient_count;
		$select_patient_list_online = $obj->selectData("count(id) as id","tbl_appointment","where doctor_id=$login_id and appointment_status=2 and appointment_taken_type='online'   $where_date_clause");
		$select_patient_list_online_row = mysqli_fetch_array($select_patient_list_online);
		if($select_patient_list_online_row['id'] != null){
			$response_arr[$x]['patient_num_online'] = $select_patient_list_online_row['id'];
		}
		
		$new_online_patient_count = 0;
		$select_patient_list_new_online = $obj->selectData("patient_id,id","tbl_appointment","where doctor_id=$login_id and appointment_status=2 and appointment_taken_type='online' and status!=0  $where_date_clause");
		if(mysqli_num_rows($select_patient_list_new_offline)>0){
			while($select_patient_list_new_online_row = mysqli_fetch_array($select_patient_list_new_online)){
				$patient_id = $select_patient_list_new_online_row['patient_id'];
				$appointment_id_online = $select_patient_list_new_online_row['id'];
				$check_patient_id_online = $obj->selectData("count(id) as id","tbl_appointment","where patient_id=$patient_id and appointment_status=2 and appointment_taken_type='online' and  doctor_id=$login_id and status!=0 and id<=$appointment_id_online ");
				$check_patient_id_online_row = mysqli_fetch_array($check_patient_id_online);
				if($check_patient_id_online_row['id'] != null){
					if($check_patient_id_online_row['id'] == 1){
						$new_online_patient_count += 1;
					}
				}
			}
		}
		$response_arr[$x]['online_old_patient_count'] =$response_arr[$x]['patient_num_online']-$new_online_patient_count;
		$response_arr[$x]['new_online_patient_count'] = $new_online_patient_count;
		$x++;
	}
}
echo json_encode($response_arr);
?>