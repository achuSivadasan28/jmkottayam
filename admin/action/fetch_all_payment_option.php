<?php
session_start();
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$response_arr = array();
$select_all_option = $obj->selectData("id,payment_option","tbl_payment_option","where status!=0");
if(mysqli_num_rows($select_all_option)>0){
	$x = 0;
	while($select_all_option_row = mysqli_fetch_array($select_all_option)){
		$response_arr[$x]['id'] = $select_all_option_row['id'];
		$response_arr[$x]['payment_option'] = $select_all_option_row['payment_option'];
		$x++;
	}
}
echo json_encode($response_arr);
?>