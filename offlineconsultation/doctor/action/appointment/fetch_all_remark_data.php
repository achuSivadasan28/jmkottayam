<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
require_once '../../../_class_common/query_common.php';
$obj_common=new query_common();
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$c_days=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');

$patient_id = $_POST['patient_id'];
$branch = $_POST['branch_id'];
require_once '../../../_class_branch/query_branch.php';
$obj_branch = new query_branch();
$response_arr = array();
$select_all_remark = $obj_branch->selectData("id,dite_remark,appointment_date","tbl_appointment","where patient_id=$patient_id and status!=0");
if(mysqli_num_rows($select_all_remark)>0){
	$x = 0;
	while($select_all_remark_row = mysqli_fetch_array($select_all_remark)){
		if($select_all_remark_row['dite_remark'] != ''){
			$response_arr[$x]['id'] = $select_all_remark_row['id'];
			$response_arr[$x]['appointment_date'] = $select_all_remark_row['appointment_date'];
			$response_arr[$x]['dite_remark'] = $select_all_remark_row['dite_remark'];
			$x++;
		}
	}
	
}

echo json_encode($response_arr);
?>