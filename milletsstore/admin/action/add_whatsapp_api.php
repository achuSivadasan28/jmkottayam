<?php
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
require_once '../../_class/query.php';
$obj=new query();
$w_api = $_POST['w_api'];
$info_update = array(
	"status" => 0
);
$obj->updateData("api_key",$info_update,"");
$info_array = array(
	"api_key" => $w_api,
	"added_date" => $days,
	"added_time" => $times,
	"status" => 1
);
$obj->insertData("api_key",$info_array);
?>