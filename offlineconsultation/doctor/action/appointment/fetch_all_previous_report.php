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
$select_all_patient_data = $obj_branch->selectData("DISTINCT added_date","tbl_add_lab_data","where patient_id=$patient_id and status!=0 order by id desc");
if(mysqli_num_rows($select_all_patient_data)>0){
	$x = 0;
	while($select_all_patient_data_row = mysqli_fetch_array($select_all_patient_data)){
		$added_date = $select_all_patient_data_row['added_date'];
		$response_arr[$x]['added_date'] = $added_date;
		$select_all_patient_data_date = $obj_branch->selectData("test_name,id,lab_report_file,upload_from","tbl_add_lab_data","where added_date='$added_date' and status!=0 and patient_id=$patient_id");
		if(mysqli_num_rows($select_all_patient_data_date)>0){
			$x1 = 0;
			while($select_all_patient_data_date_row = mysqli_fetch_array($select_all_patient_data_date)){
				$response_arr[$x]['lab'][$x1]['test_name'] = $select_all_patient_data_date_row['test_name'];
				$response_arr[$x]['lab'][$x1]['id'] = $select_all_patient_data_date_row['id'];
				$response_arr[$x]['lab'][$x1]['lab_report_file'] = $select_all_patient_data_date_row['lab_report_file'];
				$response_arr[$x]['lab'][$x1]['upload_from'] = $select_all_patient_data_date_row['upload_from'];
				$x1++;
			}
		}
		$x++;
	}
}
echo json_encode($response_arr);
?>