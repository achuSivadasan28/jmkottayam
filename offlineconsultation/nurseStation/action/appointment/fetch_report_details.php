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
$data_id = $_POST['data_id'];
$fetch_all_details = $obj->selectData("file,file_name","tbl_lab_report","where id=$data_id");
if(mysqli_num_rows($fetch_all_details)>0){
	$x = 0;
	while($fetch_all_details_row = mysqli_fetch_array($fetch_all_details)){
		$response_arr[$x]['file'] = $fetch_all_details_row['file'];
		$response_arr[$x]['file_name'] = $fetch_all_details_row['file_name'];
	}
}
echo json_encode($response_arr);
?>