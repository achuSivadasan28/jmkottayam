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

$patient_id = $_POST['patient_id'];
$branch = $_POST['branch_id'];
require_once '../../../_class_branch/query_branch.php';
$obj_branch = new query_branch();
$select_all_patient_data = $obj_branch->selectData("DISTINCT added_date","tbl_assigned_treatment","where patient_id=$patient_id and status!=0 order by id desc");
if(mysqli_num_rows($select_all_patient_data)>0){
	$x = 0;
	while($select_all_patient_data_row = mysqli_fetch_array($select_all_patient_data)){
		$added_date = $select_all_patient_data_row['added_date'];
		$response_arr[$x]['added_date'] = $added_date;
		$select_all_patient_data_date = $obj_branch->selectData("id,treatment_name,file,file_branch","tbl_assigned_treatment","where added_date='$added_date' and patient_id=$patient_id and status!=0");
		if(mysqli_num_rows($select_all_patient_data_date)>0){
			$x1 = 0;
			while($select_all_patient_data_date_row = mysqli_fetch_array($select_all_patient_data_date)){
				$file_branch = $select_all_patient_data_date_row['file_branch'];
				$select_branch_url = $obj->selectData("branch_id,url","tbl_branch_url","where status!=0 and branch_id=$file_branch");
		if(mysqli_num_rows($select_branch_url)>0){
			$select_branch_url_row = mysqli_fetch_array($select_branch_url);
			$response_arr[$x]['treatment'][$x1]['url'] = $select_branch_url_row['url'].'offlineconsultation/treatment_staff/assets/treatmentfileupload/';
		}
				$response_arr[$x]['treatment'][$x1]['id'] = $select_all_patient_data_date_row['id'];
				$response_arr[$x]['treatment'][$x1]['treatment_name'] = $select_all_patient_data_date_row['treatment_name'];
				$response_arr[$x]['treatment'][$x1]['file'] = $select_all_patient_data_date_row['file'];
				$x1++;
			}
		}
		$x++;
	}
}
echo json_encode($response_arr);
?>