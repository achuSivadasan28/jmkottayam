<?php
session_start();
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$response_data = array();
$data_id = $_POST['data_id'];
$info_del = array(
	"status" => 0
);
$obj->updateData("tbl_medicine_details",$info_del,"where id=$data_id");
//tbl_medicine_details
?>