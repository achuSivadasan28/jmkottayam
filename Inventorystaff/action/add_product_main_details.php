<?php
session_start();
$response_arr = array();
if(isset($_SESSION['staffId'])){
$adminLogId = $_SESSION['staffId'];
require_once '../../_class/query.php';
$obj=new query();
$response_arr[0]['status'] = 1;
date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-Y');
$time = date('h:i:s A');
$medicine_name = $_POST['medicine_name'];
$category_id = $_POST['category_name'];
$info_insert_product = array(
	"product_name" => $medicine_name,
	"category_id" => $category_id,
	"added_date" => $date,
	"time" => $time,
	"added_by" => $adminLogId,
	"status" => 1
);
$obj->insertData("tbl_product",$info_insert_product);
$select_inserted_product_id = $obj->selectData("id","tbl_product","where product_name='$medicine_name' and category_id=$category_id and added_by=$adminLogId and status=1 ORDER BY id DESC limit 1");
if(mysqli_num_rows($select_inserted_product_id)>0){
	$select_inserted_product_id_row = mysqli_fetch_array($select_inserted_product_id);
	$product_id = $select_inserted_product_id_row['id'];
	$response_arr[0]['product_id'] = $product_id;
}

}else{
$response_arr[0]['status'] = 0;
}
echo json_encode($response_arr);
?>
