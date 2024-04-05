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
$test_id = $_POST['test_id'];
$patient_id = $_POST['patient_id'];
$branch = $_POST['branch_id'];
require_once '../../../_class_branch/query_branch.php';
$obj_branch = new query_branch();
$check_branch_data = $obj->selectData("id,real_branch_id,branch_id","tbl_appointment","where id=$patient_id");
if(mysqli_num_rows($check_branch_data)>0){
	$check_branch_data_row = mysqli_fetch_array($check_branch_data);
	if($check_branch_data_row['real_branch_id'] == $check_branch_data_row['branch_id']){
$treatment_name = '';
$select_treat_data = $obj->selectData("treatment","tbl_treatment","where id=$test_id");
if(mysqli_num_rows($select_treat_data)>0){
	$select_treat_data_row = mysqli_fetch_array($select_treat_data);
	$treatment_name = $select_treat_data_row['treatment'];
	$patient_data_id = 0;
	$select_patient_id = $obj->selectData("patient_id","tbl_appointment","where id=$patient_id and status!=0");
	if(mysqli_num_rows($select_patient_id)>0){
		$select_patient_id_row = mysqli_fetch_array($select_patient_id);
		$patient_data_id = $select_patient_id_row['patient_id'];
	}
	$info_add_data = array(
	"appointment_id" => $patient_id,
	"patient_id" => $patient_data_id,
	"treatment_id" => $test_id,
	"treatment_name" => $treatment_name,
	"added_date" => $days,
	"added_time" => $times,
	"status" => 1
);
$obj->insertData("tbl_assigned_treatment",$info_add_data);
}
	}else{
	$select_actual_appointment_id = $obj_branch->selectData("id","tbl_appointment","where cross_appointment_id=$patient_id");
if(mysqli_num_rows($select_actual_appointment_id)>0){
	$select_actual_appointment_id_row = mysqli_fetch_array($select_actual_appointment_id);
	$patient_id = $select_actual_appointment_id_row['id'];
}
$treatment_name = '';
$select_treat_data = $obj_branch->selectData("treatment","tbl_treatment","where id=$test_id");
if(mysqli_num_rows($select_treat_data)>0){
	$select_treat_data_row = mysqli_fetch_array($select_treat_data);
	$treatment_name = $select_treat_data_row['treatment'];
	$patient_data_id = 0;
	$select_patient_id = $obj_branch->selectData("patient_id","tbl_appointment","where id=$patient_id and status!=0");
	if(mysqli_num_rows($select_patient_id)>0){
		$select_patient_id_row = mysqli_fetch_array($select_patient_id);
		$patient_data_id = $select_patient_id_row['patient_id'];
	}
	$info_add_data = array(
	"appointment_id" => $patient_id,
	"patient_id" => $patient_data_id,
	"treatment_id" => $test_id,
	"treatment_name" => $treatment_name,
	"added_date" => $days,
	"added_time" => $times,
	"status" => 1
);
$obj_branch->insertData("tbl_assigned_treatment",$info_add_data);
}

	}
}


?>