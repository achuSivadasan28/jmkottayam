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
$branch_id = $_POST['branch_id'];
$select_all_patient_data = $obj->selectData("DISTINCT added_date","tbl_add_lab_data","where patient_id=$patient_id and status!=0 order by id desc");
if(mysqli_num_rows($select_all_patient_data)>0){
	$x = 0;
	while($select_all_patient_data_row = mysqli_fetch_array($select_all_patient_data)){
		$added_date = $select_all_patient_data_row['added_date'];
		$response_arr[$x]['added_date'] = $added_date;
		$select_all_patient_data_date = $obj->selectData("test_name,id,lab_report_file","tbl_add_lab_data","where added_date='$added_date' and status!=0 and lab_report_status!=0");
		if(mysqli_num_rows($select_all_patient_data_date)>0){
			$x1 = 0;
			while($select_all_patient_data_date_row = mysqli_fetch_array($select_all_patient_data_date)){
				$response_arr[$x]['lab'][$x1]['test_name'] = $select_all_patient_data_date_row['test_name'];
				$response_arr[$x]['lab'][$x1]['id'] = $select_all_patient_data_date_row['id'];
				$response_arr[$x]['lab'][$x1]['lab_report_file'] = $select_all_patient_data_date_row['lab_report_file'];
				$x1++;
			}
		}
		$x++;
	}
}

$select_all_previous_lab = $obj->selectData("date","tbl_lab_report","where ");
echo json_encode($response_arr);
?>