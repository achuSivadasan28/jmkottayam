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
$test_id = $_POST['test_id'];
$patient_id = $_POST['patient_id'];
$price_data = 0;
$test_name = '';
$select_price_data = $obj->selectData("mrp,test_name","tbl_lab","where id=$test_id");
if(mysqli_num_rows($select_price_data)>0){
	$select_price_data_row = mysqli_fetch_array($select_price_data);
	$price_data = $select_price_data_row['mrp'];
	$test_name = $select_price_data_row['test_name'];
	$patient_data_id = 0;
	$select_patient_id = $obj->selectData("patient_id","tbl_appointment","where id=$patient_id and status!=0");
	if(mysqli_num_rows($select_patient_id)>0){
		$select_patient_id_row = mysqli_fetch_array($select_patient_id);
		$patient_data_id = $select_patient_id_row['patient_id'];
	}
	$info_add_data = array(
	"appointment_id" => $patient_id,
	"patient_id" => $patient_data_id,
	"test_id" => $test_id,
	"test_name" => $test_name,
	"test_price" => $price_data,
	"added_date" => $days,
	"added_time" => $times,
	"status" => 1
);
$obj->insertData("tbl_add_lab_data",$info_add_data);
}
//tbl_add_lab_data
?>