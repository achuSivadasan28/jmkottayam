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
$url_val = $_POST['url_val'];
$select_all_staff = $obj->selectData("id,test_name,mrp","tbl_lab","where status!=0");
if(mysqli_num_rows($select_all_staff)>0){
	$x = 0;
	while($select_all_staff_row = mysqli_fetch_array($select_all_staff)){
		$response_arr[$x]['id'] = $select_all_staff_row['id'];
		$response_arr[$x]['check_status'] = 0;
		$id = $select_all_staff_row['id'];
		$check_status = 0;
		$check_data = $obj->selectData("test_id","tbl_add_lab_data","where appointment_id=$url_val and status!=0");
		if(mysqli_num_rows($check_data)>0){
			while($check_data_row = mysqli_fetch_array($check_data)){
				if($check_data_row['test_id'] == $id){
					$response_arr[$x]['check_status'] = 1;
				}
			}
		}
		
		$response_arr[$x]['test_name'] = $select_all_staff_row['test_name'];
		$response_arr[$x]['mrp'] = $select_all_staff_row['mrp'];
		$x++;
	}
}
echo json_encode($response_arr);
?>