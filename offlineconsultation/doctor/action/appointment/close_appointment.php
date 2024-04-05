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
$update_close_status = array(
	"meeting_close_status" => 1
);
$obj->updateData("tbl_appointment",$update_close_status,"where id=$data_id");
//tbl_appointment
?>