<?php
session_start();
$response_arr = array();
if(isset($_SESSION['adminLogId'])){
$adminLogId = $_SESSION['adminLogId'];
require_once '../../_class/query.php';
$obj=new query();
$response_arr[0]['status'] = 1;
date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-Y');
$time = date('h:i:s A');
$medicine_name = $_POST['medicine_name'];
$category_id = $_POST['category_name'];
$urlv = $_POST['urlv'];
$info_insert_product = array(
	"product_name" => $medicine_name,
	"category_id" => $category_id,
);
$obj->updateData("tbl_product",$info_insert_product,"where id=$urlv");
}else{
$response_arr[0]['status'] = 0;
}
echo json_encode($response_arr);
?>
