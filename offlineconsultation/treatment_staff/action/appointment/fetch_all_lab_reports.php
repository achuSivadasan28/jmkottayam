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
$test_name = '';
$id = '';
$lab_report_file = '';
$select_all_reports_date = $obj->selectData("DISTINCT added_date","tbl_add_lab_data","where patient_id=$patient_id and status!=0");
if(mysqli_num_rows($select_all_reports_date)>0){
	$x = 0;
	while($select_all_reports_date_row = mysqli_fetch_array($select_all_reports_date)){
		$added_date = $select_all_reports_date_row['added_date'];
		$response_arr[$x]['added_date'] = $added_date;
		$select_all_reports = $obj->selectData("test_name,id,lab_report_file","tbl_add_lab_data","where added_date='$added_date' and patient_id=$patient_id");
if(mysqli_num_rows($select_all_reports)>0){
	$y = 0;
	while($select_all_reports_row = mysqli_fetch_array($select_all_reports)){
		$test_name = $select_all_reports_row['test_name'];
		$id = $select_all_reports_row['id'];
		$lab_report_file = $select_all_reports_row['lab_report_file'];
		$response_arr[$x]['lab'][$y]['test_name'] = $test_name;
		$response_arr[$x]['lab'][$y]['id'] = $id;
		$response_arr[$x]['lab'][$y]['lab_report_file'] = $lab_report_file;
		$y++;
	}
}
		$x++;
	}
}

echo json_encode($response_arr);
?>