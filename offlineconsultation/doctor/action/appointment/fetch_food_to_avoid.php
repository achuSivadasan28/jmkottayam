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
$select_all_dite = $obj->selectData("id,food_to_avoid","tbl_food","where status!=0");
if(mysqli_num_rows($select_all_dite)>0){
	$x = 0;
	while($select_all_dite_row = mysqli_fetch_array($select_all_dite)){
		$id = $select_all_dite_row['id'];
		$food_to_avoid = $select_all_dite_row['food_to_avoid'];
		$response_arr[$x]['id'] = $id;
		$response_arr[$x]['food_to_avoid'] = $food_to_avoid;
		$x++;
	}
}
echo json_encode($response_arr);
?>