<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$c_days=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');
$select_all_dite = $obj->selectData("id,dite","tbl_dite","where status!=0");
if(mysqli_num_rows($select_all_dite)>0){
	$x = 0;
	while($select_all_dite_row = mysqli_fetch_array($select_all_dite)){
		$id = $select_all_dite_row['id'];
		$dite = $select_all_dite_row['dite'];
		$response_arr[$x]['id'] = $id;
		$response_arr[$x]['dite'] = $dite;
		$x++;
	}
}
echo json_encode($response_arr);
?>