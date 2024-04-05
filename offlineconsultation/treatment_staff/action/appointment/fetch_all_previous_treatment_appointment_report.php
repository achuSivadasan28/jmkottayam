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

$appointment_id = $_POST['appointment_id'];
$branch = $_POST['branch_id'];
$real_branch_id = 0;
$branch_id = 0;
$check_branch = $obj->selectData("real_branch_id,branch_id","tbl_appointment","where id=$appointment_id");
if(mysqli_num_rows($check_branch)>0){
	$check_branch_row = mysqli_fetch_array($check_branch);
	$real_branch_id = $check_branch_row['real_branch_id'];
	$branch_id = $check_branch_row['branch_id'];
}
if($real_branch_id == $branch_id){
		$select_all_patient_data_date = $obj->selectData("id,treatment_name,file,treatment_id","tbl_assigned_treatment","where appointment_id=$appointment_id and status!=0");
		if(mysqli_num_rows($select_all_patient_data_date)>0){
			$x1 = 0;
			while($select_all_patient_data_date_row = mysqli_fetch_array($select_all_patient_data_date)){
				$response_arr[$x1]['id'] = $select_all_patient_data_date_row['id'];
				$response_arr[$x1]['treatment_name'] = $select_all_patient_data_date_row['treatment_name'];
				$response_arr[$x1]['treatment_id'] = $select_all_patient_data_date_row['treatment_id'];
				$x1++;
			}
		}
}else{
require_once '../../../_class_branch/query_branch.php';
$obj_branch = new query_branch();
$select_appointment_id = $obj_branch->selectData("id","tbl_appointment","where cross_appointment_id=$appointment_id");
$select_appointment_id_row = mysqli_fetch_array($select_appointment_id);
$appointment_id = $select_appointment_id_row['id'];
$select_all_patient_data_date = $obj_branch->selectData("id,treatment_name,file,treatment_id","tbl_assigned_treatment","where appointment_id=$appointment_id and status!=0");
	//echo $select_all_patient_data_date;exit();
		if(mysqli_num_rows($select_all_patient_data_date)>0){
			$x1 = 0;
			while($select_all_patient_data_date_row = mysqli_fetch_array($select_all_patient_data_date)){
				$response_arr[$x1]['id'] = $select_all_patient_data_date_row['id'];
				$response_arr[$x1]['treatment_name'] = $select_all_patient_data_date_row['treatment_name'];
				$response_arr[$x1]['treatment_id'] = $select_all_patient_data_date_row['treatment_id'];
				$x1++;
			}
		}
}

echo json_encode($response_arr);
?>