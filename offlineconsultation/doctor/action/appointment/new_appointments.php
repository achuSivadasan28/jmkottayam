<?php
session_start();
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$Cdays=date('Y-m-d');
$current_Y=date('Y');
$times=date('h:i:s A');
$serach_var = $_POST['serach_var'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$where_clause_search = '';
if($serach_var != ''){
	$where_clause_search = " and (tbl_patient.name like '%$serach_var%' or tbl_patient.phone like '%$serach_var%' or tbl_patient.unique_id like '%$serach_var%' or tbl_appointment.booking_id like '%$serach_var%')";
}

if($start_date != '' and $end_date == ''){
	$start_date_Date = date("d-m-Y", strtotime($start_date));
	$where_date_clause = " and tbl_appointment.appointment_taken_date='$start_date_Date'";
}else if($end_date !='' and $start_date == ''){
	$end_date_Date = date("d-m-Y", strtotime($end_date));
	$where_date_clause = " and tbl_appointment.appointment_taken_date='$end_date_Date'";
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

if(isset($_SESSION['doctor_login_id'])){
	$login_id = $_SESSION['doctor_login_id'];
	$select_all_online = $obj->selectData("real_branch_id,branch_id,id","tbl_appointment","where tbl_appointment.doctor_id=$login_id and tbl_appointment.status!=0 and tbl_appointment.appointment_taken_type='online' and tbl_appointment.online_conformation_status=0 $where_date_clause");

	if(mysqli_num_rows($select_all_online)>0){
		$x = 0;
		while($select_all_online_rows = mysqli_fetch_assoc($select_all_online)){
			$branch_id = $select_all_online_rows['branch_id'];
			$real_branch_id = $select_all_online_rows['real_branch_id'];
			$appointment_id = $select_all_online_rows['id'];
			if($real_branch_id == $branch_id){
				$select_all_online_appointment = $obj->selectData("tbl_appointment.id,tbl_appointment.patient_id,tbl_appointment.doctor_id,tbl_appointment.appointment_date,tbl_appointment.booking_id,tbl_appointment.online_confirm_date,tbl_appointment.online_confirm_time,tbl_appointment.appointment_taken_date,tbl_appointment.google_meet,tbl_appointment.online_confirm_date,tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.place","tbl_appointment inner join tbl_patient on tbl_appointment.patient_id=tbl_patient.id","where tbl_appointment.doctor_id=$login_id and tbl_appointment.status!=0 and tbl_appointment.appointment_taken_type='online' and tbl_appointment.online_conformation_status=0 $where_clause_search and tbl_appointment.id = $appointment_id ");
				//echo $select_all_online_appointment;exit();
				if(mysqli_num_rows($select_all_online_appointment)>0){
					//$x = 0;
					while($select_all_online_appointment_row = mysqli_fetch_array($select_all_online_appointment)){
						$patient_id = $select_all_online_appointment_row['patient_id'];
						$response_arr[$x]['id'] = $select_all_online_appointment_row['id'];
						$response_arr[$x]['unique_id'] = $select_all_online_appointment_row['unique_id'];
						$response_arr[$x]['name'] = $select_all_online_appointment_row['name'];
						$response_arr[$x]['phone'] = $select_all_online_appointment_row['phone'];
						$response_arr[$x]['place'] = $select_all_online_appointment_row['place'];
						$response_arr[$x]['patient_id'] = $patient_id;
						$response_arr[$x]['appointment_date'] = $select_all_online_appointment_row['appointment_date'];
						$response_arr[$x]['booking_id'] = $select_all_online_appointment_row['booking_id'];
						$response_arr[$x]['online_confirm_date'] = $select_all_online_appointment_row['online_confirm_date'];
						$response_arr[$x]['online_confirm_time'] = $select_all_online_appointment_row['online_confirm_time'];
						$response_arr[$x]['appointment_taken_date'] = $select_all_online_appointment_row['appointment_taken_date'];
						$response_arr[$x]['google_meet'] = $select_all_online_appointment_row['google_meet'];
						$response_arr[$x]['online_confirm_date'] = $select_all_online_appointment_row['online_confirm_date'];
						//$x++;
					}
					$x++;
				}


			}else{
				require_once '../../../_class_branch/query_branch.php';
				$branch = $branch_id;
				$obj_branch = new query_branch();
				$select_appointment_cross = $obj_branch->selectData("tbl_appointment.cross_appointment_id as id,tbl_appointment.patient_id,tbl_appointment.doctor_id,tbl_appointment.appointment_date,tbl_appointment.booking_id,tbl_appointment.online_confirm_date,tbl_appointment.online_confirm_time,tbl_appointment.appointment_taken_date,tbl_appointment.google_meet,tbl_appointment.online_confirm_date,tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.place","tbl_appointment inner join tbl_patient on tbl_appointment.patient_id=tbl_patient.id","where tbl_appointment.doctor_id=$login_id and tbl_appointment.status!=0 and tbl_appointment.appointment_taken_type='online' and tbl_appointment.online_conformation_status=0 $where_clause_search and tbl_appointment.cross_appointment_id = $appointment_id");
				if(mysqli_num_rows($select_appointment_cross)>0){
					//$x = 0;
					while($select_appointment_cross_row = mysqli_fetch_array($select_appointment_cross)){
						$patient_id = $select_appointment_cross_row['patient_id'];
						$response_arr[$x]['id'] = $select_appointment_cross_row['id'];
						$response_arr[$x]['unique_id'] = $select_appointment_cross_row['unique_id'];
						$response_arr[$x]['name'] = $select_appointment_cross_row['name'];
						$response_arr[$x]['phone'] = $select_appointment_cross_row['phone'];
						$response_arr[$x]['place'] = $select_appointment_cross_row['place'];
						$response_arr[$x]['patient_id'] = $patient_id;
						$response_arr[$x]['appointment_date'] = $select_appointment_cross_row['appointment_date'];
						$response_arr[$x]['booking_id'] = $select_appointment_cross_row['booking_id'];
						$response_arr[$x]['online_confirm_date'] = $select_appointment_cross_row['online_confirm_date'];
						$response_arr[$x]['online_confirm_time'] = $select_appointment_cross_row['online_confirm_time'];
						$response_arr[$x]['appointment_taken_date'] = $select_appointment_cross_row['appointment_taken_date'];
						$response_arr[$x]['google_meet'] = $select_appointment_cross_row['google_meet'];
						$response_arr[$x]['online_confirm_date'] = $select_appointment_cross_row['online_confirm_date'];
						
					}
					$x++;
				}


			}
			//$x++;
		}
	}

}
echo json_encode($response_arr);
?>