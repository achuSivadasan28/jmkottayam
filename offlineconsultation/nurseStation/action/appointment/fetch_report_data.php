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
$unique_id = $_POST['unique_id'];
$select_report_data = $obj->selectData("id,file_name","tbl_lab_report","where patient_id='$unique_id' and status!=0");
if(mysqli_num_rows($select_report_data)>0){
	$x = 0;
	while($select_report_data_row = mysqli_fetch_array($select_report_data)){
		$response_arr[$x]['file_name'] = $select_report_data_row['file_name'];
		$response_arr[$x]['id'] = $select_report_data_row['id'];
		$x++;
	}
}
echo json_encode($response_arr);
?>