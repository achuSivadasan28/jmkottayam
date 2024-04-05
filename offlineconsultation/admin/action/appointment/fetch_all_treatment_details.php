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
$select_all_treatment = $obj->selectData("id,treatment","tbl_treatment","where status!=0");
if(mysqli_num_rows($select_all_treatment)>0){
	$x = 0;
	while($select_all_treatment_row = mysqli_fetch_array($select_all_treatment)){
		$response_arr[$x]['id'] = $select_all_treatment_row['id'];
		$response_arr[$x]['treatment'] = $select_all_treatment_row['treatment'];
		$x++;
	}
}
echo json_encode($response_arr);
?>