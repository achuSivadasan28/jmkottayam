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
$select_all_staff = $obj->selectData("id,test_name,mrp","tbl_lab","where status!=0");
if(mysqli_num_rows($select_all_staff)>0){
	$x = 0;
	while($select_all_staff_row = mysqli_fetch_array($select_all_staff)){
		$response_arr[$x]['id'] = $select_all_staff_row['id'];
		$response_arr[$x]['test_name'] = $select_all_staff_row['test_name'];
		$response_arr[$x]['mrp'] = $select_all_staff_row['mrp'];
		$x++;
	}
}
echo json_encode($response_arr);
?>