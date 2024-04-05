<?php
session_start();
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$customer_id = $_POST['customer_id'];
$select_all_product_sum = $obj->selectData("sum(total_price) as total_price","tbl_productdetails","where status=1 and customer_id=$customer_id");
$select_all_product_sum_row = mysqli_fetch_array($select_all_product_sum);
if($select_all_product_sum_row['total_price'] != null){
	$total_price = $select_all_product_sum_row['total_price'];
}else{
	$total_price = 0;
}
$update_total = array(
	"total_price" => $total_price,
	"total_amonut" => $total_price
);
$obj->updateData("tbl_customer",$update_total,"where id=$customer_id");
?>