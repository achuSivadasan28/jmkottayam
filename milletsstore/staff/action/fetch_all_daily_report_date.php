<?php
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$days_Y=date('Y-m-d');
$product_date_arr = array();
$response_arr = array();
$patient_date_arr = array();
$total_income = 0;
$total_price_1 = 0;
$total_quantity_1 = 0;
$response_arr[0]['data_exist'] = 0;
 $select_todays_report = $obj->selectData("sum(tbl_productdetails.total_price) as total_price","tbl_productdetails inner join tbl_customer on tbl_productdetails.customer_id=tbl_customer.id","where tbl_productdetails.status!=0 and tbl_customer.status!=0 and tbl_productdetails.added_date='$days' ORDER BY tbl_productdetails.id DESC");
$select_todays_report_row = mysqli_fetch_array($select_todays_report);
if($select_todays_report_row['total_price'] != null){
	$response_arr[0]['data_exist'] = 1;
	$response_arr[0]['date'] = $days;
	$response_arr[0]['total_price'] = $select_todays_report_row['total_price'];
}else{
	$response_arr[0]['total_price'] = 0;
}

$select_todays_report_count = $obj->selectData("count(tbl_customer.id) as customer_c","tbl_customer"," where tbl_customer.status!=0 and (tbl_customer.added_date='$days' or tbl_customer.created_date='$days_Y') ORDER BY tbl_customer.id DESC");
$select_todays_report_count_row = mysqli_fetch_array($select_todays_report_count);
if($select_todays_report_count_row['customer_c'] != null){
	$response_arr[0]['total_patient'] = $select_todays_report_count_row['customer_c'];
}else{
	$response_arr[0]['total_patient'] = 0;
}
echo json_encode($response_arr);
?>