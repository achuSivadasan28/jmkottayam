<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
require_once '../../../_class_common/query_common.php';
$obj_common=new query_common();
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$c_days=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');

$patient_id = $_POST['patient_id'];
$branch = $_POST['branch_id'];
require_once '../../../_class_branch/query_branch.php';
$obj_branch = new query_branch();
$select_all_appointments = $obj_branch->selectData("id,appointment_date,diet_no_of_days","tbl_appointment","where patient_id=$patient_id and status!=0 and cross_branch_status=0 ORDER BY id DESC");
if(mysqli_num_rows($select_all_appointments)>0){
	$x = 0;
	while($select_all_appointments_row = mysqli_fetch_array($select_all_appointments)){
		$appointment_id = $select_all_appointments_row['id'];
		$appointment_date = date('d-m-Y',strtotime($select_all_appointments_row['appointment_date']));
		
		$select_dite_plan = $obj_branch->selectData("diet","tbl_diet_followed","where status!=0 and appointment_id=$appointment_id");
		//echo $select_dite_plan.' , ';
		if(mysqli_num_rows($select_dite_plan)){
			$x1 = 0;
			$response_arr[$x]['id'] = $select_all_appointments_row['id'];
			$response_arr[$x]['appointment_date'] = $appointment_date;
			$response_arr[$x]['diet_no_of_days'] = $select_all_appointments_row['diet_no_of_days'];
			while($select_dite_plan_row = mysqli_fetch_array($select_dite_plan)){
				$response_arr[$x]['dite'][$x1]['dite_data'] = $select_dite_plan_row['diet'];
				$x1++;
			}
		}
		$select_food_to_avoid = $obj_branch->selectData("foods_to_be_avoided","tbl_foods_avoid","where status!=0 and appointment_id=$appointment_id");
		if(mysqli_num_rows($select_food_to_avoid)){
			$x2 = 0;
			$response_arr[$x]['id'] = $select_all_appointments_row['id'];
			$response_arr[$x]['appointment_date'] = $appointment_date;
			$response_arr[$x]['diet_no_of_days'] = $select_all_appointments_row['diet_no_of_days'];
			while($select_food_to_avoid_row = mysqli_fetch_array($select_food_to_avoid)){
				$response_arr[$x]['food_avoid'][$x2]['food_avoid_data'] = $select_food_to_avoid_row['foods_to_be_avoided'];
				$x2++;
			}
		}
		$x++;
	}
}
echo json_encode($response_arr);
?>