<?php
session_start();
$adminLogId = $_SESSION['adminLogId'];
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$urlv = $_POST['urlv'];
$response_arr = array();
$select_medicine_details = $obj->selectData("id,no_of_pills,price,hsn_sac,batch,expiry_date,discount,quantity,tax_data,purchased_price,purchased_date,invoice_num","tbl_medicine_details","where status!=0 and product_id=$urlv");
if(mysqli_num_rows($select_medicine_details)>0){
	$x = 0;
	while($select_medicine_details_row = mysqli_fetch_array($select_medicine_details)){
		$response_arr[$x]['id'] = $select_medicine_details_row['id'];
		$response_arr[$x]['no_of_pills'] = $select_medicine_details_row['no_of_pills'];
		$response_arr[$x]['price'] = $select_medicine_details_row['price'];
		$response_arr[$x]['hsn_sac'] = $select_medicine_details_row['hsn_sac'];
		$response_arr[$x]['batch'] = $select_medicine_details_row['batch'];
		$response_arr[$x]['expiry_date'] = $select_medicine_details_row['expiry_date'];
		$response_arr[$x]['discount'] = $select_medicine_details_row['discount'];
		$response_arr[$x]['quantity'] = $select_medicine_details_row['quantity'];
		$response_arr[$x]['tax_data'] = $select_medicine_details_row['tax_data'];
		$response_arr[$x]['purchased_price'] = $select_medicine_details_row['purchased_price'];
		$response_arr[$x]['purchased_date'] = $select_medicine_details_row['purchased_date'];
		$response_arr[$x]['invoice_num'] = $select_medicine_details_row['invoice_num'];
		$x++;
	}
}
echo json_encode($response_arr);
?>