<?php
session_start();
require_once '../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$bill_id = $_POST['bill_data'];
$update_arr = array(
	 "bill_gen_status" => 1
);
$obj->updateData("tbl_appointment",$update_arr,"where id=$bill_id");
?>