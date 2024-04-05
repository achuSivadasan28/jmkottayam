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
$days_re=date('Y-m-d');
$c_year = date('Y');
$patient_id = $_POST['url_val'];
$branch = $_POST['branch_id'];
require_once '../../../_class_branch/query_branch.php';
$obj_branch = new query_branch();
	$select_data = $obj->selectData("id,invoice_num,invoice_num_com","tbl_treatment_invoice","where patient_id=$patient_id and status!=0");
	if(mysqli_num_rows($select_data)>0){
		$response_arr[0]['status'] = 1;
		$x = 0;
		while($select_data_row = mysqli_fetch_array($select_data)){
			$response_arr[$x]['id'] = $select_data_row['id'];
			$response_arr[$x]['invoice_num'] = $select_data_row['invoice_num'];
			$response_arr[$x]['invoice_num_com'] = $select_data_row['invoice_num_com'];
			$x++;
		}
	}else{
		$response_arr[0]['status'] = 0;
	}
echo json_encode($response_arr);
?>