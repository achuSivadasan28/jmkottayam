<?php
session_start();
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$data_id = $_POST['data_id'];
$info_update = array(
	"status" => 0
);
$obj->updateData("tbl_payment_option",$info_update,"where id=$data_id");
?>